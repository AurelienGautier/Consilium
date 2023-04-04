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

        if($result != false)
        {
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

        return null;
    }

    /************************************************************************************/

    public function getTasksByLineId($prodLineId)
    {
        $ch = 'SELECT t.id_tache,
                      t.nom_tache,
                      t.description_tache,
                      t.dateDebut_tache,
                      t.dateFin_tache,
                      t.id_reservation,
                      t.id_fournisseur,
                      t.id_typeTache,
                      t.id_machine
               FROM tache t
               INNER JOIN reservation r
               ON t.id_reservation = r.id_reservation
               WHERE r.id_ligneProd = :id_ligneProd';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_ligneProd', $prodLineId, PDO::PARAM_INT);
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
            $tasks[$i]->reservationId = $result[$i]['id_reservation'];
            $tasks[$i]->type = $result[$i]['id_typeTache'];
            $tasks[$i]->supplierId = $result[$i]['id_fournisseur'];
            $tasks[$i]->machineId = $result[$i]['id_machine'];
        }

        return $tasks;
    }

    /************************************************************************************/

    public function getTasksByReservation(int $reservationId)
    {
        $ch = 'SELECT id_tache,
                      nom_tache,
                      description_tache,
                      dateDebut_tache,
                      dateFin_tache,
                      id_fournisseur,
                      id_typeTache,
                      id_machine
               FROM tache
               WHERE id_reservation = :id_reservation';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_reservation', $reservationId, PDO::PARAM_INT);
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
            $tasks[$i]->reservationId = $reservationId;
            $tasks[$i]->type = $result[$i]['id_typeTache'];
            $tasks[$i]->supplierId = $result[$i]['id_fournisseur'];
            $tasks[$i]->machineId = $result[$i]['id_machine'];
        }

        return $tasks;
    }

    /************************************************************************************/

    public function insertTask(
        $name = null,
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

    /************************************************************************************/

    public function update(
        int $id, 
        string $name, 
        $description, 
        string $startDate, 
        string $endDate,
        $supplierId,
        int $type,
        int $machineId
    )
    {
        $ch = 'UPDATE tache
               SET nom_tache = :nom_tache,
               description_tache = :description_tache,
               dateDebut_tache = :dateDebut_tache,
               dateFin_tache = :dateFin_tache,
               id_fournisseur = :id_fournisseur,
               id_typeTache = :id_typeTache,
               id_machine = :id_machine
               WHERE id_tache = :id_tache';

        $request = $this->db->prepare($ch);

        if($supplierId == '') $supplierId = null;

        $request->bindValue(':nom_tache', $name, PDO::PARAM_STR);
        $request->bindValue(':description_tache', $description, PDO::PARAM_STR);
        $request->bindValue(':dateDebut_tache', $startDate, PDO::PARAM_STR);
        $request->bindValue(':dateFin_tache', $endDate, PDO::PARAM_STR);
        $request->bindValue(':id_fournisseur', $supplierId, PDO::PARAM_INT);
        $request->bindValue(':id_typeTache', $type, PDO::PARAM_INT);
        $request->bindValue(':id_machine', $machineId, PDO::PARAM_INT);
        $request->bindValue(':id_tache', $id, PDO::PARAM_INT);

        $request->execute();

    }

    /************************************************************************************/

    public function updateDate(int $id, string $startDate, string $endDate)
    {
        $ch = 'UPDATE tache
               SET dateDebut_tache = :dateDebut_tache,
               dateFin_tache = :dateFin_tache
               WHERE id_tache = :id_tache';

        $request = $this->db->prepare($ch);

        $request->bindValue(':dateDebut_tache', $startDate, PDO::PARAM_STR);
        $request->bindValue(':dateFin_tache', $endDate, PDO::PARAM_STR);
        $request->bindValue(':id_tache', $id, PDO::PARAM_INT);

        $request->execute();
    }

    /************************************************************************************/

    public function delete(int $taskId)
    {
        $ch = 'DELETE FROM tache WHERE id_tache = :id_tache';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_tache', $taskId, PDO::PARAM_INT);
        $request->execute();
    }

    /************************************************************************************/
}
