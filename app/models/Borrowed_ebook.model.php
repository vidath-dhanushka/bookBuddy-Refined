<?php

class Borrowed_ebook extends Model
{
    protected $table = "borrowed_ebooks";
    public $errors = [];

    protected $allowedColumns = [
        "ebook_id",
        "user_id",
        "borrow_date",
        "active"

    ];

    public function countBorrowedCopies($data)
    {
        $query = "SELECT COUNT(*) as borrowed_copies FROM {$this->table} WHERE `ebook_id` = :ebook_id AND `active` = 1 ";
        $res = $this->query($query, $data);


        if (empty($res)) {
            return false;
        }

        return $res[0];
    }

    public function countUserBorrowedBooks($data)
    {
        $query = "SELECT COUNT(*) as user_borrowed_books FROM {$this->table} WHERE `user_id` = :user_id AND `active` = 1;";
        // show($query);
        // show($data);
        // die;
        $res = $this->query($query, $data);
        if (empty($res)) {
            return false;
        }

        return $res[0];
    }
    public function getUserEbookDetails($data)
    {
        $query = "SELECT u.*, e.*, a.author_name FROM {$this->table} as u 
                  JOIN ebooks as e ON u.ebook_id = e.id 
                  JOIN authors as a ON e.author_id = a.id
                  WHERE u.user_id = :user_id;";
        //   show($query);
        //   show($data);
        $res = $this->query($query, $data);
        if (empty($res)) {
            return false;
        }

        return $res;
    }





    public function hasUserBorrowed($data)
    {
        $query = "SELECT `active` FROM {$this->table} WHERE `user_id` = :user_id AND `ebook_id` = :ebook_id AND `active` = 1 LIMIT 1;";
        $res = $this->query($query, $data);
        if (!empty($res[0])) {
            return $res[0]->active;
        } else {
            return null;
        }
    }

    public function hasUserEverBorrowed($data)
    {
        $query = "SELECT * FROM {$this->table} WHERE `user_id` = :user_id AND `ebook_id` = :ebook_id;";
        // show($data);
        // show($query);
        // die;
        $res = $this->query($query, $data);
        if (!empty($res[0])) {
            return 1;
        } else {
            return 0;
        }
    }




    public function borrowedEbookDetails($data)
    {
        $query = "SELECT * FROM {$this->table} WHERE `user_id` = :user_id AND `ebook_id` = :ebook_id AND `active` = 1;";
        $res = $this->query($query, $data);

        if (empty($res)) {
            return false;
        }

        return $res[0];
    }

    public function userBorrowing($data)
    {
        $query = "
        SELECT 
            b.*,
            e.*
        FROM 
            {$this->table} b
        JOIN 
            ebook e ON b.ebook_id = e.ebook_id
        WHERE 
            b.user_id = :user_id;
    ";

        $res = $this->query($query, $data);

        if (empty($res)) {
            return false;
        }

        return $res; // Return all rows as the user might have borrowed multiple ebooks
    }


    public function returnBorrowedEbook($data)
    {
        $query = "UPDATE {$this->table} SET `active` = 0 WHERE `id` = :id;";
        $res = $this->query($query, $data);

        if ($res === false) {
            return false;
        }

        return true;
    }
}
