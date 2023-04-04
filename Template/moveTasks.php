Des tâches ont été attribuées sur la réservation de ligne à déplacer. 
<form>

    <?php
    foreach($tasks as $key => $task) 
    { ?>
        <div class="taskToChange">
            <p><?= $task->name ?> : </p>

            <div>
                <label for="start<?= $key ?>">Date de début de la tâche</label>
                <input id="start<?= $key ?>" type="date" name="taskStartDate[]" value=<?= $task->startDate ?>>
            </div>

            <div>
                <label for="end<?= $key ?>">Date de fin de la tâche</label>
                <input id="end<?= $key ?>" type="date" name="taskEndDate[]" value=<?= $task->endDate ?>>
            </div>
        </div>
    <?php } ?>

</form>