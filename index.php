<?php

require_once('Src/Controller/Reservation/ReservationAdd.php');
require_once('Src/Controller/Reservation/ReservationChoice.php');
require_once('Src/Controller/Task/TaskAdd.php');
require_once('Src/Controller/Calendar.php');
require_once('Src/Controller/DataAdd.php');

require('Template/header.php');

if(isset($_GET['action']))
{
    if($_GET['action'] == 'addReservation')
    {
        if(isset($_GET['step']))
        {
            (new ReservationAdd())->execute($_GET['step'], $_POST);
        }
    }
    else if($_GET['action'] == 'reservationChoice')
    {
        (new ReservationChoice())->execute();
    }
    else if($_GET['action'] == 'addTask')
    {
        if(isset($_GET['reservationId']) && isset($_GET['step']))
        {
            (new TaskAdd())->execute($_GET['step'], $_GET['reservationId'], $_POST);
        }
    }
    else if($_GET['action'] == 'printCalendar')
    {
        (new Calendar())->execute();
    }
    else if($_GET['action'] == 'addData')
    {
        if(isset($_GET['step']) && isset($_GET['dataToAdd']))
        {
            (new DataAdd())->execute($_GET['step'], $_GET['dataToAdd'], $_POST);
        }
    }
}
else
{
    require('Template/home.php');
}
require('Template/footer.php');
