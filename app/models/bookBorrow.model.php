<?php

class BookBorrow extends Model
{
    protected $table = "book_borrow";

    public function getBorrowedBook($bookId, $userId)
    {
        return $this->where(['book' => $bookId, 'user' => $userId]);
    }
}
