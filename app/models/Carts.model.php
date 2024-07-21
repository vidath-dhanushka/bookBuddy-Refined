<?php

class Carts extends Model
{
    protected $table = 'cart';

    public function getItems($userId)
    {
        return $this->query("SELECT b.book_id,c.cart_id,b.title,b.book_image,b.author,b.price,b.status,b.weight,b.owner FROM cart c LEFT JOIN book b ON b.book_id = c.book WHERE c.user = :user", ['user' => $userId]);
    }

    public function removeItem($cartId)
    {
        $this->query("DELETE FROM cart WHERE cart_id = :cartId", ['cartId' => $cartId]);
    }
}
