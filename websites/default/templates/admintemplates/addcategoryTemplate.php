<?php 
	session_start(); 
	require '../database.php'
?>
	
<main class="sidebar">

<?php require 'adminsidebarTemplate.php'; ?>

<section class="right">

<?php

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

		if (isset($_POST['submit'])) {

			$stmt = $pdo->prepare('INSERT INTO category (name) VALUES (:name)');

			$criteria = [
				'name' => $_POST['name']
			];

			$stmt->execute($criteria);
			echo 'Category added';
		} else {
		?>

			<h2>Add Category</h2>

			<form action="" method="POST">
				<label>Name</label>
				<input type="text" name="name" />


				<input type="submit" name="submit" value="Add Category" />

			</form>

		<?php
		}

	} else {
		require 'adminloginTemplate.php';
	}
?>


</section>
</main>

