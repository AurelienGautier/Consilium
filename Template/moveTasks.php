<form method="post" action="index.php?action=modifyReservation&step=insert&reservationId=<?= $reservationId ?>&taskModified=1">
    Des tâches ont été attribuées sur la réservation de ligne à déplacer. 

    <?php
    foreach($tasks as $key => $task) 
    { ?>
        <div class="taskToChange">
            <p><?= $task->name ?> : </p>

            <input name="taskId[]" value=<?= $task->id ?> hidden>

            <div>
                <label for="start<?= $key ?>">Date de début de la tâche</label>
                <input id="start<?= $key ?>" type="date" min="<?= $fields['startDate'] ?>" max="<?= $fields['endDate'] ?>" name="taskStartDate[]">
            </div>

            <div>
                <label for="end<?= $key ?>">Date de fin de la tâche</label>
                <input id="end<?= $key ?>" type="date" min="<?= $fields['startDate'] ?>" max="<?= $fields['endDate'] ?>" name="taskEndDate[]">
            </div>
        </div>
    <?php } ?>

    <input name="startDate" value="<?= $fields['startDate'] ?>" hidden>
    <input name="endDate" value="<?= $fields['endDate'] ?>" hidden>
    <input name="prodLine" value="<?= $fields['prodLine'] ?>" hidden>

    <input type="submit" value="Saisir les modifications"/>
</form>