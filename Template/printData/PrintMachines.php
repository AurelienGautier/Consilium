<table id="printData">
    <tr>
        <th>Nom machine</th>
        <th>Ligne(s)</th>
    </tr>

    <?php
        foreach($machines as $key => $machine)
        {
            echo '<tr>';
            echo '<td>'.htmlspecialchars($machine->name).'</td>';

            echo '<td>';
            
            foreach($machineProdLines[$key] as $machineProdLine)
            {
                echo(htmlspecialchars($machineProdLine->name) . '<br/>');
            }

            echo '</td>';

            echo '</tr>';
        }
    ?>
</table>