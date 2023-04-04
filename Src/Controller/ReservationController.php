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
            $this->addForm();
        } 
        else if($step == 'insert')
        {
            if(!$this->insertReservation($fields))
            {
                header('Location:index.php?action=addReservation&step=form');
            }

            header('Location:index.php?action=printYearlyCalendar');
        }
        // If the step variable is incorrect
        else
        {
            header('Location:index.php?action=addReservation&step=form');
        }
    }

    /************************************************************************************/

    /**
     * Print the form to add a reservation
     */
    public function addForm()
    {
        $prodLines = (new ProdLineManager())->getProdLines();
        require('Template/ReservationAdd.php');
    }

    /************************************************************************************/

    /**
     * Insert the reservation data into db from the form
     * 
     * @param array $fields Data from the form
     */
    public function insertReservation(array $fields)
    {
        if(!empty($fields))
        {
            (new ReservationManager())->insertReservation($fields['taskDate'],
                                                          $fields['endTaskDate'],
                                                          $fields['taskService']);
    
            // A redirection is made on the yearly calendar to immediatly see the change
            header('Location:index.php?action=printYearlyCalendar');
        }
        else 
        {
            throw new Exception('Vous devez remplir le formulaire avant d\'enregistrer un arrêt technique.');
        }
    }

    /************************************************************************************/

    /**
     * Modify data of a reservation
     * 
     * @param string $step The action to accomplish (print form or insert modifications in db)
     * @param int $reservationId The id of the reservation to update
     * @param array fields Data from the form : null if the step is form
     */
    public function modify(string $step, int $reservationId, array $fields)
    {
        if($step == 'form')
        {
            $this->modifyForm($reservationId);
        }
        else if($step == 'insert')
        {
            $this->update($reservationId, $fields);
        }
        else
        {
            header('Location:index.php?action=modifyReservation&step=form&reservationId='.$reservationId);
        }
    }

    /************************************************************************************/

    /**
     * Print the form to get modification data
     * 
     * @param int $reservationId The id of the reservation to modify
     */
    private function modifyForm(int $reservationId)
    {
        $reservation = (new ReservationManager())->getReservation($reservationId);
        $prodLines = (new ProdLineManager())->getProdLines();

        require('Template/ReservationModify.php');
    }

    /************************************************************************************/

    /**
     * Insert modifications in db
     * 
     * @param int $reservationId The id of the reservation to modify
     * @param array $fields Data from the form
     */
    private function update(int $reservationId, array $fields)
    {
        $tasks = (new TaskManager())->getTasksByReservation($reservationId);

        if(!empty($tasks)) 
        {
            require('Template/moveTasks.php');
        }
        else
        {
            (new ReservationManager())->update($reservationId, 
                                               $fields['startDate'], 
                                               $fields['endDate'], 
                                               $fields['prodLine']);

            header('Location:index.php?action=printYearlyCalendar');
        }

    }

    /************************************************************************************/

    /**
     * Display every reservation to choosing one in order to planify a task
     * 
     * @param string $reason The reason why we want to choose a reservation
     */
    public function choose(string $reason)
    {
        if($reason == 'addTask') $url = 'addTask&step=form&reservationId=';
        else if($reason == 'modifyReservation') $url = 'modifyReservation&step=form&reservationId=';
        else if($reason == 'modifyTask') $url = 'taskChoice&for=modify&reservationId=';
        else if($reason == 'deleteReservation') $url = 'deleteReservation&reservationId=';
        else if($reason == 'deleteTask') $url = 'taskChoice&for=delete&reservationId=';
        else header('Location:index.php');

        $reservations = (new ReservationManager())->getReservations();
        $prodLines = array();

        for($i = 0; $i < count($reservations); $i++)
        {
            $prodLines[$i] = (new ProdLineManager())->getProdLine($reservations[$i]->prodLineId);
        }

        require('Template/ReservationChoice.php');
    }

    /************************************************************************************/

    /**
     * Delete a reservation and all its tasks
     * 
     * @param int $reservationId
     */
    public function delete(int $reservationId)
    {
        (new ReservationManager())->delete($reservationId);

        header('Location:index.php?action=printYearlyCalendar');
    }

    /************************************************************************************/
}
