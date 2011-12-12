<?php

require_once("model/cart.php");

function finish(){
    global $twig;
    $cart = new Cart;

    // $data = "id~1||name~book-1||price~0.1||quantity~4 id~2||name~book-2||price~0.3||quantity~1";
    // $user_id = 1;
    // $session_id = "test_session";
    $chunk = $_COOKIE["sc_simpleCart_chunks"];
    if ($chunk != "0"){
        $data = $_COOKIE["sc_simpleCart_".$chunk];
    }else{
        $data = Array();
    }
    $session_id = $_COOKIE["PHPSESSID"];
    $user_id = $_SESSION["user"]["id"];
    if (!empty($data)){
        $returned = $cart->get_or_create(
            Array(
                "user_id" => $user_id,
                "session_hash" => $session_id,
            )
        );

        $cart = $returned[0];
        $created = $returned[1];

        $cart->remove_all_items();

        $items = explode(" ", $data);
        $books = Array();
        for ($i=0; $i < sizeof($items); $i++){ 
            $item_data = explode("||", $items[$i]);
            $item_id = $item_data[0];
            $item_quantity = $item_data[3];
            $id = explode("~", $item_id);
            $quantity = explode("~", $item_quantity);
            $id = $id[1];
            $quantity = $quantity[1];
            if (!empty($id)){
                array_push($books, 
                    Array(
                        $id,
                        $quantity
                    )
                );
            }
        }

        $cart->add_items($books);
    }

    echo $twig->render(
        'cart_detail.html', 
        array(
            'cart' => $cart,
        )
    );
}
?>