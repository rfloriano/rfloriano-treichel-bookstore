<?php

require_once("model/book.php");

function index(){
    global $twig;
    $books = new Book();
    echo $twig->render(
        'books_list.html', 
        array(
            'books' => $books->all(),
        )
    );
}

function detalhe($id){
    global $twig;
    $book = new Book();
    echo $twig->render(
        'book_detail.html', 
        array(
            'book' => $book->get("id = $id"),
        )
    );
}
?>