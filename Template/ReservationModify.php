<form action="index.php?action=modifyReservation&step=insert&reservationId=<?= $reservation->id ?>" method="post">
    <label for="prodLine">Ligne concernée</label>
    <select id="prodLine" name="prodLine" >
        <?php
            foreach($prodLines as $prodLine)
            {
                if($prodLine->id == $reservation->prodLineId)
                {
                    echo '<option value='.htmlspecialchars($prodLine->id).' selected>'.htmlspecialchars($prodLine->name).'</option>';
                }
                else
                {
                    echo '<option value='.htmlspecialchars($prodLine->id).'>'.htmlspecialchars($prodLine->name).'</option>';
                }
            }
        ?>
    </select>

    <!-- Date de début de réservation de ligne -->
    <label for="startDate">Date du début de la réservation</label>
    <input type="date" id="startDate" name="startDate" value=<?= htmlspecialchars($reservation->startDate) ?> required />
    <br/>

    <!-- Date de fin de réservation de ligne -->
    <label for="endDate">Date de fin de la réservation</label>
    <input type="date" id="endDate" name="endDate" value=<?= htmlspecialchars($reservation->endDate) ?> required />
    <br/>

    <input type="submit" value="Valider" />
</form>