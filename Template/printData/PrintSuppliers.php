<table id="printData">
    <tr><th>Nom fournisseur</th></tr>

    <?php
        foreach($suppliers as $supplier)
        {
            echo '<tr>';
            echo '<td>'.htmlspecialchars($supplier->name).'</td>';
            echo '</tr>';
        }
    ?>
</table>