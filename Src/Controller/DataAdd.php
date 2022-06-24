<?php

require_once('Src/Model/SupplierManager.php');
require_once('Src/Model/ProdLineManager.php');
require_once('Src/Model/MachineManager.php');
require_once('Src/Model/TaskTypeManager.php');

class DataAdd
{
    public function execute(string $step, string $dataToAdd, $fields)
    {
        if($step == 'form')
        {
            if($dataToAdd == 'supplier')
            {
                require('Template/AddData/AddSupplier.php');
            }
            else if($dataToAdd == 'prodLine')
            {
                require('Template/AddData/AddProdLine.php');
            }
            else if($dataToAdd == 'machine')
            {
                $prodLines = (new ProdLineManager())->getProdLines();
                require('Template/AddData/AddMachine.php');
            }
            else if($dataToAdd == 'taskType')
            {
                require('Template/AddData/AddTaskType.php');
            }
            else
            {
                header('Location:index.php');
            }
        }
        else if($step == 'insert')
        {
            if($dataToAdd == 'supplier')
            {
                (new SupplierManager())->insertSupplier($fields['supplierName']);
            }
            else if($dataToAdd == 'prodLine')
            {
                (new ProdLineManager())->insertProdLine($fields['prodLineName']);
            }
            else if($dataToAdd == 'machine')
            {
                (new MachineManager())->insertMachine($fields['machineName'], $fields['prodLine']);
            }
            else if($dataToAdd == 'taskType')
            {
                (new TaskTypeManager())->insertTaskType($fields['taskTypeName']);
            }
            else
            {
                header('Location:index.php');
            }
        }
    }
}
