<?php

require_once('Src/Model/GetPDOSingleton.php');

class Supplier
{
    public int $id;
    public string $name;
}

class SupplierManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getSuppliers()
    {
        $ch = 'SELECT id_fournisseur, nom_fournisseur
               FROM fournisseur
               ORDER BY nom_fournisseur ASC';

        $request = $this->db->prepare($ch);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $suppliers = array();

        for($i = 0; $i < count($result); $i++)
        {
            $suppliers[$i] = new Supplier();

            $suppliers[$i]->id = $result[$i]['id_fournisseur'];
            $suppliers[$i]->name = $result[$i]['nom_fournisseur'];
        }

        return $suppliers;
    }

    /************************************************************************************/

    public function getSupplier($id)
    {
        if($id == null) return null;

        $ch = 'SELECT nom_fournisseur
               FROM fournisseur
               WHERE id_fournisseur = :id_fournisseur';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_fournisseur', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);

        $supplier = new Supplier();

        $supplier = new Supplier();

        $supplier->id = $id;
        $supplier->name = $result['nom_fournisseur'];

        return $supplier;
    }

    /************************************************************************************/

    public function insertSupplier($name)
    {
        $ch = 'INSERT INTO fournisseur (nom_fournisseur) VALUES (:nom_fournisseur)';

        $request = $this->db->prepare($ch);
        $request->bindValue(':nom_fournisseur', $name, PDO::PARAM_STR);
        $request->execute();
    }

    /************************************************************************************/
}
