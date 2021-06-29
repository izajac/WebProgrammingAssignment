<?php
//Date variable used in footer so copyright year is up-to-date
$date = new DateTime();
require 'database.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
		<title><?=$title?></title>
	</head>
	<body>
	<header>
		<section>
			<aside>
				<h3>Office Hours:</h3>
				<p>Mon-Fri: 09:00-17:30</p>
				<p>Sat: 09:00-17:00</p>
				<p>Sun: Closed</p>
			</aside>
			<h1>Jo's Jobs</h1>

		</section>
	</header>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li>Jobs
				<ul>
				<?php
					//Lists all existing categories from Category table
					$categoryList = $pdo->query('SELECT * FROM category');

					foreach ($categoryList as $row) {
						echo '<li><a href="/jobs?categoryid=' . $row['id'] . '">' . $row['name'] . '</a></li>';
					}
				?>
				</ul>
			</li>
			<li><a href="/about">About Us</a></li>
			<li><a href="/faq">FAQ</a></li>
		</ul>

	</nav>
<img src="images/randombanner.php"/>

<?=$content?>

<footer>
	&copy; Jo's Jobs <?=$date->format('Y');?>
</footer>
</body>
</html>