<?php
//Loop used for listing jobs on several pages
foreach ($stmt as $job) {
			echo '<li>';

			echo '<div class="details">';
			echo '<h2>' . $job['title'] . '</h2>';
			echo '<h3>' . $job['salary'] . '</h3>';
			echo '<p>' . nl2br($job['description']) . '</p>';

			echo '<a class="more" href="/apply?id=' . $job['id'] . '">Apply for this job</a>';

			echo '</div>';
			echo '</li>';
        }
?>