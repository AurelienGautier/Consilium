<?php

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ProdLineManager.php');

class Calendar
{
	public function execute($lineId = null)
	{
		if($lineId == null)
		{
			$reservations = (new ReservationManager())->getReservations();
			$tasks = (new TaskManager())->getTasks();
			$lines = array();

			for($i = 0; $i < count($reservations); $i++)
			{
				$lines[$i] = (new ProdLineManager())->getProdLine($reservations[$i]->prodLineId);
			}
		}
		else
		{
			$reservations = (new ReservationManager())->getReservationsByLineId($lineId);
			$tasks = (new TaskManager())->getTasksByLineId($lineId);
			$lines = array();
			$lines[0] = (new ProdLineManager())->getProdLine($lineId);
		}
		
		$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

		require('Template/PrintCalendar.php');
	}
}
