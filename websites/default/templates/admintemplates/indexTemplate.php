<?php session_start(); ?>

<main class="sidebar">

<?php
if (isset($_POST['submit'])) {
	//Password currently hard-coded, only one admin 'account'
	if ($_POST['password'] == 'letmein') {
		$_SESSION['loggedin'] = true;
	}
}


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
?>

	<?php
	require 'adminsidebarTemplate.php';
	?>

	<section class="right">
	<h2>You are now logged in</h2>
	</section>
<?php
}
//Show login page if admin is not logged in
else {
	require 'adminloginTemplate.php';
}
?>

</main>

