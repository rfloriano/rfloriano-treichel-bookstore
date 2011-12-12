<?php
    require_once('lib/Twig/Autoloader.php');
    require_once("model/categorie.php");

    session_start();

    $categories = new Categorie();

    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, 
        array(
            // 'cache' => 'tmp/compilation_cache',
            'defaultContext' => array(
                'media_url' => $mediaUrl,
                'url_root' => $documentRoot."/",
                'session' => $_SESSION,
                'cetegories_list' => $categories->all(),
            )
        )
    );
?>