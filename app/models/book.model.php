<?php

class Book extends Model
{
    protected $table = "book";
    public $errors = [];

    protected $allowedColumns = [
        'title',
        'description',
        'author',
        'language',
        'isbn',
        'price',
        'weight',
        'owner',
        'status',
        'duration',
        'book_image',
    ];

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['title'])) {
            $this->errors['title'] = "Please enter the title of the book";
        }
        if (empty($data['description'])) {
            $this->errors['description'] = "Please enter a small desciption about the book";
        }
        if (empty($data['author'])) {
            $this->errors['author'] = "Please enter the author name";
        }
        if (empty($data['language'])) {
            $this->errors['language'] = "Please select the language of the book";
        }
        if (empty($data['isbn'])) {
            $this->errors['isbn'] = "Please enter the isbn of the book";
        }
        if (empty($data['price'])) {
            $this->errors['price'] = "Please enter a price for the book";
        }
        if (empty($data['weight'])) {
            $this->errors['weight'] = "Please enter the weight of the book";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    public function lendedBooks($id)
    {
        // $data['user_id'] = $id;
        return $this->query(
            "SELECT book_id,
        title,
        description,
        language,
        isbn,
        price,
        status,
        weight,
        author,
        book_image,
        GROUP_CONCAT(c.name) AS categories 
        FROM book b 
        LEFT JOIN book_category bc ON b.book_id = bc.book 
        LEFT JOIN category c ON bc.category = c.category_id 
        WHERE b.owner = :owner 
        GROUP BY b.book_id 
        ORDER BY b.reg_time DESC;",
            ['owner' => $id]
        );
    }

    public function getBookDetails($id)
    {
        return $this->query(
            "SELECT 
            book_id,
            title,
        description,
        language,
        isbn,
        price,
        weight,
        owner,
        status,
        author,
        book_image,
        GROUP_CONCAT(c.name) AS categories 
        FROM book b 
        LEFT JOIN book_category bc ON b.book_id = bc.book 
        LEFT JOIN category c ON bc.category = c.category_id 
        WHERE b.book_id = :book_id",
            ['book_id' => $id]
        );
    }

    public function deleteBookCategories($id)
    {
        $this->query("DELETE FROM book_category WHERE book = :book", ['book' => $id]);
    }

    public  function getRecentBooks()
    {
        return $this->query("SELECT 
        book_id,
        title,
        price,
        author,
        book_image,
        GROUP_CONCAT(c.name) AS categories 
        FROM book b 
        LEFT JOIN book_category bc ON b.book_id = bc.book 
        LEFT JOIN category c ON bc.category = c.category_id 
        GROUP BY b.book_id 
        ORDER BY b.reg_time DESC 
        LIMIT 8");
    }

    public function getAllBooks()
    {
        return $this->query("SELECT 
        b.book_id,
        b.title,
        b.description,
        b.language,
        b.isbn,
        b.price,
        b.status,
        b.weight,
        b.condition,
        b.duration,
        b.owner,
        b.author,
        b.book_image,
        GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
    FROM 
        book b
    LEFT JOIN 
        book_category bc ON b.book_id = bc.book
    LEFT JOIN 
        category c ON bc.category = c.category_id
    GROUP BY 
        b.book_id
    ORDER BY 
        b.reg_time DESC;
     ");
    }

    public function getCategories()
    {
        return $this->query("SELECT category_id,name FROM category ORDER BY category_id");
    }

    public function getCategoryBooks($id)
    {
        return $this->query("SELECT 
        b.book_id,
        b.title,
        b.description,
        b.language,
        b.isbn,
        b.price,
        b.status,
        b.weight,
        b.condition,
        b.duration,
        b.owner,
        b.author,
        b.book_image,
        GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
    FROM 
        book b
    LEFT JOIN 
        book_category bc ON b.book_id = bc.book
    LEFT JOIN 
        category c ON bc.category = c.category_id
    WHERE 
        bc.category = :category_id
    GROUP BY 
        b.book_id
    ORDER BY 
        b.reg_time DESC;
     ", ['category_id' => $id]);
    }

    public function getUserRatings($userId)
    {
        return $this->query("SELECT 
            ur.book,
            ur.user_rating_id,
            u.username AS borrower_username,
            ur.lender,
            ur.rating,
            ur.reg_time
        FROM user_rating ur
        JOIN 
            user u ON ur.borrower = u.user_id
        JOIN 
            book b ON ur.book = b.book_id
        WHERE b.owner = :owner", ['owner' => $userId]);
    }
}
