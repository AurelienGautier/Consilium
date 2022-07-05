<?php

require_once("Src/Model/GetPDOSingleton.php");

class ProdLine
{
    public int $id;
    public string $name;
    public string $color;
}

class ProdLineManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getProdLines()
    {
        $ch = 'SELECT id_ligneProd, nom_ligneProd, couleur_ligneProd
               FROM ligneprod';

        $request = $this->db->prepare($ch);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $prodLines = array();

        for($i = 0; $i < count($result); $i++)
        {
            $prodLines[$i] = new ProdLine();

            $prodLines[$i]->id = $result[$i]['id_ligneProd'];
            $prodLines[$i]->name = $result[$i]['nom_ligneProd'];
            $prodLines[$i]->color = $result[$i]['couleur_ligneProd'];
        }

        return $prodLines;
    }

    /************************************************************************************/

    public function getProdLine(int $id)
    {
        $ch = 'SELECT nom_ligneProd, couleur_ligneProd
               FROM ligneprod
               WHERE id_ligneprod = :id_ligneprod';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_ligneprod', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);

        if($result != false)
        {
            $prodLine = new ProdLine();
            $prodLine->id = $id;
            $prodLine->name = $result['nom_ligneProd'];
            $prodLine->color = $result['couleur_ligneProd'];
    
            return $prodLine;
        }

        return null;
    }

    /************************************************************************************/

    public function insertProdLine(string $name, string $color)
    {
        $ch = 'INSERT INTO ligneprod (nom_ligneprod, couleur_ligneProd) 
               VALUES (:nom_ligneprod, :couleur_ligneProd)';

        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_ligneprod', $name, PDO::PARAM_STR);
        $request->bindValue(':couleur_ligneProd', $color, PDO::PARAM_STR);
        $request->execute();
    }

    /************************************************************************************/

    public function isExisting($id)
    {
        $ch = 'SELECT nom_ligneprod
               FROM ligneprod
               WHERE id_ligneprod = :id_ligneprod';

        $request = $this->db->prepare($ch);
        $request->bindValue('id_ligneprod', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch();

        if(!$result) return false;
        return true;
    }

    /************************************************************************************/

    public function getProdLinesFromMachine($machineId)
    {
        $ch = 'SELECT l.id_ligneProd, l.nom_ligneProd, l.couleur_ligneProd
               FROM ligneprod l
               INNER JOIN utiliser u
               ON l.id_ligneProd = u.id_ligneProd
               WHERE u.id_machine = :id_machine';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_machine', $machineId, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $prodLines = array();

        for($i = 0; $i < count($result); $i++)
        {
            $prodLines[$i] = new ProdLine();

            $prodLines[$i]->id = $result[$i]['id_ligneProd'];
            $prodLines[$i]->name = $result[$i]['nom_ligneProd'];
            $prodLines[$i]->color = $result[$i]['couleur_ligneProd'];
        }

        return $prodLines;
    }

    /************************************************************************************/
}
