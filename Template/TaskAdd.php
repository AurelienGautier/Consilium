<?php
    echo('<h1>Ajout d\'une tâche sur la ligne '.$prodLine->name.'.</h1>');
?>

<form id="formAddTask" action="index.php?action=addTask&step=insert&reservationId=<?php echo $_GET['reservationId']; ?>" method="post">
    <label for="taskName">Nom de la tâche</label>
    <input type="text" id="taskName" name="taskName" placeholder="Nom de la tâche" required/>
    <br/>

    <!-- Type d'arrêt -->
    <label for="stopType">Type de tâche</label>
    <select id="stopType" name="stopType">
        <?php
            foreach($taskTypes as $taskType)
            {
                echo '<option value='.$taskType->id.'>'.$taskType->name.'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Machine concernée -->
    <label for="taskMachine">Machine concernée</label>
    <select id="taskMachine" name="taskMachine">
        <?php
            foreach($machines as $machine)
            {
                echo '<option value='.$machine->id.'>'.$machine->name.'</option>';
            }
        ?>
    </select>
    <br/>

    <label for="supplier">Intervention d'un fournisseur</label>
    <select id="supplier" name="supplier">
        <option value="">Aucun</option>
        <?php
            foreach($suppliers as $supplier)
            {
                echo '<option value='.$supplier->id.'>'.$supplier->name.'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Date de l'arrêt -->
    <label for="taskDate">Date du début de la tâche</label>
    <input type="date" id="taskDate" name="taskDate" min=<?php echo $reservation->startDate;?> max=<?php echo $reservation->endDate; ?> />
    <br/>

    <!-- Date de fin de l'arrêt -->
    <label for="endTaskDate">Date de fin de la tâche</label>
    <input type="date" id="endTaskDate" name="endTaskDate" min=<?php echo $reservation->startDate;?> max=<?php echo $reservation->endDate; ?> />
    <br/>

    <!-- Description de la tâche -->
    <label for="taskDescription">Description de la tâche</label>
    <textarea id="teskDescription" name="taskDescription" placeholder="Description de la tâche"></textarea>
    <br/>

    <input type="submit" value="Ajouter"/>
</form>
