<?php 
	session_start(); 
	require '../database.php'
?>

	<main class="sidebar">

	<?php require 'adminsidebarTemplate.php'; ?>

	<section class="right">

	<?php


	if (isset($_POST['submit'])) {

		$stmt = $pdo->prepare('UPDATE job
								SET title = :title,
								    description = :description,
								    salary = :salary,
								    location = :location,
								    categoryId = :categoryId,
								    closingDate = :closingDate,
									archived = :archive
								   WHERE id = :id
						');

		$criteria = [
			'title' => $_POST['title'],
			'description' => $_POST['description'],
			'salary' => $_POST['salary'],
			'location' => $_POST['location'],
			'categoryId' => $_POST['categoryId'],
			'closingDate' => $_POST['closingDate'],
			'archive' => $_POST['archive'],
			'id' => $_POST['id']
		];

		$stmt->execute($criteria);


		echo 'Job saved';
	}
	else {
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

			$stmt = $pdo->prepare('SELECT * FROM job WHERE id = :id');

			$stmt->execute($_GET);

			$job = $stmt->fetch();
		?>

			<h2>Edit Job</h2>

			<form action="editjob" method="POST">

				<input type="hidden" name="id" value="<?php echo $job['id']; ?>" />
				<label>Title</label>
				<input type="text" name="title" value="<?php echo $job['title']; ?>" />

				<label>Description</label>
				<textarea name="description"><?php echo $job['description']; ?></textarea>

				<label>Location</label>
				<input type="text" name="location" value="<?php echo $job['location']; ?>" />


				<label>Salary</label>
				<input type="text" name="salary" value="<?php echo $job['salary']; ?>" />

				<label>Category</label>

				<select name="categoryId">
				<?php
					$stmt = $pdo->prepare('SELECT * FROM category');
					$stmt->execute();

					foreach ($stmt as $row) {
						if ($job['categoryId'] == $row['id']) {
							echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
						}
						else {
							echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
						}

					}

				?>

				</select>

				<label>Closing Date</label>
				<input type="date" name="closingDate" value="<?php echo $job['closingDate']; ?>"  />

				<!--Added functionality to edit job for, admin now has the option to archive job listings instead of deleting them-->
				<label>Archive?</label>
				<input type="hidden" name="archive" value="0" />
				<input type="checkbox" name="archive" value="1" />

				<input type="submit" name="submit" value="Save" />

			</form>

		<?php
		}

		else {
			require 'adminloginTemplate.php';
		}

	}
	?>

</section>
	</main>


