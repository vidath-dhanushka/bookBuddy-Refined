<?php

class BookRating extends Model
{
    protected $table = 'book_rating';

    protected $allowedColumns = [
        'book',
        'user',
        'rating',
        'review'
    ];

    public function isReviewed($userId, $bookId)
    {
        return $this->query("SELECT book_rating_id FROM book_rating WHERE user=:user AND book=:book", ['book' => $bookId, 'user' => $userId]);
    }

    public function getReviews($id)
    {
        return $this->query("SELECT u.username,b.rating,b.review FROM book_rating b LEFT JOIN user u ON u.user_id = b.user WHERE book =:book", ['book' => $id]);
    }
}
