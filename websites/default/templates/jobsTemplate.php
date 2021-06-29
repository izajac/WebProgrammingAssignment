<?php
	require '../database.php';
?>

<main class="sidebar">

<section class="left">
<ul>
<?php
	$categoryList = $pdo->query('SELECT * FROM category');

	foreach ($categoryList as $row) {
		//If the category is the same as the one currently selected by the user, the category is highlighted
		if (isset($_GET['categoryid']) && $row['id'] == $_GET['categoryid']) {
			echo '<li><a class="current" href="jobs?categoryid=' . $row['id'] . '">' . $row['name'] . '</a></li>';
		} 
		//Otherwise, the categories are listed normally
		else {
			echo '<li><a href="jobs?categoryid=' . $row['id'] . '">' . $row['name'] . '</a></li>';
		}
				
	}
?>
</ul>

</section>

<section class="right">
		
<form action="jobs" method="GET">
<select style="float: right" name="location">
<?php
	//Selects all unique entries from the location column in the job table
	$stmt = $pdo->prepare('SELECT DISTINCT location FROM job');
	$stmt->execute();

	//Locations are added as options in a dropdown
	foreach ($stmt as $row) {
		echo '<option value="' . $row['location'] . '">' . $row['location'] . '</option>';
	}
?>
</select>
		
<?php
	//Hidden input ensures the category is kept in the url if one is set, otherwise the jobs would only be filtered by location
	if (isset($_GET['categoryid'])) {
		echo '<input type="hidden" name="categoryid" value="' . $_GET['categoryid'] . '"/>';
	}
?>

<input style="float: right" type="submit" name="submit" value="Filter" />
</form>
		
<?php
	//Adds job category as the page header, unless no category is set
	if (isset($_GET['categoryid'])) {
		$categoryTitle = $pdo->prepare('SELECT name FROM category WHERE id = :id');
		$id = [
			'id' => $_GET['categoryid']
		];
		$categoryTitle->execute($id);
		$categoryString = $categoryTitle->fetchColumn();
			
		echo '<h1>' . $categoryString . ' Jobs</h1>';
	} else {
		echo '<h1>All Jobs</h1>';
	}
?>

<ul class="listing">

<?php
	$date = new DateTime();
	
	//Lists jobs filtered by category only
	if (isset($_GET['categoryid']) && !isset($_GET['submit'])) {
		$stmt = $pdo->prepare('SELECT * FROM job WHERE categoryId = :id AND closingDate > :date AND archived = 0');

		$values = [
			'date' => $date->format('Y-m-d'),
			'id' => $_GET['categoryid']
		];

		$stmt->execute($values);

		require 'listjobsTemplate.php';

	} 
	//Lists jobs filtered by category and location
	else if(isset($_GET['location']) && isset($_GET['categoryid']) && isset($_GET['submit'])) {
		$stmt = $pdo->prepare('SELECT * FROM job WHERE categoryId = :id AND location = :location AND closingDate > :date AND archived = 0');

		$values = [
			'date' => $date->format('Y-m-d'),
			'id' => $_GET['categoryid'],
			'location' => $_GET['location']
		];

		$stmt->execute($values);

		require 'listjobsTemplate.php';

	} 
	//Lists jobs filtered by location only
	else if(!isset($_GET['categoryid']) && isset($_GET['location']) && isset($_GET['submit'])) {
		$stmt = $pdo->prepare('SELECT * FROM job WHERE location = :location AND closingDate > :date AND archived = 0');

		$values = [
			'date' => $date->format('Y-m-d'),
			'location' => $_GET['location']
		];

		$stmt->execute($values);

		require 'listjobsTemplate.php';

	} 
	//Lists all jobs
	else {
		$stmt = $pdo->prepare('SELECT * FROM job WHERE closingDate > :date AND archived = 0');

		$values = [
			'date' => $date->format('Y-m-d')
		];

		$stmt->execute($values);

		require 'listjobsTemplate.php';

	}

?>

</ul>

</section>
</main>
