<?php

/*
 * This file is the controller used to planify a reservation of a line
 * It manages the form to fill and the insertion in db at the same time
 * It knows what to do thanks to the step variable
 */

require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/ProdLineManager.php');

class ReservationController
{
    /**
     * Execute the differents steps to add a reservation
     * 
     * @param string $step The action to accomplish (print form or insert in db)
     * @param array $fields Data from the form : null if the step is form
     */
    public function add(string $step, array $fields)
    {
        if($step == 'form')
        {
            $this->printAddReservationForm();
        }
        else if($step == 'insert')
        {
            $this->insertReservation($fields);
        }
        // If the step variable is incorrect
        else
        {
            header('Location:index.php?action=addReservation&step=form');
        }
    }

    /**
     * Print the form to add a reservation
     */
    public function printAddReservationForm()
    {
        $prodLines = (new ProdLineManager())->getProdLines();
        require('Template/ReservationAdd.php');
    }

    /**
     * Insert the reservation data into db from the form
     * 
     * @param array $fields Data from the form
     */
    public function insertReservation(array $fields)
    {
        (new ReservationManager())->insertReservation($fields['taskDate'],
                                                      $fields['endTaskDate'],
                                                      $fields['calendarColor'],
                                                      $fields['taskService']);

        // A redirection is made on the yearly calendar to immediatly see the change
        header('Location:index.php?action=printYearlyCalendar');
    }

    /**
     * Display every reservation to choosing one in order to planify a task
     */
    public function choose()
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
