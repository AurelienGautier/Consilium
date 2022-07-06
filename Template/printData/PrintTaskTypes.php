<table id="printData">
    <tr><th>Nom type de tâche</th></tr>
    <?php
        foreach($taskTypes as $taskType)
        {
            echo '<tr>';

            echo '<td>'.htmlspecialchars($taskType->name).'</td>';

            echo '</tr>';
        }
    ?>
</table>