<?php

class Ebook extends Model
{
    protected $table = "ebook";
    public $errors = [];

    protected $allowedColumns = [
        "title",
        "author_name",
        "isbn",
        "language",
        "edition",
        "publisher",
        "publish_date",
        "pages",
        "description",
        "book_cover",
        "file",
        "license_type",
        "librarian_id",
        "copyright_status",
        "date_added",
        "mod_time"

    ];


    private function isValidISBN($isbn)
    {
        // Remove any hyphens or spaces
        $isbn = str_replace(['-', ' '], '', $isbn);

        // Check if the ISBN is either 10 or 13 characters long
        if (strlen($isbn) !== 10 && strlen($isbn) !== 13) {
            return false;
        }

        // For ISBN-10 validation
        if (strlen($isbn) === 10) {
            if (!ctype_digit(substr($isbn, 0, 9))) {
                return false; // First 9 characters must be digits
            }

            // Calculate checksum for ISBN-10
            $checksum = 0;
            for ($i = 0; $i < 9; $i++) {
                $checksum += (int)$isbn[$i] * (10 - $i);
            }

            // The checksum of the last character
            $checksum = 11 - ($checksum % 11);
            $checksum = ($checksum == 10) ? 'X' : (string)$checksum;
            return $checksum === strtoupper($isbn[9]); // Compare checksum with last digit
        }

        // For ISBN-13 validation
        if (strlen($isbn) === 13) {
            if (!ctype_digit($isbn)) {
                return false; // All characters must be digits for ISBN-13
            }

            // Calculate checksum for ISBN-13
            $sum = 0;
            for ($i = 0; $i < 12; $i++) {
                $sum += (int)$isbn[$i] * (($i % 2 === 0) ? 1 : 3);
            }

            // The checksum of the last character
            $checksum = (10 - ($sum % 10)) % 10;
            return $checksum == $isbn[12]; // Compare checksum with last digit
        }

        // Fallback false, in case of invalid length
        return false;
    }


    private function validateEdition($edition)
    {

        if (filter_var($edition, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
            return true;
        } else {
            return false;
        }
    }

    public function isIsbnExists($isbn)
    {
        // Query to check if an ISBN exists

        $query = "SELECT COUNT(*) as count FROM ebook WHERE isbn = :isbn";

        // Execute the query
        $result = $this->query($query, ['isbn' => $isbn]);

        // Check if the result is an object (stdClass), and access it appropriately
        if ($result && isset($result[0])) {
            $row = $result[0];  // Fetch the first result

            // Check if the result is an object and access its properties correctly
            if (is_object($row)) {
                return $row->count > 0;
            } elseif (is_array($row)) {
                return $row['count'] > 0;
            }
        }

        return false;  // ISBN does not exist
    }




    public function validate($data)
    {

        $this->errors = [];
        $maxLength = 255;

        if (empty($data['title'])) {
            $this->errors['title'] = "Error: Title cannot be empty.";
        } else 
        if (strlen($data['title']) < 2) {
            $this->errors['title'] = "Error: Title should be at least 2 characters long.";
        } else
        if (strlen($data['title']) > $maxLength) {
            $this->errors['title'] =  "Error: Title cannot exceed " . $maxLength . " characters.";
        }

        if (isset($data['author_name'])) {
            if (empty($data['author_name'])) {
                $this->errors['author_name'] = "Error: Author name is required.";
            } elseif (!preg_match("/^[a-zA-Z-' .]*$/", $data["author_name"])) {
                $this->errors['author_name'] = "Error: Only letters, white space, hyphen, period, and apostrophe are allowed in author name";
            }
        }
        if (empty($data['pages']) && $data['pages'] !== '0') {
            $this->errors['pages'] = "Error: Number of pages cannot be empty.";
        } else if ($data['pages'] == '0') {
            $this->errors['pages'] = "Error: Number of pages cannot be zero.";
        } else if ($data['pages'] < 0) {
            $this->errors['pages'] = "Error: Number of pages must be a positive number.";
        }


        if (isset($data['isbn']) && !empty(trim($data['isbn']) && $data['isbn'] != "")) {
            if (!$this->isValidISBN($data['isbn'])) {
                $this->errors['isbn'] = "Error: The ISBN format is invalid.";
            } elseif ($this->isIsbnExists($data['isbn'])) {
                $this->errors['isbn'] = "Error: The ISBN already exists in the database.";
            }
        }


        if (isset($data['edtion']) && !$this->validateEdition($data['edtion'])) {
            $this->errors['isbn'] = "Error: The Edition format is invalid.";
        }

        if (empty($data['language'])) {
            $this->errors['language'] = "Error: Language cannot be empty.";
        }

        if (empty($data['license_type'])) {
            $this->errors['license_type'] = "Error: License Type cannot be empty.";
        }

        if (empty($data['publisher'])) {
            $this->errors['publisher'] = "Error: Publisher cannot be empty.";
        }
        if (empty($data['publish_date'])) {
            $this->errors['publish_date'] = "Error: Please provide a value for the publish_date.";
        } else if (!DateTime::createFromFormat('Y-m-d', $data['publish_date'])) {
            $this->errors['publish_date'] = "Error: The publish date should be a date in 'Y-m-d' format.";
        } else {
            $publishDate = DateTime::createFromFormat('Y-m-d', $data['publish_date']);
            $currentDate = new DateTime();

            if ($publishDate > $currentDate) {
                $this->errors['publish_date'] = "Error: The publish_date cannot be a future date.";
            }
        }

        if (empty($data['description'])) {
            $this->errors['description'] = "Error: Please provide a value for the description.";
        } else if (strlen($data['description']) < 10 || strlen($data['description']) > 1000) {
            $this->errors['description'] = "Error: The description should be between 10 and 1000 characters long.";
        }

        if (empty($data['book_cover']) && !isset($_SESSION["temp_cover_path"])) {
            $this->errors['book_cover'] = "Error: Please provide a value for the cover_image.";
        }

        if (empty($data['file']) && !isset($_SESSION["temp_file_path"])) {
            $this->errors['file'] = "Error: Please provide a value for the file.";
        }
        if (empty($data['category'])) {
            $this->errors['category'] = "Error: Please select at least one category.";
        }


        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function editValidate($data)
    {

        $this->errors = [];
        $maxLength = 255;

        if (empty($data['title'])) {
            $this->errors['title'] = "Error: Title cannot be empty.";
        } else 
        if (strlen($data['title']) < 2) {
            $this->errors['title'] = "Error: Title should be at least 2 characters long.";
        } else
        if (strlen($data['title']) > $maxLength) {
            $this->errors['title'] =  "Error: Title cannot exceed " . $maxLength . " characters.";
        }

        if (isset($data['author_name'])) {
            if (empty($data['author_name'])) {
                $this->errors['author_name'] = "Error: Author name is required.";
            } elseif (!preg_match("/^[a-zA-Z-' .]*$/", $data["author_name"])) {
                $this->errors['author_name'] = "Error: Only letters, white space, hyphen, period, and apostrophe are allowed in author name";
            }
        }
        if (empty($data['pages']) && $data['pages'] !== '0') {
            $this->errors['pages'] = "Error: Number of pages cannot be empty.";
        } else if ($data['pages'] == '0') {
            $this->errors['pages'] = "Error: Number of pages cannot be zero.";
        } else if ($data['pages'] < 0) {
            $this->errors['pages'] = "Error: Number of pages must be a positive number.";
        }


        if (isset($data['isbn']) && !empty(trim($data['isbn']) && $data['isbn'] != "")) {
            if (!$this->isValidISBN($data['isbn'])) {
                $this->errors['isbn'] = "Error: The ISBN format is invalid.";
            } elseif ($this->isIsbnExists($data['isbn'])) {
                $this->errors['isbn'] = "Error: The ISBN already exists in the database.";
            }
        }


        if (isset($data['edtion']) && !$this->validateEdition($data['edtion'])) {
            $this->errors['isbn'] = "Error: The Edition format is invalid.";
        }

        if (empty($data['language'])) {
            $this->errors['language'] = "Error: Language cannot be empty.";
        }

        if (empty($data['license_type'])) {
            $this->errors['license_type'] = "Error: License Type cannot be empty.";
        }

        if (empty($data['publisher'])) {
            $this->errors['publisher'] = "Error: Publisher cannot be empty.";
        }
        if (empty($data['publish_date'])) {
            $this->errors['publish_date'] = "Error: Please provide a value for the publish_date.";
        } else if (!DateTime::createFromFormat('Y-m-d', $data['publish_date'])) {
            $this->errors['publish_date'] = "Error: The publish date should be a date in 'Y-m-d' format.";
        } else {
            $publishDate = DateTime::createFromFormat('Y-m-d', $data['publish_date']);
            $currentDate = new DateTime();

            if ($publishDate > $currentDate) {
                $this->errors['publish_date'] = "Error: The publish_date cannot be a future date.";
            }
        }

        if (empty($data['description'])) {
            $this->errors['description'] = "Error: Please provide a value for the description.";
        } else if (strlen($data['description']) < 10 || strlen($data['description']) > 1000) {
            $this->errors['description'] = "Error: The description should be between 10 and 1000 characters long.";
        }

        if (isset($data['book_cover']) && empty($data['book_cover'])) {
            $this->errors['book_cover'] = "Error: Please provide a value for the book cover.";
        }


        if (isset($data['file']) && empty($data['file'])) {
            $this->errors['file'] = "Error: Please provide a value for the file.";
        }

        if (empty($data['category'])) {
            $this->errors['category'] = "Error: Please select at least one category.";
        }


        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function getRecentEBooks()
    {
        $query = "SELECT  e.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM 
                    ebook e
                LEFT JOIN 
                    ebook_category ec ON e.ebook_id = ec.ebook_id
                LEFT JOIN 
                    category c ON ec.category_id = c.category_id
                 WHERE 
                  e.copyright_status = 1
                GROUP BY 
                    e.ebook_id;
                ORDER BY 
                    e.date_added DESC
                LIMIT 10;";
        return $this->query($query);
    }

    public function getCategories()
    {
        return $this->query("SELECT * FROM category ORDER BY category_id");
    }

    public function getCategoryEBooks($id)
    {
        $query = "
                SELECT b.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM ebook b 
                LEFT JOIN ebook_category bc ON b.ebook_id = bc.ebook_id
                LEFT JOIN category c ON bc.category_id = c.category_id
                WHERE bc.category_id = :category_id
                AND b.copyright_status = 1
                GROUP BY b.ebook_id
                ORDER BY b.date_added DESC;
            ";


        return $this->query($query, ['category_id' => $id]);
    }

    public function getEbookDetails($id)
    {
        $query = "SELECT b.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
            FROM ebook b 
            LEFT JOIN ebook_category bc ON b.ebook_id = bc.ebook_id
            LEFT JOIN category c ON bc.category_id = c.category_id
            WHERE b.ebook_id = :ebook_id
            LIMIT 1;";
        $result = $this->query($query, ['ebook_id' => $id]);
        return !empty($result) ? $result[0] : null;
    }

    public function getAllEBooks()
    {
        $query = "SELECT * FROM ebook ORDER BY date_added DESC";
        return $this->query($query);
    }

    public function getEbookDetailsForEdit($id)
    {
        // Query to get eBook details
        $query = "
        SELECT *
        FROM ebook
        WHERE ebook_id = :ebook_id
    ";

        // Execute the query with the provided eBook ID
        $ebook = $this->query($query, ['ebook_id' => $id]);

        // Return null if no eBook is found
        if (empty($ebook)) {
            return null;
        }

        $ebook = $ebook[0]; // Assuming query() returns an array of results

        // Query to get associated categories
        $queryCategories = "
        SELECT category.category_id, category.name
        FROM ebook_category
        LEFT JOIN category ON ebook_category.category_id = category.category_id
        WHERE ebook_category.ebook_id = :ebook_id
    ";

        // Execute the query to get categories
        $categories = $this->query($queryCategories, ['ebook_id' => $id]);

        // Build the categories array
        $ebook->categories = [];
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $ebook->categories[] = [
                    'category_id' => $category->category_id,
                    'name' => $category->name,
                ];
            }
        }

        return $ebook; // Return the eBook object with categories
    }

    public function get_file($data)
    {
        $query =  "SELECT `file` FROM `ebook` WHERE `ebook_id` = :book_id;";
        $res = $this->query($query, $data);
        if (is_array($res)) {
            return $res[0];
        } else {
            return false;
        }
    }

    public function getEbookCount()
    {
        $query = "SELECT COUNT(*) AS ebook_count FROM ebook";
        $result = $this->query($query);

        if ($result) {
            return $result[0]->ebook_count;
        }
        return 0;
    }

    public function calculateProfit()
    {

        $query_subscription = "
            SELECT SUM(s.price) AS total_revenue
            FROM member_subscription ms
            JOIN subscription s ON ms.subscription_id = s.subscription_id
            WHERE s.status = 'active' AND ms.end_date >= NOW();";

        $subscription_result = $this->query($query_subscription);

        $total_revenue = $subscription_result[0]->total_revenue;


        $query_copyright = "
            SELECT SUM(c.copyright_fee) AS total_copyright_fee
            FROM copyright c
            WHERE c.license_end_date >= NOW();";

        $copyright_result = $this->query($query_copyright);
        $total_copyright_fee = $copyright_result[0]->total_copyright_fee;


        $total_profit = $total_revenue - $total_copyright_fee;

        return $total_profit;
    }

    function getProfitabilityData()
    {

        // Query to get monthly subscription revenue
        $query_subscription_revenue = "
                SELECT
                    MONTH(date_added) AS month,
                    SUM(price) AS revenue
                FROM member_subscription
                JOIN subscription ON member_subscription.subscription_id = subscription.subscription_id
                WHERE YEAR(date_added) = YEAR(CURDATE()) -- Current year
                GROUP BY MONTH(date_added)
            ";

        // Query to get monthly copyright expenses
        $query_copyright_expenses = "
                SELECT
                    MONTH(license_start_date) AS month,
                    SUM(copyright_fee) AS expenses
                FROM copyright
                WHERE YEAR(license_start_date) = YEAR(CURDATE()) -- Current year
                GROUP BY MONTH(license_start_date)
            ";


        $subscription_data = $this->query($query_subscription_revenue);
        $copyright_data = $this->query($query_copyright_expenses);



        // Initialize arrays for the chart data
        $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $revenue = array_fill(0, 12, 0); // Initialize an array for subscription revenue
        $expenses = array_fill(0, 12, 0); // Initialize an array for copyright expenses
        $profit = array_fill(0, 12, 0);   // Initialize an array for profit

        // Populate revenue data
        foreach ($subscription_data as $row) {

            $revenue[$row->month - 1] = $row->revenue;
        }

        // Populate copyright expenses data
        foreach ($copyright_data as $row) {
            $expenses[$row->month - 1] = $row->expenses;
        }

        // Calculate profit (revenue - expenses)
        for ($i = 0; $i < 12; $i++) {
            $profit[$i] = $revenue[$i] - $expenses[$i];
        }

        // Return the formatted data for the chart
        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'expenses' => $expenses,
            'profit' => $profit
        ];
    }
}
