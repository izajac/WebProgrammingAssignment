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

			$stmt = $pdo->prepare('INSERT INTO job (title, description, salary, location, closingDate, categoryId)
							   		VALUES (:title, :description, :salary, :location, :closingDate, :categoryId)');

			$criteria = [
				'title' => $_POST['title'],
				'description' => $_POST['description'],
				'salary' => $_POST['salary'],
				'location' => $_POST['location'],
				'categoryId' => $_POST['categoryId'],
				'closingDate' => $_POST['closingDate'],
			];

			$stmt->execute($criteria);

			echo 'Job Added';
		} else {

			?>

			<h2>Add Job</h2>

			<form action="addjob" method="POST">
				<label>Title</label>
				<input type="text" name="title" />

				<label>Description</label>
				<textarea name="description"></textarea>

				<label>Salary</label>
				<input type="text" name="salary" />

				<label>Location</label>
				<input type="text" name="location" />

				<label>Category</label>

				<select name="categoryId">
				<?php
					$stmt = $pdo->prepare('SELECT * FROM category');
					$stmt->execute();

					foreach ($stmt as $row) {
						echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
					}

				?>

				</select>

				<label>Closing Date</label>
				<input type="date" name="closingDate" />

				<input type="submit" name="submit" value="Add" />

			</form>

		<?php
		}
	} else {
		require 'adminloginTemplate.php';
	}

	?>

</section>
</main>



