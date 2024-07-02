<?php

class Category extends Model
{
    protected $table = 'category';


    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        return $this->query($query);
    }

    public function insertBookCategory($data)
    {
        $keys = array_keys($data);
        $query = "INSERT INTO book_category (" . implode(",", $keys) . ") VALUES (:" . implode(",:", $keys) . ")";
        $this->query($query, $data);
    }

    public function getSelectedCategories($id)
    {
        return $this->query("SELECT * FROM book_category WHERE book_id = :book_id", ['book_id' => $id]);
    }
}
