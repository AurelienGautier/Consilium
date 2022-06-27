<?php

require_once('Src/Model/TaskManager.php');
require_once('Src/Model/ReservationManager.php');
require_once('Src/Model/TaskTypeManager.php');
require_once('Src/Model/MachineManager.php');
require_once('Src/Model/SupplierManager.php');

class printTask
{
    public function execute($taskId)
    {
        $task = (new TaskManager)->getTask($taskId);
        $reservation = (new ReservationManager)->getReservation($task->reservationId);
        $taskType = (new TaskTypeManager)->getTaskType($task->type);
        $machine = (new MachineManager)->getMachine($task->machineId);
        $supplier = (new SupplierManager)->getSupplier($task->supplierId);

        require('Template/PrintTask.php');
    }
}
