<?php

// Truc à changer : éclater les différentes étapes de add en 2 fonctions

require_once('Src/Model/taskManager.php');
require_once('Src/Model/reservationManager.php');
require_once('Src/Model/machineManager.php');
require_once('Src/Model/taskTypeManager.php');
require_once('Src/Model/SupplierManager.php');

class TaskController
{
    /**
     * Execute the different step to add a task
     * 
     * @param string $step The action to accomplish (print form or insert in db)
     * @param int $reservationId The id of the reservation on which the task will be added
     * @param array $fields Data from the form : null if the step is form 
     */
    public function add(string $step, int $reservationId, array $fields)
    {
        if($step == 'form')
        {
            $this->printAddTaskForm($reservationId);
        }
        else if($step == 'insert')
        {
            $this->insertTask($reservationId, $fields);
        }
    }

    /************************************************************************************/

    /**
     * Print the form to add a task
     * 
     * @param int $reservationId The id of the reservation on which the task will be added
     */
    private function printAddTaskForm(int $reservationId)
    {
        $reservation = (new ReservationManager())->getReservation($reservationId);
        $prodLine = (new ProdLineManager())->getProdLine($reservation->prodLineId);
        $machines = (new MachineManager())->getMachinesFromProdLine($prodLine->id);
        $taskTypes = (new TaskTypeManager())->getTaskTypes();
        $suppliers = (new SupplierManager())->getSuppliers();

        require('Template/TaskAdd.php');
    }

    /************************************************************************************/

    /**
     * Insert the task data into db recuperated from the form
     * 
     * @param int $reservationId The id of the reservation on which the task will be added
     * @param array $fields Data from the form
     */
    private function insertTask(int $reservationId, array $fields)
    {
        (new TaskManager())->insertTask(
            $fields['name'],
            $fields['description'],
            $fields['startDate'],
            $fields['endDate'],
            $fields['type'],
            $reservationId,
            $fields['supplier'],
            $fields['machine']
        );

        header('Location:index.php?action=printYearlyCalendar');
    }

    /************************************************************************************/

    /**
     * Modify data of a task
     * 
     * @param string $step The action to accomplish (print form or insert modifications in db)
     * @param int $taskId The id of the task to modify
     * @param array $fields Data from the form
     */
    public function modify(string $step, int $taskId, array $fields)
    {
        if($step == 'form')
        {
            $this->modifyForm($taskId);
        }
        else if($step == 'insert')
        {
            $this->update($taskId, $fields);
        }
    }

    /************************************************************************************/

    /**
     * Print the form to modify a task
     * 
     * @param int $taskId The id of the task to modify
     */
    private function modifyForm(int $taskId)
    {
        $task = (new TaskManager())->getTask($taskId);
        $reservation = (new ReservationManager())->getReservation($task->reservationId);
        $prodLine = (new ProdLineManager())->getProdLine($reservation->prodLineId);
        $suppliers = (new SupplierManager())->getSuppliers();
        $taskType = (new TaskTypeManager())->getTaskTypes();
        $machines = (new MachineManager())->getMachinesFromProdLine($prodLine->id);
        $taskTypes = (new TaskTypeManager())->getTaskTypes();

        require('Template/TaskModify.php');
    }

    /************************************************************************************/

    /**
     * Insert modifications in db
     * 
     * @param int $taskId The id of the task to modify
     * @param array $fields Data from the form
     */
    private function update(int $taskId, array $fields)
    {
        (new TaskManager())->update(
            $taskId,
            $fields['name'],
            $fields['description'],
            $fields['startDate'],
            $fields['endDate'],
            $fields['supplier'],
            $fields['type'],
            $fields['machine']
        );

        header('Location:index.php?action=printYearlyCalendar');
    }
    
    /************************************************************************************/

    /**
     * Print informations about a task
     * 
     * @param int $taskId The id of the task to print
     */
    public function print(int $taskId)
    {
        $task = (new TaskManager)->getTask($taskId);

        if($task != null)
        {
            $reservation = (new ReservationManager)->getReservation($task->reservationId);
            $taskType = (new TaskTypeManager)->getTaskType($task->type);
            $machine = (new MachineManager)->getMachine($task->machineId);
            $supplier = (new SupplierManager)->getSupplier($task->supplierId);
    
            require('Template/PrintTask.php');
        }
        else
        {
            throw new Exception('Cette tâche n\'existe pas.');
        }
    }

    /************************************************************************************/

    public function choose(int $reservationId)
    {
        $tasks = (new TaskManager())->getTasksByReservation($reservationId);
        $taskTypes = array();
        $suppliers = array();

        for($i = 0; $i < count($tasks); $i++)
        {
            $taskTypes[$i] = (new TaskTypeManager())->getTaskType($tasks[$i]->type);
            $suppliers[$i] = (new SupplierManager())->getSupplier($tasks[$i]->supplierId);
        }

        require('Template/TaskChoice.php');
    }

    /************************************************************************************/
}
