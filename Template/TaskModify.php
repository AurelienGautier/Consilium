<?= $title ?>

<form id="formAddTask" action="<?= $url ?>" method="post">
    <label for="name">Nom de la tâche</label>
    <input type="text" id="name" name="name" placeholder="Nom de la tâche" value="<?= htmlspecialchars($taskName) ?>" required/>
    <br/>

    <!-- Type d'arrêt -->
    <label for="type">Type de tâche</label>
    <select id="type" name="type">
        <?php
            foreach($types as $type)
            {
                if($type->id == $taskType)
                    echo '<option value='.htmlspecialchars($type->id).' selected>'.htmlspecialchars($type->name).'</option>';
                else 
                    echo '<option value='.htmlspecialchars($type->id).'>'.htmlspecialchars($type->name).'</option>';
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
                if($machine->id == $taskMachine)
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
                if($taskSupplier == $supplier->id)
                    echo '<option value='.htmlspecialchars($supplier->id).' selected>'.htmlspecialchars($supplier->name).'</option>';
                else
                    echo '<option value='.htmlspecialchars($supplier->id).'>'.htmlspecialchars($supplier->name).'</option>';
            }
        ?>
    </select>
    <br/>

    <!-- Date de l'arrêt -->
    <label for="startkDate">Date du début de la tâche</label>
    <input type="date" id="startDate" name="startDate" value="<?= htmlspecialchars($taskStartDate) ?>" min="<?= $reservation->startDate ?>" max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Date de fin de l'arrêt -->
    <label for="endDate">Date de fin de la tâche</label>
    <input type="date" id="endDate" name="endDate" value="<?= htmlspecialchars($taskEndDate) ?>" min=<?= htmlspecialchars($reservation->startDate) ?> max=<?= htmlspecialchars($reservation->endDate) ?> />
    <br/>

    <!-- Description de la tâche -->
    <label for="description">Description de la tâche</label>
    <textarea id="description" name="description" placeholder="Description de la tâche"><?= $taskDescription ?></textarea>
    <br/>

    <input type="submit" value="Ajouter"/>
</form>