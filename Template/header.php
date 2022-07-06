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
			<a class="nav-button" href="index.php?action=addReservation&step=form">Nouvelle planification</a>
			<ul>
				<li><a href="index.php?action=addReservation&step=form">Réserver une ligne</a></li>
				<li><a href="index.php?action=reservationChoice&for=addTask">Ajouter une tâche</a></li>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=reservationChoice&for=modifyReservation">Modifier une planification</a>
			<ul>
				<li><a href="index.php?action=reservationChoice&for=modifyReservation">Ligne réservée</a></li>
				<li><a href="index.php?action=reservationChoice&for=modifyTask">Modifier une tâche</a></li>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=reservationChoice&for=deleteReservation">Supprimer une planification</a>
			<ul>
				<li><a href="index.php?action=reservationChoice&for=deleteReservation">Ligne réservée</a></li>
				<li><a href="index.php?action=reservationChoice&for=deleteTask">Supprimer une tâche</a></li>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=printYearlyCalendar">Affichage annuel</a>
			<ul>
				<?php
					foreach($lines as $line)
					{
						echo '<li><a href=index.php?action=printYearlyCalendar&lineId='.htmlspecialchars($line->id).'>'.htmlspecialchars($line->name).'</a></li>';
					}
				?>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="index.php?action=printMonthlyCalendar">Affichage mensuel</a>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="#">Afficher des données</a>
			<ul>
				<li><a href="index.php?action=printData&dataToPrint=supplier">Fournisseurs</a></li>
				<li><a href="index.php?action=printData&dataToPrint=prodLine">Lignes de production</a></li>
				<li><a href="index.php?action=printData&dataToPrint=machine">Machines</a></li>
				<li><a href="index.php?action=printData&dataToPrint=taskType">Types de tâche</a></li>
			</ul>
		</div>

		<div class="nav-button">
			<a class="nav-button" href="#">Ajouter des données</a>
			<ul>
				<li><a href="index.php?action=addData&step=form&dataToAdd=supplier">Fournisseur</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=prodLine">Ligne de production</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=machine">Machine</a></li>
				<li><a href="index.php?action=addData&step=form&dataToAdd=taskType">Type de tâche</a></li>
			</ul>
		</div>
	</header>
