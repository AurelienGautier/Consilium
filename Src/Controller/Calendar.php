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

        require('Template/PrintCalendar.php');
    }
}
