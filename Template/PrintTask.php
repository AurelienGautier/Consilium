<table>
    <tr>
        <th>Nom de la tâche</th>
        <td><?= htmlspecialchars($task->name) ?></td>
    </tr>
    <tr>
        <th>Type de tâche</th>
        <td><?= htmlspecialchars($taskType->name) ?></td>
    </tr>
    <tr>
        <th>Date de début</th>
        <td><?= htmlspecialchars($task->startDate) ?></td>
    </tr>
    <tr>
        <th>Date de fin</th>
        <td><?= htmlspecialchars($task->endDate) ?></td>
    </tr>
    <?php
        if($supplier != null)
        {
            echo '<tr>
                    <th>Fournisseur intervenant</th>
                    <td>'.htmlspecialchars($supplier->name).'</td>
                  </tr>';
        }
    ?>
    <?php
        if($task->description != null)
        {
            echo '<tr>
                    <th>Description</th>
                    <td>'.htmlspecialchars($task->description).'</td>
                  </tr>';
        }
    ?>
</table>
