<?php

/*
 * This file is the controller used to print planified reservations and tasks
 * on a yearly calendar
 */

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ProdLineManager.php');

class YearlyCalendar
{
	/**
	 * Print the yearly calendar filled with planified reservations and tasks
	 * 
	 * @param $lineId The id of the line for which we want to print reservations (null to print every lines)
	 */
	public function execute($lineId = null)
	{
		if($lineId == null) // Get every task
		{
			$lines = (new ProdLineManager())->getProdLines();
			$reservations = (new ReservationManager())->getReservations();
			$tasks = (new TaskManager())->getTasks();
		}
		else if((new ProdLineManager())->isExisting($lineId)) // Get only tasks from the specified line id
		{
			$lines = array();
			$lines[0] = (new ProdLineManager())->getProdLine($lineId);
			$reservations = (new ReservationManager())->getReservationsByLineId($lineId);
			$tasks = (new TaskManager())->getTasksByLineId($lineId);
		}
		else
		{
			throw new Exception('Ligne de production inexistante.');
		}
		
		$months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

		require('Template/PrintCalendar.php');
	}
}
