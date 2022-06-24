<form action="index.php?action=addReservation&step=insert" method="post">
    <!-- Choix de la ligne -->
    <label for="taskService">Ligne concernée</label>
    <select id="taskService" name="taskService">
        <?php
            foreach($prodLines as $prodLine)
            {
                echo('<option value="'.$prodLine->id.'">'.$prodLine->name.'</option>');
            }
        ?>
    </select>
    <br/>

    <!-- Date de début de réservation de ligne -->
    <label for="taskDate">Date du début de la réservation</label>
    <input type="date" id="taskDate" name="taskDate" />
    <br/>

    <!-- Date de fin de réservation de ligne -->
    <label for="endTaskDate">Date de fin de la réservation</label>
    <input type="date" id="endTaskDate" name="endTaskDate" />
    <br/>

    <!-- Couleur sur le calendrier -->
    <label for="colorOnCalendar">Couleur sur le calendrier</label>
    <input type="color" id="calendarColor" name="calendarColor"/>
    <br/>

    <input type="submit" value="Choisir"/>
</form>
