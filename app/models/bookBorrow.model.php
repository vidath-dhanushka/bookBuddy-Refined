<?php

class BookBorrow extends Model
{
    protected $table = "book_borrow";

    protected $allowedColumns = [
        'book',
        'user',
        'orderNo',
        'status'
    ];

    public function getBorrowedBook($bookId, $userId)
    {
        return $this->where(['book' => $bookId, 'user' => $userId]);
    }

    public function getAllBorrowedBooks($userId)
    {
        return $this->query(
            "SELECT 
            b.book_id,
            b.title,
            b.author,
            b.book_image,
            b.price,
            bb.reg_time 
        FROM 
            book_borrow bb 
        LEFT JOIN 
            book b 
        ON b.book_id = bb.book 
        WHERE 
            bb.user = :user;",
            ['user' => $userId]
        );
    }
}
