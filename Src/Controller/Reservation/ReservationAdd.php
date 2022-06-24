<?php

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/ProdLineManager.php');

class ReservationAdd
{
    public function execute(string $step, $fields)
    {
        if($step == 'form')
        {
            $prodLines = (new ProdLineManager())->getProdLines();
            require('Template/ReservationAdd.php');
        }
        else if($step == 'insert')
        {
            (new ReservationManager())->insertReservation($fields['taskDate'],
                                                          $fields['endTaskDate'],
                                                          $fields['calendarColor'],
                                                          $fields['taskService']);

            header('Location:index.php?action=printCalendar');
        }
    }
}
