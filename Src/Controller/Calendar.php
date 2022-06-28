<?php

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ProdLineManager.php');

class Calendar
{
	public function execute()
	{
		$reservations = (new ReservationManager())->getReservations();
		$tasks = (new TaskManager())->getTasks();
		$lines = array();
		
		for($i = 0; $i < count($reservations); $i++)
		{
			$lines[$i] = (new ProdLineManager())->getProdLine($reservations[$i]->prodLineId);
		}
		
		$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
		$year = 2022;

		require('Template/PrintCalendar.php');
	}
}
