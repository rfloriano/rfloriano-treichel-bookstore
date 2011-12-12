<?php
    require_once("model/base.php");
    require_once("model/book.php");

    class Item extends Model {
        var $cart_id;
        var $book_id;
        var $quantity;

        public function getBook(){
            $book = new Book();
            return $book->get(
                "id = ".$this->book_id
            );
        }
    }
?>