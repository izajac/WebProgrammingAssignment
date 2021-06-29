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

		<h2>Jobs</h2>
		<a class="new" href="addjob">Add new job</a>
		<br />
		<form action="jobs" method="GET">
			<select style="float: right" name="categoryId">
				<?php
					$stmt = $pdo->prepare('SELECT * FROM category');
					$stmt->execute();

					foreach ($stmt as $row) {
						echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
					}

				?>
			</select>
			<input style="float: right" type="submit" name="submit" value="Filter" />
		</form>

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

		//Lists jobs sorted by category
		if (isset($_GET['categoryId']) && isset($_GET['submit'])) {
			$stmt = $pdo->prepare('SELECT * FROM job WHERE categoryId = :id AND archived = 0');
			$stmt->execute(['id' => $_GET['categoryId']]);

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
		} 
		//Lists all jobs in the job table
		else {
			$stmt = $pdo->query('SELECT * FROM job WHERE archived = 0');

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
		}


		echo '</thead>';
		echo '</table>';

	}
	//Show login page if the admin has not logged in
	else {
		require 'adminloginTemplate.php';
	}
?>

</section>
</main>



