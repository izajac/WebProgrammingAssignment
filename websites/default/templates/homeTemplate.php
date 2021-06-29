<main class="home">

<p>Welcome to Jo's Jobs, we're a recruitment agency based in Northampton. We offer a range of different office jobs. Get in touch if you'd like to list a job with us.</a></p>

<h2>Select the type of job you are looking for:</h2>
<ul>

<?php
    require '../database.php';
    $categoryList = $pdo->query('SELECT * FROM category');
    $stmt = $pdo->prepare('SELECT * FROM job WHERE closingDate > :date AND archived = 0 ORDER BY closingDate ASC');
    $date = new DateTime();
    $values = [
        'date' => $date->format('Y-m-d'),
    ];
    $stmt->execute($values);
    $i = 0;

    //Lists all existing categories from the category table as links
    foreach ($categoryList as $row) {
		echo '<li><a href="jobs?categoryid=' . $row['id'] . '">' . $row['name'] . '</a></li>';
    }

    echo '<h1>Job Offers Ending Soon</h1>';
    
    //Lists 10 jobs closest to the closing date
    foreach ($stmt as $job) {
        if ($i == 10) { break; }
        
        echo '<li>';

        echo '<div class="details">';
        echo '<h2>' . $job['title'] . '</h2>';
        echo '<h3>' . $job['salary'] . '</h3>';
        echo '<p>' . nl2br($job['description']) . '</p>';

        echo '<a class="more" href="/apply?id=' . $job['id'] . '">Apply for this job</a>';

        echo '</div>';
        echo '</li>';
        
        $i++;
    }
?>

</ul>
</li>

</main>