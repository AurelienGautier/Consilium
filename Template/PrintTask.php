<table>
    <tr>
        <th>Nom de la tâche</th>
        <td><?= $task->name ?></td>
    </tr>
    <tr>
        <th>Type de tâche</th>
        <td><?= $taskType->name ?></td>
    </tr>
    <tr>
        <th>Date de début</th>
        <td><?= $task->startDate ?></td>
    </tr>
    <tr>
        <th>Date de fin</th>
        <td><?= $task->endDate ?></td>
    </tr>
    <?php
        if($supplier != null)
        {
            echo '<tr>
                    <th>Fournisseur intervenant</th>
                    <td>'.$supplier->name.'</td>
                  </tr>';
        }
    ?>
    <?php
        if($task->description != null)
        {
            echo '<tr>
                    <th>Description</th>
                    <td>'.$task->description.'</td>
                  </tr>';
        }
    ?>
</table>
