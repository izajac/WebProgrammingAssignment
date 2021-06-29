<?php

//Taken from Topic 14
$filepath = '../' . ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/') . '.php';

require '../loadTemplate.php';
if ($_SERVER['REQUEST_URI'] !== '/') {
	//Checks if filepath in the URI exists
	if (file_exists($filepath)) {
		require $filepath;
	} else if ($_SERVER['REQUEST_URI'] == '/admin') {
		require '../admin/index.php';
	} 
	//If the filepath does not exist, redirect to the homepage
	else {
		require '../home.php';
	}
} 
//If the URI is empty, redirect to the homepage
else {
	require '../home.php';
}
require '../layout.php';
?>