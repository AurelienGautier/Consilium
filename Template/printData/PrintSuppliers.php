<table id="printData">
    <tr><th>Nom fournisseur</th></tr>

    <?php
        foreach($suppliers as $supplier)
        {
            echo '<tr>';
            echo '<td>'.$supplier->name.'</td>';
            echo '</tr>';
        }
    ?>
</table>