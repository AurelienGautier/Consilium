<?php

require_once('Src/Model/GetPDOSingleton.php');

class TaskType
{
    public int $id;
    public string $name;
}

class TaskTypeManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getTaskTypes()
    {
        $ch = 'SELECT id_typeTache, nom_typeTache
               FROM typetache';

        $request = $this->db->prepare($ch);
        $request->execute();

        $result = $request->fetchAll();

        $taskTypes = array();

        for($i = 0; $i < count($result); $i++)
        {
            $taskTypes[$i] = new Task();

            $taskTypes[$i]->id = $result[$i]['id_typeTache'];
            $taskTypes[$i]->name = $result[$i]['nom_typeTache'];
        }

        return $taskTypes;
    }

    /************************************************************************************/

    public function insertTaskType($name)
    {
        $ch = 'INSERT INTO typetache (nom_typeTache) VALUES (:nom_typeTache)';

        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_typeTache', $name, PDO::PARAM_STR);
        $request->execute();
    }

    /************************************************************************************/
}
