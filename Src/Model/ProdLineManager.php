<?php

require_once("Src/Model/GetPDOSingleton.php");

class ProdLine
{
    public int $id;
    public string $name;
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
        $ch = 'SELECT id_ligneProd, nom_ligneProd
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
        }

        return $prodLines;
    }

    /************************************************************************************/

    public function getProdLine(int $id)
    {
        $ch = 'SELECT nom_ligneProd
               FROM ligneprod
               WHERE id_ligneprod = :id_ligneprod';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_ligneprod', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch();

        $prodLine = new ProdLine();
        $prodLine->id = $id;
        $prodLine->name = $result['nom_ligneProd'];

        return $prodLine;
    }

    /************************************************************************************/

    public function insertProdLine(string $name)
    {
        $ch = 'INSERT INTO ligneprod (nom_ligneprod) VALUES (:nom_ligneprod)';

        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_ligneprod', $name, PDO::PARAM_STR);
        $request->execute();
    }

    /************************************************************************************/
}
