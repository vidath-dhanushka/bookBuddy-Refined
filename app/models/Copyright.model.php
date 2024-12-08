<?php

class Copyright extends Model
{
    protected $table = "copyright";
    public $errors = [];

    protected $allowedColumns = [
        'copyright_id',
        'ebook_id',
        'agreement',
        'license_type',
        'licensed_copies',
        'copyright_fee',
        'license_start_date',
        'license_end_date',
        'date_added',
        'modify_date'
    ];


    function validate($data)
    {

        // show($data);
        // die;
        if (
            (!isset($data['agreement']) || empty($data['agreement'])) &&
            (!isset($_SESSION['agreement']) || empty($_SESSION['agreement']))
        ) {
            $this->errors['agreement'] = "Agreement is required.";
        }



        // Validate 'license_type'
        $validLicenseTypes = ['cc0', 'cc_by', 'cc_by_sa', 'cc_by_nc_sa', 'cc_by_nc', 'cc_by_nc_nd', 'cc_by_nd'];
        if (!isset($data['license_type']) || empty($data['license_type']) || $data['license_type'] == "default") {
            $this->errors['license_type'] = "Licensed type is required.";
        } else
        if (!isset($data['license_type']) || !in_array($data['license_type'], $validLicenseTypes)) {
            $this->errors['license_type'] = "Invalid license type.";
        }

        if (!isset($data['licensed_copies'])) {
            $this->errors['licensed_copies'] = "Licensed copies is required.";
        } elseif ($data['licensed_copies'] === 0 || $data['licensed_copies'] === '0') {
            $this->errors['licensed_copies'] = "Licensed copies cannot be zero.";
        } elseif ($data['licensed_copies'] === '' || $data['licensed_copies'] === null) {
            $this->errors['licensed_copies'] = "Licensed copies is required.";
        } elseif (!filter_var($data['licensed_copies'], FILTER_VALIDATE_INT)) {
            $this->errors['licensed_copies'] = "Licensed copies must be an integer.";
        } elseif ($data['licensed_copies'] < 0) {
            $this->errors['licensed_copies'] = "Licensed copies must be a positive integer.";
        }


        // Validate 'copyright_fee'
        if (!isset($data['copyright_fee']) || empty($data['copyright_fee'])) {
            $this->errors['copyright_fee'] = "Copyright fee is required.";
        } elseif (!is_numeric($data['copyright_fee'])) {
            $this->errors['copyright_fee'] = "Copyright fee must be a number.";
        } elseif ($data['copyright_fee'] <= 0) {
            $this->errors['copyright_fee'] = "Copyright fee must be a positive number.";
        }

        // Validate 'license_start_date'
        if (empty($data['license_start_date'])) {
            $this->errors['license_start_date'] = "License start date is required.";
        } elseif (!strtotime($data['license_start_date'])) {
            $this->errors['license_start_date'] = "License start date must be a valid date.";
        }

        // Validate 'license_end_date'
        if (empty($data['license_end_date'])) {
            $this->errors['license_end_date'] = "License end date is required.";
        } elseif (!strtotime($data['license_end_date'])) {
            $this->errors['license_end_date'] = "License end date must be a valid date.";
        } elseif (strtotime($data['license_end_date']) < strtotime($data['license_start_date'])) {
            $this->errors['license_end_date'] = "License end date cannot be before the start date.";
        }
        if (!isset($data['subscriptions']) || empty($data['subscriptions'])) {
            $this->errors['subscriptions'] = "Error: Please select at least one subscription.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }

    function edit_validate($data)
    {




        // Validate 'license_type'
        $validLicenseTypes = ['cc0', 'cc_by', 'cc_by_sa', 'cc_by_nc_sa', 'cc_by_nc', 'cc_by_nc_nd', 'cc_by_nd'];
        if (!isset($data['license_type']) || empty($data['license_type']) || $data['license_type'] == "default") {
            $this->errors['license_type'] = "Licensed type is required.";
        } else
        if (!isset($data['license_type']) || !in_array($data['license_type'], $validLicenseTypes)) {
            $this->errors['license_type'] = "Invalid license type.";
        }

        if (!isset($data['licensed_copies'])) {
            $this->errors['licensed_copies'] = "Licensed copies is required.";
        } elseif ($data['licensed_copies'] === 0 || $data['licensed_copies'] === '0') {
            $this->errors['licensed_copies'] = "Licensed copies cannot be zero.";
        } elseif ($data['licensed_copies'] === '' || $data['licensed_copies'] === null) {
            $this->errors['licensed_copies'] = "Licensed copies is required.";
        } elseif (!filter_var($data['licensed_copies'], FILTER_VALIDATE_INT)) {
            $this->errors['licensed_copies'] = "Licensed copies must be an integer.";
        } elseif ($data['licensed_copies'] < 0) {
            $this->errors['licensed_copies'] = "Licensed copies must be a positive integer.";
        }


        // Validate 'copyright_fee'
        if (!isset($data['copyright_fee']) || empty($data['copyright_fee'])) {
            $this->errors['copyright_fee'] = "Copyright fee is required.";
        } elseif (!is_numeric($data['copyright_fee'])) {
            $this->errors['copyright_fee'] = "Copyright fee must be a number.";
        } elseif ($data['copyright_fee'] <= 0) {
            $this->errors['copyright_fee'] = "Copyright fee must be a positive number.";
        }

        // Validate 'license_start_date'
        if (empty($data['license_start_date'])) {
            $this->errors['license_start_date'] = "License start date is required.";
        } elseif (!strtotime($data['license_start_date'])) {
            $this->errors['license_start_date'] = "License start date must be a valid date.";
        }

        // Validate 'license_end_date'
        if (empty($data['license_end_date'])) {
            $this->errors['license_end_date'] = "License end date is required.";
        } elseif (!strtotime($data['license_end_date'])) {
            $this->errors['license_end_date'] = "License end date must be a valid date.";
        } elseif (strtotime($data['license_end_date']) < strtotime($data['license_start_date'])) {
            $this->errors['license_end_date'] = "License end date cannot be before the start date.";
        }
        if (!isset($data['subscription']) || empty($data['subscription'])) {
            $this->errors['subscription'] = "Error: Please select at least one subscription.";
        }

        if (empty($this->errors)) {
            return true;
        }

        return false;
    }


    public function get_all_copyrights()
    {
        $sql = "
    SELECT 
        c.*, 
        e.title AS ebook_title
    FROM 
        " . $this->table . " c
    INNER JOIN 
        ebook e ON c.ebook_id = e.ebook_id
    ORDER BY 
        c.date_added DESC
    ";

        return $this->query($sql);
    }



    public function get_copyright_by_id($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
            $this->errors[] = "Invalid ID provided.";
            return false;
        }

        // Define the SQL query to select the copyright by ID
        $sql = "
        SELECT 
            c.*,
            e.title AS ebook_title
        FROM 
            " . $this->table . " c
        JOIN 
            ebook e ON c.ebook_id = e.ebook_id
        WHERE 
            c.copyright_id = :id
        LIMIT 1
        ";

        $result = $this->query($sql, ['id' => $id]);

        if (!empty($result) && count($result) > 0) {
            return $result[0];
        }

        return false;
    }


    public function delete_copyright_by_id($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT, array("options" => array("min_range" => 1)))) {
            $this->errors[] = "Invalid ID provided.";
            return false;
        }

        $checkSql = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE copyright_id = :id";
        $checkResult = $this->query($checkSql, ['id' => $id]);

        if ($checkResult[0]->count == 0) {
            $this->errors[] = "No record found with the given ID.";
            return false;
        }

        $sql = "
        DELETE FROM 
            " . $this->table . "
        WHERE 
            copyright_id = :id
        LIMIT 1
        ";

        $result = $this->query($sql, ['id' => $id]);

        if ($result && $result->rowCount() > 0) {
            return true;
        } else {
            $this->errors[] = "Failed to delete the copyright record.";
            return false;
        }
    }


    public function getCopyright($data)
    {
        $query = "SELECT * FROM copyright WHERE ebook_id =:ebook_id;";
        $res = $this->query($query, $data);
        return $res[0];
    }

    public function insertEBookCopyright($data)
    {
        $keys = array_keys($data);
        $query = "INSERT INTO ebook_copyright (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        // show($query);
        // die;

        $this->query($query, $data);
    }

    public function updateStatus($data)
    {
        $query = "UPDATE ebook 
          SET copyright_status = :status
          WHERE ebook_id = :ebook_id";
        $this->query($query, $data);
    }

    public function deleteEbookCopyright($data)
    {
        $query = "DELETE FROM ebook_copyright WHERE ebook_id = :ebook_id";
        $this->query($query, $data);
    }

    public function getSubscriptionsByEbookId($data)
    {
        $query = "
        SELECT s.subscription_id, s.name
        FROM ebook_copyright ec
        INNER JOIN subscription s ON ec.subscription_id = s.subscription_id
        WHERE ec.ebook_id = :ebook_id
    ";

        $result = $this->query($query, $data);
        return $result;
    }
}
