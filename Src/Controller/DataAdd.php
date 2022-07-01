<?php

/*
 * This file is a controller used to add data in db
 * Data that can be added : supplier, prod line, machine, task type
 */

require_once('Src/Model/SupplierManager.php');
require_once('Src/Model/ProdLineManager.php');
require_once('Src/Model/MachineManager.php');
require_once('Src/Model/TaskTypeManager.php');

class DataAdd
{
    /**
     * Execute the differents step to add a data
     * 
     * @param string $step The action to accomplish (print form or insert in db)
     * @param string $dataToAdd The data we want to add
     * @param array $fields Data from the form : null if the step is form
     */
    public function execute(string $step, string $dataToAdd, array $fields)
    {
        if($step == 'form')
        {
            $this->printAddForm($dataToAdd);
        }
        else if($step == 'insert')
        {
            $this->instertData($dataToAdd, $fields);
        }
    }

    /**
     * Print the form to add data
     * 
     * @param string $dataToAdd The data we want to add
     */
    private function printAddForm(string $dataToAdd)
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

    /**
     * Insert the data into the db recuperated from the form
     * 
     * @param string $dataToAdd The data we want to add
     * @param array $fields Data from the form
     */
    private function instertData(string $dataToAdd, array $fields)
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
