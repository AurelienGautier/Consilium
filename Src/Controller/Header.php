<?php
require_once('Src/Model/ProdLineManager.php');

class Header
{
    public function execute()
    {
        $months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $lines = (new ProdLineManager())->getProdLines();

        require('Template/Header.php');
    }
}
