<?php

/** 
 * This file is the router which allows to call the good controller
 *  by looking at the $_GET['action'] variable.
 */

require_once('Src/Controller/Header.php');
require_once('Src/Controller/ReservationController.php');
require_once('Src/Controller/TaskController.php');
require_once('Src/Controller/YearlyCalendar.php');
require_once('Src/Controller/MonthlyCalendar.php');
require_once('Src/Controller/DataAdd.php');

(new Header())->execute();

try
{
    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'addReservation':
                if(isset($_GET['step']))
                {
                    (new ReservationController())->add($_GET['step'], $_POST);
                }
                else
                {
                    header('Location:index.php?action=addReservation&step=form');
                }
                break;
            

            case 'reservationChoice':
                (new ReservationController())->choose();
                break;

            case 'addTask':
                if(isset($_GET['reservationId']) && isset($_GET['step']))
                {
                    (new TaskController())->add($_GET['step'], $_GET['reservationId'], $_POST);
                }
                break;

            case 'printTask':
                if(isset($_GET['taskId']))
                {
                    (new TaskController())->print($_GET['taskId']);
                }
                break;

            case 'printYearlyCalendar':
                $lineId = null;
                if(isset($_GET['lineId'])) $lineId = $_GET['lineId'];

                (new YearlyCalendar())->execute($lineId);
                break;
            
            case 'printMonthlyCalendar':
                (new MonthlyCalendar())->execute();
                break;

            
            case 'addData':
                if(isset($_GET['step']) && isset($_GET['dataToAdd']))
                {
                    (new DataAdd())->execute($_GET['step'], $_GET['dataToAdd'], $_POST);
                }
                break;

            default:
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
