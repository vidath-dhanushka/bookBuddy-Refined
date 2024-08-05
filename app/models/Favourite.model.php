<?php

class Favourite extends Model
{
    protected $table = 'ebook_favourite';

    public function addFavourite($userId, $ebookId)
    {
        $query = "INSERT INTO ebook_favourite (user_id, ebook_id) 
              VALUES (:user_id, :ebook_id)";

        return $this->query($query, ['user_id' => $userId, 'ebook_id' => $ebookId]);
    }

    public function removeFavourite($userId, $ebookId)
    {
        $query = "DELETE FROM ebook_favourite 
              WHERE user_id = :user_id AND ebook_id = :ebook_id";

        return $this->query($query, ['user_id' => $userId, 'ebook_id' => $ebookId]);
    }

    public function isFavourite($userId, $ebookId)
    {
        $query = "SELECT COUNT(*) as count 
              FROM ebook_favourite 
              WHERE user_id = :user_id AND ebook_id = :ebook_id";

        $result = $this->query($query, ['user_id' => $userId, 'ebook_id' => $ebookId]);

        return !empty($result) && $result[0]->count > 0;
    }
}
