<?php

class Ebook_review extends Model
{
    protected $table = "ebook_review";
    public $errors = [];

    protected $allowedColumns = [
        'ebook_id',
        'user_id',
        'rating',
        'description',
        'date'
    ];

    public function get_review($params)
    {

        if (!isset($params['ebook_id']) || empty($params['ebook_id'])) {
            $this->errors[] = "Ebook ID is required.";
            return false;
        }

        $sql = "
            SELECT 
                r.*,
                u.username AS username,
                u.email AS user_email
            FROM 
                " . $this->table . " r
            JOIN 
                user u ON r.user_id = u.user_id
            WHERE 
                r.ebook_id = :ebook_id
            ORDER BY 
                r.date DESC
        ";

        return $this->query($sql, ['ebook_id' => $params['ebook_id']]);
    }

    public function get_average_rating($data)
    {
        $query = "SELECT AVG(rating) as average_rating
                  FROM {$this->table}
                  WHERE ebook_id = :ebook_id";
        // print_r($data);
        // echo $query;
        // die;
        $res = $this->query($query, $data);

        if (is_array($res) && count($res) > 0) {
            return $res[0]->average_rating;
        }

        return false;
    }

    public function get_review_count($data)
    {
        $query = "SELECT COUNT(*) as review_count
                  FROM {$this->table}
                  WHERE ebook_id = :ebook_id";
        $res = $this->query($query, $data);

        if (is_array($res) && count($res) > 0) {
            return $res[0]->review_count;
        }

        return false;
    }

    public function get_rating_counts($data)
    {
        $query = "SELECT rating, COUNT(*) as count
                  FROM {$this->table}
                  WHERE ebook_id = :ebook_id
                  GROUP BY rating ORDER BY rating DESC";
        $res = $this->query($query, $data);

        if (is_array($res) && count($res) > 0) {
            return $res;
        }

        // If no ratings are found, return an array with a count of 0 for each rating
        $res = [];
        for ($i = 5; $i >= 1; $i--) {
            $res[] = (object) ['rating' => $i, 'count' => 0];
        }

        return $res;
    }

    public function get_user_review($data)
    {
        $query = "SELECT *
                  FROM {$this->table}
                  WHERE ebook_id = :ebook_id AND user_id = :user_id";
        // show($data);
        // show($query);
        // die;
        $res = $this->query($query, $data);

        if (is_array($res) && count($res) > 0) {
            return $res[0];
        }

        return false;
    }

    public function deleteUserReview($data)
    {
        $query = "DELETE FROM {$this->table} WHERE `user_id` = :user_id AND `ebook_id` = :ebook_id";
        // show($query);
        // show($data);
        $res = $this->query($query, $data);

        if ($res) {
            return true;
        }

        return false;
    }

    public function verify_review($data)
    {

        $this->errors = [];
        $query = "SELECT ebook_id, user_id FROM `ebook_review` WHERE ebook_id=:ebook_id AND user_id=:user_id";
        $res = $this->query($query, $data);
        // show($res);
        // die;
        if (is_array($res) && count($res) > 0) {
            $this->errors['title'] = "Your review already added.";
        }

        if (empty($this->errors)) {

            return true;
        } else {

            return false;
        }
    }

    public function addReview($data)
    {
        $query = "INSERT INTO {$this->table} (ebook_id, user_id, rating, description) VALUES (:ebook_id, :user_id, :rating, :description)";
        // echo $query;
        // print_r($data);
        // die;
        $res = $this->query($query, $data);

        if ($res) {
            return true;
        }

        return false;
    }
}
