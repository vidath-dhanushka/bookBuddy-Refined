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
            bb.user = :user
        ORDER BY
            bb.reg_time DESC;",
            ['user' => $userId]
        );
    }

    public function getOrderBooks($id)
    {
        return $this->query("SELECT 
    bb.*, 
    b.title, 
    b.weight, 
    b.owner, 
    b.price,
    u.first_name, 
    u.last_name, 
    u.address_line1, 
    u.address_line2, 
    u.address_city, 
    u.address_district,
    u.phone
FROM 
    book_borrow bb
LEFT JOIN 
    book b ON b.book_id = bb.book
LEFT JOIN 
    user u ON u.user_id = b.owner
WHERE 
    bb.orderNo = :orderNo;", ["orderNo" => $id]);
    }

    public function updateBookBorrowStatus($id, $status)
    {
        return $this->query("UPDATE book_borrow SET status = :status WHERE book_borrow_id = :id", ['id' => $id, 'status' => $status]);
    }
}
