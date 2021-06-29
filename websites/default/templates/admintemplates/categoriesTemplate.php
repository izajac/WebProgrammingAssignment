<?php 
	session_start(); 
	require '../database.php'
?>

<main class="sidebar">

<?php require 'adminsidebarTemplate.php'; ?>

<section class="right">

<?php

	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	?>

		<h2>Categories</h2>

		<a class="new" href="addcategory">Add new category</a>

		<?php
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Name</th>';
		echo '<th style="width: 5%">&nbsp;</th>';
		echo '<th style="width: 5%">&nbsp;</th>';
		echo '</tr>';

		$categories = $pdo->query('SELECT * FROM category');

		//Lists all existing categories from the category table
		foreach ($categories as $category) {
			echo '<tr>';
			echo '<td>' . $category['name'] . '</td>';
			echo '<td><a style="float: right" href="editcategory?id=' . $category['id'] . '">Edit</a></td>';
			echo '<td><form method="post" action="deletecategory">
			<input type="hidden" name="id" value="' . $category['id'] . '" />
			<input type="submit" name="submit" value="Delete" />
			</form></td>';
			echo '</tr>';
		}

		echo '</thead>';
		echo '</table>';

	} else {
		require 'adminloginTemplate.php';
	}
?>

</section>
</main>


