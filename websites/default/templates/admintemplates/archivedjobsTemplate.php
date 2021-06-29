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

		<h2>Archived Jobs</h2>

		<?php
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Title</th>';
		echo '<th style="width: 15%">Salary</th>';
		echo '<th>Catgeory</th>';
		echo '<th style="width: 5%">&nbsp;</th>';
		echo '<th style="width: 15%">&nbsp;</th>';
		echo '<th style="width: 5%">&nbsp;</th>';
		echo '<th style="width: 5%">&nbsp;</th>';
		echo '</tr>';

		$stmt = $pdo->query('SELECT * FROM job WHERE archived = 1');

		//Only lists jobs which have been archived, these can then be edited and reused for listings with the same job information
		foreach ($stmt as $job) {
			$applicants = $pdo->prepare('SELECT count(*) as count FROM applicants WHERE jobId = :jobId');
			$category = $pdo->prepare('SELECT name FROM category WHERE id = :categoryId');

			$applicants->execute(['jobId' => $job['id']]);
			$category->execute(['categoryId' => $job['categoryId']]);

			$applicantCount = $applicants->fetch();
			$categoryName = $category->fetch();

			echo '<tr>';
			echo '<td>' . $job['title'] . '</td>';
			echo '<td>' . $job['salary'] . '</td>';
			echo '<td>' . $categoryName['name'] . '</td>';
			echo '<td><a style="float: right" href="editjob?id=' . $job['id'] . '">Edit</a></td>';
			echo '<td><a style="float: right" href="applicants?id=' . $job['id'] . '">View applicants (' . $applicantCount['count'] . ')</a></td>';
			echo '<td><form method="post" action="deletejob">
				<input type="hidden" name="id" value="' . $job['id'] . '" />
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
