<?php

function index(){
	global $twig;
	echo $twig->render('hello.html', array('name' => 'Rafael'));
}

?>