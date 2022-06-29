<div id="container">
	<div id="legend">
		<?php
			for($i = 0; $i < count($reservations); $i++)
			{
				echo '<div class="legend-pack">';
				echo '<div class="legend-color" id="'.$reservations[$i]->color.'"></div>';
				echo $lines[$i]->name;
				echo '</div>';
			}
		?>
	</div>

	<div id="calendar">
		
		<div id="nav-link">
			<div id="previous"><button>Précédent</button></div>
			<div id="next"><button>Suivant</button></div>
		</div>
		
		<table>
			<caption id="year"></caption>
			<?php
				// Print the months
				echo('<thead>');
				echo('<th></th>');

				for($i = 0; $i < 12; $i++) echo('<th>'.$months[$i].'</th>');

				echo('</thead>');

				// Print the days
				echo('<tbody id="dates">');

				for($i = 1; $i <= 31; $i++)
				{
					echo '<tr><th>'.$i.'</th>';

					for($j = 1; $j <= 12; $j++)
					{
						echo '<td></td>';
					}

					echo '</tr>';
				}

				echo('</tbody>');
			?>

		</table>
	</div>
</div>

<script>
	let tasks = <?php echo json_encode($tasks); ?>;
	let reservations = <?php echo json_encode($reservations); ?>;
	let lines = <?php echo json_encode($lines); ?>;

	calendar = new YearlyCalendar(tasks, reservations, lines);
	calendar.load();

	let next = document.getElementById("next");
	let previous = document.getElementById("previous");

	next.onclick = function() { calendar.changeYear('next'); }
	previous.onclick = function() { calendar.changeYear('previous'); } 

	let legends = document.getElementsByClassName("legend-color");

	for(legend of legends) legend.style['background-color'] = legend.id;
</script>