<h1>Ajout d'une machine</h1>

<form action='index.php?action=addData&step=insert&dataToAdd=machine' method='post'>
    <label for='machineName'>Nom de la machine</label>
    <input type='text' id='machineName' name='machineName' required/>
    <br/>

    <label for="lines">Ligne(s) d'utilisation de la machine</label>
        <?php
            foreach($prodLines as $prodLine)
            {
                echo '<label>'.htmlspecialchars($prodLine->name).'</label>';
                echo '<input name=prodLine[] type="checkbox" value='.htmlspecialchars($prodLine->id).'>';
                echo '<br/>';
            }
        ?>
    <br/>

    <input type='submit' value='Ajouter'/>
</form>
