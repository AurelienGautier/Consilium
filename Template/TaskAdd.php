<?php
    echo('<h1>Ajout d\'une tâche sur la ligne '.$prodLine->name.'.</h1>');
?>

<form id="formAddTask" action="index.php?action=addTask&step=insert&reservationId=<?php echo $_GET['reservationId']; ?>" method="post">
    <label for="name">Nom de la tâche</label>
    <input type="text" id="name" name="name" placeholder="Nom de la tâche" required/>
    <br/>

    <!-- Type d'arrêt -->
    <label for="type">Type de tâche</label>
    <select id="type" name="type">
        <?php
            foreach($taskTypes as $taskType)
            {
                echo '<option value='.htmlspecialchars($taskType->id).'>'.htmlspecialchars($taskType->name).'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Machine concernée -->
    <label for="machine">Machine concernée</label>
    <select id="machine" name="machine">
        <?php
            foreach($machines as $machine)
            {
                echo '<option value='.htmlspecialchars($machine->id).'>'.htmlspecialchars($machine->name).'</option>';
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
                echo '<option value='.htmlspecialchars($supplier->id).'>'.htmlspecialchars($supplier->name).'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Date de l'arrêt -->
    <label for="startDate">Date du début de la tâche</label>
    <input type="date" id="startDate" name="startDate" min=<?= htmlspecialchars($reservation->startDate) ?> max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Date de fin de l'arrêt -->
    <label for="endDate">Date de fin de la tâche</label>
    <input type="date" id="endDate" name="endDate" min=<?= htmlspecialchars($reservation->startDate) ?> max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Description de la tâche -->
    <label for="description">Description de la tâche</label>
    <textarea id="description" name="description" placeholder="Description de la tâche"></textarea>
    <br/>

    <input type="submit" value="Ajouter"/>
</form>
