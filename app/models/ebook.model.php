<?php

class Ebook extends Model
{
    protected $table = "ebook";
    public $errors = [];

    protected $allowedColumns = [
        "title", "subtitle", "author_id", "isbn", "language", "edition", "publisher", "publish_date", "pages", "description", "book_cover", "file", "license_type", "borrowing_time", "librarian_id", "copyright_status", "date_added", "mod_time"

    ];

    public function getRecentEBooks(){
        $query = "SELECT 
    e.*,
    GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
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
LIMIT 10;
";
        return $this->query($query);
     
    }

   
}
