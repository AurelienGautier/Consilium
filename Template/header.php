<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<title>Page Title</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel='stylesheet' href='Public/style.css'>
	<script type='text/javascript' src='Js/script.js'></script>
	<script type='text/javascript' src='Js/YearlyCalendar.js'></script>
	<script type='text/javascript' src='Js/MonthlyCalendar.js'></script>
</head>
<body>
	<header>
		<div class="nav-button">
			<a class="nav-button" href="index.php?action=addReservation&step=form">Créer une nouvelle tâche</a>
			<ul>
				<li><a href="index.php?action=addReservation&step=form">Réserver une ligne</a></li>
				<li><a href="index.php?action=reservationChoice">Ajouter une tâche</a></li>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=printYearlyCalendar">Affichage annuel</a>
			<ul>
				<?php
					foreach($lines as $line)
					{
						echo '<li><a href=index.php?action=printYearlyCalendar&lineId='.$line->id.'>'.$line->name.'</a></li>';
					}
				?>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=printMonthlyCalendar">Affichage mensuel</a>
		</div>

		<div class="nav-button">
			<a class="nav-button">Ajouter des données</a>
			<ul>
				<li><a href="index.php?action=addData&step=form&dataToAdd=supplier">Fournisseur</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=prodLine">Ligne de production</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=machine">Machine</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=taskType">Type de tâche</a></li>
			</ul>
		</div>
	</header>
