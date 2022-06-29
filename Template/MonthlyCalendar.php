<div id="nav-link">
    <div id="previous"><button>Précédent</button></div>
    <div id="next"><button>Suivant</button></div>
</div>

<table>
    <caption id="month"></caption>
    <?php
        echo '<thead>';
        echo '<tr>';
        echo '<th></th>';

        foreach($lines as $line)
        {
            echo '<th>'.$line->name.'</th>';
        }
        echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        for($i = 1; $i <= 31; $i++)
        {
            echo '<tr><th>'.$i.'</th>';

            foreach($lines as $line)
            {
                echo '<td class='.$line->name.'></td>';
            }

            echo '</tr>';
        }

        echo '</tbody>';
    ?>
</table>

<script>
    let tasks = <?php echo json_encode($tasks) ?>;
    let reservations = <?php echo json_encode($reservations) ?>;
    let lines = <?php echo json_encode($lines) ?>;

    let calendar = new MonthlyCalendar(tasks, reservations, lines);
    calendar.load();

    let next = document.getElementById('next');
    let previous = document.getElementById('previous');

    next.onclick = function() { calendar.changeMonth('next'); }
    previous.onclick = function() { calendar.changeMonth('previous'); }

</script>
