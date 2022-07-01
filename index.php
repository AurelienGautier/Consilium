<?php
require_once('Src/Controller/Header.php');
require_once('Src/Controller/Reservation/ReservationAdd.php');
require_once('Src/Controller/Reservation/ReservationChoice.php');
require_once('Src/Controller/Task/TaskAdd.php');
require_once('Src/Controller/Calendar.php');
require_once('Src/Controller/MonthlyCalendar.php');
require_once('Src/Controller/Task/PrintTask.php');
require_once('Src/Controller/DataAdd.php');

(new Header())->execute();

try
{
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
            $lineId = null;
            if(isset($_GET['lineId'])) $lineId = $_GET['lineId'];

            (new Calendar())->execute($lineId);
        }
        else if($_GET['action'] == 'printMonthlyCalendar')
        {
            (new MonthlyCalendar())->execute();
        }
        else if($_GET['action'] == 'printTask')
        {
            if(isset($_GET['taskId']))
            {
                (new printTask())->execute($_GET['taskId']);
            }
        }
        else if($_GET['action'] == 'addData')
        {
            if(isset($_GET['step']) && isset($_GET['dataToAdd']))
            {
                (new DataAdd())->execute($_GET['step'], $_GET['dataToAdd'], $_POST);
            }
        }
        else {
            throw new Exception('404 Page non trouvée.');
        }
    }
    else
    {
        require('Template/home.php');
    }
}
catch(Exception $e)
{
    $errorMessage = $e->getMessage();

    require('Template/Error.php');
}

require('Template/footer.php');
