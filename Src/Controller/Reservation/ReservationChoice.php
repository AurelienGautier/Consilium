<?php

require_once('Src/Model/ReservationManager.php');

class ReservationChoice
{
    public function execute()
    {
        $reservations = (new ReservationManager())->getReservations();
        $prodLines = array();

        for($i = 0; $i < count($reservations); $i++)
        {
            $prodLines[$i] = (new ProdLineManager())->getProdLine($reservations[$i]->prodLineId);
        }

        require('Template/ReservationChoice.php');
    }
}
