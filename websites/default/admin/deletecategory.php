<?php
require '../database.php';
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

	$stmtCategory = $pdo->prepare('DELETE FROM category WHERE id = :id');
	$stmtJobs = $pdo->prepare('DELETE FROM job WHERE categoryId = :id');
	$stmtCategory->execute(['id' => $_POST['id']]);
	$stmtJobs->execute(['id' => $_POST['id']]);


	header('location: /admin/categories');
}


