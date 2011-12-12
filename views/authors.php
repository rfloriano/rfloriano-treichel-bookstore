<?php

require_once("model/author.php");

function index(){
    global $twig;
    $authors = new Author();
    echo $twig->render(
        'author_list.html', 
        array(
            'authors' => $authors->all(),
        )
    );
}

function detalhe($id){
    global $twig;
    $author = new Author();
    echo $twig->render(
        'author_detail.html', 
        array(
            'author' => $author->get("id = $id"),
        )
    );
}

?>