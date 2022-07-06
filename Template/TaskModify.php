<?php
    echo('<h1>Modification d\'une tâche sur la ligne '.htmlspecialchars($prodLine->name).'.</h1>');
?>

<form id="formAddTask" action="index.php?action=modifyTask&step=insert&taskId=<?= $task->id ?>" method="post">
    <label for="name">Nom de la tâche</label>
    <input type="text" id="name" name="name" placeholder="Nom de la tâche" value="<?= htmlspecialchars($task->name) ?>" required/>
    <br/>

    <!-- Type d'arrêt -->
    <label for="type">Type de tâche</label>
    <select id="type" name="type">
        <?php
            foreach($taskTypes as $taskType)
            {
                if($taskType->id == $task->type)
                    echo '<option value='.htmlspecialchars($taskType->id).' selected>'.htmlspecialchars($taskType->name).'</option>';
                else 
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
                if($machine->id == $task->machineId)
                    echo '<option value='.htmlspecialchars($machine->id).' selected>'.htmlspecialchars($machine->name).'</option>';
                else
                    echo '<option value='.htmlspecialchars($machine->id).' selected>'.htmlspecialchars($machine->name).'</option>';
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
                if($task->supplierId == $supplier->id)
                    echo '<option value='.htmlspecialchars($supplier->id).' selected>'.htmlspecialchars($supplier->name).'</option>';
                else
                    echo '<option value='.htmlspecialchars($supplier->id).'>'.htmlspecialchars($supplier->name).'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Date de l'arrêt -->
    <label for="startkDate">Date du début de la tâche</label>
    <input type="date" id="startDate" name="startDate" value=<?= htmlspecialchars($task->startDate) ?> min=<?= htmlspecialchars($reservation->startDate) ?> max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Date de fin de l'arrêt -->
    <label for="endDate">Date de fin de la tâche</label>
    <input type="date" id="endDate" name="endDate" value=<?= htmlspecialchars($task->endDate) ?> min=<?= htmlspecialchars($reservation->startDate) ?> max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Description de la tâche -->
    <label for="description">Description de la tâche</label>
    <textarea id="description" name="description" placeholder="Description de la tâche"><?= $task->description ?></textarea>
    <br/>

    <input type="submit" value="Ajouter"/>
</form>