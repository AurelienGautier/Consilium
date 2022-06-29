<?php

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ProdLineManager.php');

class MonthlyCalendar
{
    public function execute()
    {
        $reservations = (new ReservationManager())->getReservations();
        $tasks = (new TaskManager())->getTasks();
        $lines = (new ProdLineManager())->getProdLines();

        $months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

        require('Template/MonthlyCalendar.php');
    }
}
