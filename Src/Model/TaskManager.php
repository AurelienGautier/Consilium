<?php

require_once("Src/Model/GetPDOSingleton.php");

class Task
{
    public int $id;
    public string $name;
    public $description;
    public string $startDate;
    public string $endDate;
    public int $type;
    public int $reservationId;
    public $supplierId;
    public int $machineId;
}

class TaskManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getTasks()
    {
        $ch = 'SELECT id_tache,
                      nom_tache,
                      description_tache,
                      dateDebut_tache,
                      dateFin_tache,
                      id_reservation,
                      id_fournisseur,
                      id_typeTache,
                      id_machine
               FROM tache';

        $request = $this->db->prepare($ch);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $tasks = array();

        for($i = 0; $i < count($result); $i++)
        {
            $tasks[$i] = new Task();

            $tasks[$i]->id = $result[$i]['id_tache'];
            $tasks[$i]->name = $result[$i]['nom_tache'];
            $tasks[$i]->description = $result[$i]['description_tache'];
            $tasks[$i]->startDate = $result[$i]['dateDebut_tache'];
            $tasks[$i]->endDate = $result[$i]['dateFin_tache'];
            $tasks[$i]->type = $result[$i]['id_typeTache'];
            $tasks[$i]->reservationId = $result[$i]['id_reservation'];
            $tasks[$i]->supplierId = $result[$i]['id_fournisseur'];
            $tasks[$i]->machineId = $result[$i]['id_machine'];
        }

        return $tasks;
    }

    /************************************************************************************/

    public function getTask($id)
    {
        $ch = 'SELECT nom_tache,
                      description_tache,
                      dateDebut_tache,
                      dateFin_tache,
                      id_reservation,
                      id_fournisseur,
                      id_typeTache,
                      id_machine
               FROM tache
               WHERE id_tache = :id_tache';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_tache', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);

        $task = new Task();

        $task->id = $id;
        $task->name = $result['nom_tache'];
        $task->description = $result['description_tache'];
        $task->startDate = $result['dateDebut_tache'];
        $task->endDate = $result['dateFin_tache'];
        $task->type = $result['id_typeTache'];
        $task->reservationId = $result['id_reservation'];
        $task->supplierId = $result['id_fournisseur'];
        $task->machineId = $result['id_machine'];

        return $task;
    }

    /************************************************************************************/

    public function insertTask($name = null,
                               $description = null,
                               $startDate = null,
                               $endDate = null,
                               $typeId = null,
                               $reservationId = null,
                               $supplierId = null,
                               $machineId = null)
    {
        if($supplierId == '') $supplierId = null;

        $ch = 'INSERT INTO tache (nom_tache,
                                  description_tache,
                                  dateDebut_tache,
                                  dateFin_tache,
                                  id_typeTache,
                                  id_reservation,
                                  id_fournisseur,
                                  id_machine)
               VALUES
               (:nom_tache, :description_tache, :dateDebut_tache, :dateFin_tache, :id_typeTache, :id_reservation, :id_fournisseur, :id_machine)';

        $request = $this->db->prepare($ch);

        $request->bindValue(':nom_tache', $name, PDO::PARAM_STR);
        if($description != null) $request->bindValue(':description_tache', $description, PDO::PARAM_STR);
        else $request->bindValue(':description_tache', null);
        $request->bindValue(':dateDebut_tache', $startDate, PDO::PARAM_STR);
        $request->bindValue(':dateFin_tache', $endDate, PDO::PARAM_STR);
        $request->bindValue(':id_typeTache', $typeId, PDO::PARAM_INT);
        $request->bindValue(':id_reservation', $reservationId, PDO::PARAM_INT);
        $request->bindValue(':id_fournisseur', $supplierId, PDO::PARAM_INT);
        $request->bindValue(':id_machine', $machineId, PDO::PARAM_INT);

        $result = $request->execute();
    }
}