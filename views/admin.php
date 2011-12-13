<?php

require_once("model/user.php");
require_once("model/cart.php");
require_once("model/item.php");
require_once("model/author.php");
require_once("model/categorie.php");
require_once("model/book.php");
require_once("model/book_author.php");
require_once("model/book_categorie.php");

function login_required(){
    if (!is_logged()){
        die('Permission denied');
    }

    $id = $_SESSION['user']['id'];
    $user = new User();
    return $user->get(
        "id = '$id'"
    );
}

function admin_required(){
    $user = login_required();
    if (!$user->admin){
        die('You need to be admin to access this page');
    }
    return $user;
}

function is_logged(){
    return (!empty($_SESSION['user']));
}

function index(){
    $user = admin_required();
    global $twig;
    echo $twig->render(
        'admin_index.html'
    );
}

function admin_list($object, $type){
    global $twig;
    $properties = (array) $object;
    $headers = Array();
    foreach ($properties as $key => $value) {
        array_push($headers, $key);
    }
    $objects = $object->all();
    echo $twig->render(
        "admin_list.html",
        array(
            "type" => $type,
            "object_list" => $objects,
            "headers" => $headers,
        )
    );
}

function admin_edit($object, $type, $id, $action){
    global $twig;
    $properties = (array) $object;
    $headers = Array();
    foreach ($properties as $key => $value) {
        array_push($headers, $key);
    }
    $creating = 1;
    if ($id != "add"){
        $object = $object->get("id = ".$id);
        $creating = 0;
    }

    if ($action == "delete"){
        $object->delete();
        header('Location: '.$_SERVER["HTTP_REFERER"].'');
    }

    $message = Array();

    if ($_POST){
        foreach ($_POST as $key => $value) {
            $object->$key = $value;
        }
        $object->save();

        $message = Array(
            "text" => "Seus dados do ".$type." foram salvos com sucesso!",
            "type" => "success",
        );
    }
    
    echo $twig->render(
        "admin_edit.html",
        array(
            "type" => $type,
            "object" => $object,
            "headers" => $headers,
            "creating" => $creating,
            "message" => $message
        )
    );
}

function user($id=NULL, $action=NULL){
    admin_required();
    $type = "usuários";
    $user = new User();

    if (!empty($id)){
        admin_edit($user, $type, $id, $action);
    }else{
        admin_list($user, $type);
    }
}

function cart($id=NULL, $action=NULL){
    admin_required();
    $type = "carrinho";
    $cart = new Cart();

    if (!empty($id)){
        admin_edit($cart, $type, $id, $action);
    }else{
        admin_list($cart, $type);
    }
}

function item($id=NULL, $action=NULL){
    admin_required();
    $type = "item";
    $item = new Item();

    if (!empty($id)){
        admin_edit($item, $type, $id, $action);
    }else{
        admin_list($item, $type);
    }
}

function author($id=NULL, $action=NULL){
    admin_required();
    $type = "autor";
    $author = new Author();

    if (!empty($id)){
        admin_edit($author, $type, $id, $action);
    }else{
        admin_list($author, $type);
    }
}

function categorie($id=NULL, $action=NULL){
    admin_required();
    $type = "categoria";
    $categorie = new Categorie();

    if (!empty($id)){
        admin_edit($categorie, $type, $id, $action);
    }else{
        admin_list($categorie, $type);
    }
}

function book($id=NULL, $action=NULL){
    admin_required();
    $type = "livro";
    $book = new Book();

    if (!empty($id)){
        admin_edit($book, $type, $id, $action);
    }else{
        admin_list($book, $type);
    }
}

function bookauthor($id=NULL, $action=NULL){
    admin_required();
    $type = "livro-autor";
    $bookauthor = new BookAuthor();

    if (!empty($id)){
        admin_edit($bookauthor, $type, $id, $action);
    }else{
        admin_list($bookauthor, $type);
    }
}

function bookcategorie($id=NULL, $action=NULL){
    admin_required();
    $type = "livro-categoria";
    $bookcategorie = new BookCategorie();

    if (!empty($id)){
        admin_edit($bookcategorie, $type, $id, $action);
    }else{
        admin_list($bookcategorie, $type);
    }
}

function login(){
    global $twig;
    $user = new User();
    $login = $_REQUEST["login"];
    $password = $_REQUEST["password"];
    try {
        $user = $user->get(
            "username = '$login' AND password = '$password'"
        );
        $_SESSION['user']['id'] = $user->id;
        $_SESSION['user']['name'] = $user->name;
        $_SESSION['user']['username'] = $user->username;
    } catch (Exception $e) {
        $_SESSION['user'] = NULL;
    }
    header('Location: '.$_SERVER["HTTP_REFERER"]);
}

function logout(){
    global $documentRoot;
    $_SESSION['user'] = NULL;
    header('Location: '.$documentRoot);
}

function settings(){
    $user = login_required();

    $message = Array();

    if ($_POST){
        foreach ($_POST as $key => $value) {
            $user->$key = $value;
        }
        $user->save();

        $message = Array(
            "text" => "Seus dados foram salvos com sucesso!",
            "type" => "success",
        );
    }

    global $twig;
    echo $twig->render(
        'user_detail.html', 
        Array(
            'user' => $user,
            'message' => $message
        )
    );
}
?>