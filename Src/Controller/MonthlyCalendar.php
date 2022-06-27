<?php

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ProdLineManager.php');

class MonthlyCalendar
{
    public function execute(int $month)
    {
        $reservations = (new ReservationManager())->getReservations();
        $tasks = (new TaskManager())->getTasks();
        $lines = (new ProdLineManager())->getProdLines();

        require('Template/MonthlyCalendar.php');
    }
}
