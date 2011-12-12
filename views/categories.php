<?php

require_once("model/categorie.php");

function index(){
    global $twig;
    $categories = new Categorie();
    echo $twig->render(
        'categorie_list.html', 
        array(
            'categories' => $categories->all(),
        )
    );
}

function detalhe($id){
    global $twig;
    $categorie = new Categorie();
    echo $twig->render(
        'categorie_detail.html', 
        array(
            'categorie' => $categorie->get("id = $id"),       )
    );
}
?>