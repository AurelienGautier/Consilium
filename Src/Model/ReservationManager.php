<?php

require_once('Src/Model/GetPDOSingleton.php');

class Reservation
{
    public int $id;
    public string $startDate;
    public string $endDate;
    public string $color;
    public int $prodLineId;
}

class ReservationManager
{
    private $db;

    /************************************************************************************/

    public function __construct()
    {
        $this->db = CreatePDOSingleton::getInstance()->getPDO();
    }

    /************************************************************************************/

    public function getReservations()
    {
        $ch = 'SELECT id_reservation, 
                      id_ligneProd,
                      dateDebut_reservation, 
                      dateFin_reservation, 
                      couleur_reservation
               FROM reservation
               ORDER BY dateDebut_reservation';
    
        $request = $this->db->prepare($ch);
        $request->execute();
    
        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $reservations = array();
        
        for($i = 0; $i < count($result); $i++)
        {
            $reservations[$i] = new Reservation();
            
            $reservations[$i]->id = $result[$i]['id_reservation'];
            $reservations[$i]->startDate = $result[$i]['dateDebut_reservation'];
            $reservations[$i]->endDate = $result[$i]['dateFin_reservation'];
            $reservations[$i]->color = $result[$i]['couleur_reservation'];
            $reservations[$i]->prodLineId = $result[$i]['id_ligneProd'];
        }

        return $reservations;
    }

    /************************************************************************************/

    public function getReservation(int $id)
    {
        $ch = 'SELECT id_ligneProd,
                      dateDebut_reservation, 
                      dateFin_reservation, 
                      couleur_reservation
               FROM reservation
               WHERE id_reservation = :id_reservation
               ORDER BY dateDebut_reservation';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_reservation', $id, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetch();

        $reservation = new Reservation();
        $reservation->id = $id;
        $reservation->startDate = $result['dateDebut_reservation'];
        $reservation->endDate = $result['dateFin_reservation'];
        $reservation->color = $result['couleur_reservation'];
        $reservation->prodLineId = $result['id_ligneProd'];

        return $reservation;
    }

    /************************************************************************************/

    public function getReservationsByLineId($lineId)
    {
        $ch = 'SELECT id_reservation,
                      dateDebut_reservation, 
                      dateFin_reservation, 
                      couleur_reservation
        FROM reservation
        WHERE id_ligneProd = :id_ligneProd
        ORDER BY dateDebut_reservation';

        $request = $this->db->prepare($ch);
        $request->bindValue(':id_ligneProd', $lineId, PDO::PARAM_INT);
        $request->execute();

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        $reservations = array();

        for($i = 0; $i < count($result); $i++)
        {
            $reservations[$i] = new Reservation();
            $reservations[$i]->id = $result[$i]['id_reservation'];
            $reservations[$i]->startDate = $result[$i]['dateDebut_reservation'];
            $reservations[$i]->endDate = $result[$i]['dateFin_reservation'];
            $reservations[$i]->color = $result[$i]['couleur_reservation'];
            $reservations[$i]->prodLineId = $lineId;
        }

        return $reservations;
    }

    /************************************************************************************/

    public function insertReservation(string $startDate, string $endDate, string $color, int $prodLineId)
    {
        $ch = 'INSERT INTO reservation (dateDebut_reservation, dateFin_reservation, couleur_reservation, id_ligneProd) VALUES
               (:dateDebut_reservation, :dateFin_reservation, :couleur_reservation, :id_ligneProd)';

        $request = $this->db->prepare($ch);
        
        $request->bindValue(':dateDebut_reservation', $startDate, PDO::PARAM_STR);
        $request->bindValue(':dateFin_reservation', $endDate, PDO::PARAM_STR);
        $request->bindValue(':couleur_reservation', $color, PDO::PARAM_STR);
        $request->bindValue(':id_ligneProd', $prodLineId, PDO::PARAM_INT);

        $request->execute();
    }

    /************************************************************************************/
}
