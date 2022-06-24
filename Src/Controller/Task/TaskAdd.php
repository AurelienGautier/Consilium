<?php

require_once('Src/Model/taskManager.php');
require_once('Src/Model/reservationManager.php');
require_once('Src/Model/machineManager.php');
require_once('Src/Model/taskTypeManager.php');

class TaskAdd
{
    public function execute(string $step, int $reservationId, $fields)
    {
        if($step == 'form')
        {
            $reservation = (new ReservationManager())->getReservation($reservationId);
            $prodLine = (new ProdLineManager())->getProdLine($reservation->prodLineId);
            $machines = (new MachineManager())->getMachinesFromProdLine($prodLine->id);
            $taskTypes = (new TaskTypeManager())->getTaskTypes();

            require('Template/TaskAdd.php');
        }
        else if($step == 'insert')
        {
            (new TaskManager())->insertTask($fields['taskName'],
                                            $fields['taskDescription'],
                                            $fields['taskDate'],
                                            $fields['endTaskDate'],
                                            $fields['stopType'],
                                            $reservationId,
                                            null,
                                            $fields['taskMachine']);
            header('Location:index.php?action=printCalendar');
        }
    }
}
