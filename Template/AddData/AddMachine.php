<h1>Ajout d'une machine</h1>

<form action='index.php?action=addData&step=insert&dataToAdd=machine' method='post'>
    <label for='machineName'>Nom de la machine</label>
    <input type='text' id='machineName' name='machineName' required/>
    <br/>

    <label for="prodLine">Ligne de production de la machine</label>
    <select id="prodLine" name="prodLine">
        <?php
            foreach($prodLines as $prodLine)
            {
                echo '<option value='.$prodLine->id.'>'.$prodLine->name.'</option>';
            }
        ?>
    </select>
    <br/>

    <input type='submit' value='Ajouter'/>
</form>
