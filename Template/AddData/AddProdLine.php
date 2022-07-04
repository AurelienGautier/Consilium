<h1>Ajout d'une ligne de production</h1>

<form action='index.php?action=addData&step=insert&dataToAdd=prodLine' method='post'>
    <!-- Name of the production line -->
    <label for='prodLineName'>Nom de la ligne de production</label>
    <input type='text' id='prodLineName' name='prodLineName' required/>
    <br/>

    <!-- Color on the calendar -->
    <label for="color">Couleur sur le calendrier</label>
    <input type="color" id="color" name="color"/>
    <br/>

    <input type='submit' value='Ajouter'/>
</form>
