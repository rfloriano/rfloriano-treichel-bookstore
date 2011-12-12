<?php

	require_once("lib/resolvers.php");
	require_once("routes.php");

	$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$path = explode($_SERVER['DOCUMENT_ROOT'], $_SERVER['SCRIPT_FILENAME']);
	$documentRoot = $path[1];

	$mediaUrl = explode("/index.php", $documentRoot);
	$mediaUrl = $mediaUrl[0];

	if (!endsWith($mediaUrl, "/")){
		$mediaUrl .= "/";
	}

	$mediaUrl .= "media/";

	$resolver = explode($documentRoot, $url);
	$resolver = $resolver[1];

	if (startsWith($resolver, "/")){
		$resolver = substr($resolver, 1);
	}
	
	if (endsWith($resolver, "/")){
		$resolver = substr($resolver, 0, -1);
	}

	$data = explode("/", $resolver);

	$location = "/";
	if (sizeof($data) > 0 && !empty($data[0])){
		$location .= $data[0]."/";
		unset($data[0]);
	}

	$view = "index";
	if (sizeof($data) > 0 && !empty($data[1])){
		$view = $data[1];
		unset($data[1]);
	}

	require_once("defaults.php");
	require_once($routes[$location]);

	if (function_exists($view)){
		call_user_func_array($view, $data);
	}else{
		echo die("Page not found");
	}

	global $_messages;
	print_r($_messages);

	// echo $_SESSION["message"];
	// if (!empty($_SESSION["message"]) && $_SESSION["message_showed"]){
	// 	echo "111111111";
	// 	$_SESSION["message"] = NULL;
	// 	$_SESSION["message_showed"] = false;
	// }else if (!empty($_SESSION["message"])){
	// 	echo "2222222222";
	// 	$_SESSION["message_showed"] = true;
	// }else{
	// 	echo "3333333333";
	// 	$_SESSION["message_showed"] = false;
	// }
	// echo (!empty($_SESSION["message"]) && $_SESSION["message_showed"]);
?>