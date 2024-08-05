<?php

class Ebook extends Model
{
    protected $table = "ebook";
    public $errors = [];

    protected $allowedColumns = [
        "title", "subtitle", "author_id", "isbn", "language", "edition", "publisher", "publish_date", "pages", "description", "book_cover", "file", "license_type", "borrowing_time", "librarian_id", "copyright_status", "date_added", "mod_time"

    ];

    public function getRecentEBooks()
    {
        $query = "SELECT  e.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM 
                    ebook e
                LEFT JOIN 
                    ebook_category ec ON e.ebook_id = ec.ebook_id
                LEFT JOIN 
                    category c ON ec.category_id = c.category_id
                GROUP BY 
                    e.ebook_id;
                ORDER BY 
                    e.date_added DESC
                LIMIT 10;";
        return $this->query($query);
    }

    public function getCategories()
    {
        return $this->query("SELECT category_id,name FROM category ORDER BY category_id");
    }

    public function getCategoryEBooks($id)
    {
        $query = "SELECT b.*, GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM ebook b 
                LEFT JOIN ebook_category bc ON b.ebook_id = bc.ebook_id
                LEFT JOIN category c ON bc.category_id = c.category_id
                WHERE bc.category_id = :category_id
                GROUP BY b.ebook_id
                ORDER BY b.date_added DESC;";

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
}
