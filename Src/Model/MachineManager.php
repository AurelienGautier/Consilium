<?php

require_once('Src/Model/GetPDOSingleton.php');

class Machine
{
    public int $id;
    public string $name;
}

class MachineManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getMachine($id)
    {
        $ch = 'SELECT nom_machine
               FROM machine
               WHERE id_machine = :id_machine';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_machine', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);

        $machine = new Machine();
        $machine->id = $id;
        $machine->name = $result['nom_machine'];
    }

    /************************************************************************************/

    public function getMachinesFromProdLine(int $prodLineId)
    {
        $ch = 'SELECT m.id_machine, m.nom_machine
               FROM machine m
               INNER JOIN utiliser u
               ON u.id_machine = m.id_machine
               WHERE u.id_ligneProd = :id_ligneProd
               ORDER BY m.nom_machine ASC';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_ligneProd', $prodLineId, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $machines = array();

        for($i = 0; $i < count($result); $i++)
        {
            $machines[$i] = new Machine();

            $machines[$i]->id = $result[$i]['id_machine'];
            $machines[$i]->name = $result[$i]['nom_machine'];
        }

        return $machines;
    }

    /************************************************************************************/

    public function insertMachine($machineName, $prodLineId)
    {
        $ch = 'INSERT INTO machine (nom_machine) VALUES (:nom_machine)';
        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_machine', $machineName, PDO::PARAM_STR);
        $request->execute();

        $ch = 'SELECT id_machine FROM machine WHERE nom_machine = :nom_machine';
        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_machine', $machineName, PDO::PARAM_STR);
        $request->execute();
        $result = $request->fetch();
        $machineId = $result['id_machine'];

        $ch = 'INSERT INTO utiliser (id_machine, id_ligneProd) VALUES (:id_machine, :id_ligneProd)';
        $request = $this->db->prepare($ch);
        $request->bindValue(':id_machine', $machineId, PDO::PARAM_INT);
        $request->bindValue(':id_ligneProd', $prodLineId, PDO::PARAM_INT);
        $request->execute();
    }

    /************************************************************************************/
}
