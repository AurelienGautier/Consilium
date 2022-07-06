<table id="printData">
    <tr><th>Nom ligne de production</th></tr>
    <?php
        foreach($prodLines as $prodLine)
        {
            echo '<tr>';

            echo '<td>'.htmlspecialchars($prodLine->name).'</td>';

            echo '</tr>';
        }
    ?>
</table>