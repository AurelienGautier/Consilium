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
            try 
            {
                $this->insertTask($reservationId, $fields);
            }
            catch(PDOException $e)
            {
                $errorMessage = 'Une tâche a déjà été attribuée sur la machine durant cette période.';

                $this->printAddTaskForm($reservationId, $fields, $errorMessage);
            }
        }
    }

    /************************************************************************************/

    /**
     * Print the form to add a task
     * 
     * @param int $reservationId The id of the reservation on which the task will be added
     */
    private function printAddTaskForm(int $reservationId, $fields = null, $errorMessage = null)
    {
        if($errorMessage != null) include('Template/Error.php');

        $reservation = (new ReservationManager())->getReservation($reservationId);
        $prodLine = (new ProdLineManager())->getProdLine($reservation->prodLineId);
        $machines = (new MachineManager())->getMachinesFromProdLine($prodLine->id);
        $types = (new TaskTypeManager())->getTaskTypes();
        $suppliers = (new SupplierManager())->getSuppliers();

        $taskName = isset($fields['name']) ? $fields['name'] : '';
        $taskType = isset($fields['type']) ? $fields['type'] : '';
        $taskMachine = isset($fields['machine']) ? $fields['machine'] : '';
        $taskSupplier = isset($fields['supplier']) ? $fields['supplier'] : '';
        $taskStartDate = isset($fields['startDate']) ? $fields['startDate'] : '';
        $taskEndDate = isset($fields['endDate']) ? $fields['endDate'] : '';
        $taskDescription = isset($fields['description']) ? $fields['description'] : '';

        $title = '<h1>Ajout d\'une tâche sur la ligne '.$prodLine->name.'.</h1>';
        $url = 'index.php?action=addTask&step=insert&reservationId='.$_GET['reservationId'];

        require('Template/TaskModify.php');
    }
    
    /************************************************************************************/
    
    /**
     * Print the form to modify a task
     * 
     * @param int $taskId The id of the task to modify
     */
    private function modifyForm(int $taskId, $fields = null, $errorMessage = null)
    {
        if($errorMessage != null) include('Template/Error.php');

        $task = (new TaskManager())->getTask($taskId);

        $reservation = (new ReservationManager())->getReservation($task->reservationId);
        $prodLine = (new ProdLineManager())->getProdLine($reservation->prodLineId);
        $machines = (new MachineManager())->getMachinesFromProdLine($prodLine->id);
        $types = (new TaskTypeManager())->getTaskTypes();
        $suppliers = (new SupplierManager())->getSuppliers();

        $taskName = isset($fields['name']) ? $fields['name'] : $task->name;
        $taskType = isset($fields['type']) ? $fields['type'] : $task->type;
        $taskMachine = isset($fields['machine']) ? $fields['machine'] : $task->machineId;
        $taskSupplier = isset($fields['supplier']) ? $fields['supplier'] : $task->supplierId;
        $taskStartDate = isset($fields['startDate']) ? $fields['startDate'] : $task->startDate;
        $taskEndDate = isset($fields['endDate']) ? $fields['endDate'] : $task->endDate;
        $taskDescription = isset($fields['description']) ? $fields['description'] : $task->description;

        $title = '<h1>Modification d\'une tâche sur la ligne '.$prodLine->name.'.</h1>';
        $url = "index.php?action=modifyTask&step=insert&taskId=$task->id";

        require('Template/TaskModify.php');
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
            try 
            {
                $this->update($taskId, $fields);
            }
            catch(PDOException $e)
            {
                $errorMessage = 'Une tâche a déjà été attribuée sur la machine durant cette période.';

                $this->modifyForm($taskId, $fields, $errorMessage);
            }
        }
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
     * Delete a task
     * 
     * @param int $taskId The id of the task to delete
     */
    public function delete(int $taskId)
    {
        (new TaskManager())->delete($taskId);

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

    public function choose(string $reason, int $reservationId)
    {
        if($reason == 'modify') $url = 'modifyTask&step=form&taskId=';
        else if($reason == 'delete') $url = 'deleteTask&taskId=';

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
