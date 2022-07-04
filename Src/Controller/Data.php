<?php

/*
 * This file is a controller used to add data in db
 * Data that can be added : supplier, prod line, machine, task type
 */

require_once('Src/Model/SupplierManager.php');
require_once('Src/Model/ProdLineManager.php');
require_once('Src/Model/MachineManager.php');
require_once('Src/Model/TaskTypeManager.php');

class Data
{
    /**
     * Execute the differents step to add a data
     * 
     * @param string $step The action to accomplish (print form or insert in db)
     * @param string $dataToAdd The data we want to add
     * @param array $fields Data from the form : null if the step is form
     */
    public function add(string $step, string $dataToAdd, array $fields)
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
            (new ProdLineManager())->insertProdLine($fields['prodLineName'], $fields['color']);
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

        header('Location:index.php?action=printData&dataToPrint='.$dataToAdd);
    }

    /**
     * Print data from db of a chosen category
     * 
     * @param string $dataToPrint The category of data we want to print
     */
    public function print(string $dataToPrint)
    {
        // Print the suppliers
        if($dataToPrint == 'supplier')
        {
            $suppliers = (new SupplierManager())->getSuppliers();
            require('Template/printData/PrintSuppliers.php');
        }

        // Print production lines
        else if($dataToPrint == 'prodLine')
        {
            $prodLines = (new ProdLineManager())->getProdLines();
            require('Template/printData/PrintProdLines.php');
        }

        // Print machines
        else if($dataToPrint == 'machine')
        {
            $machines = (new MachineManager())->getMachines();
            $machineProdLines = array();

            foreach($machines as $machine)
            {
                array_push($machineProdLines,(new ProdLineManager())->getProdLinesFromMachine($machine->id));
            }

            require('Template/printData/PrintMachines.php');
        }

        // Print task types
        else if($dataToPrint == 'taskType')
        {
            $taskTypes = (new TaskTypeManager())->getTaskTypes();
            require('Template/printData/PrintTaskTypes.php');
        }
        else
        {
            header('Location:index.php');
        }
    }
}
