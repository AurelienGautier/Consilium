<table>
        <?php
            $months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

            echo '<caption><h1>'.$months[$month-1].'</h1></caption>';

            $year = 2022;

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
                // Allow to correctly convert the day index to date
                $stringToAddi = '';
                if($i < 10) $stringToAddi = '0';

                $trId = $year.'-'.'0'.$month.'-'.$stringToAddi.$i;

                echo '<tr id='.$trId.'><th>'.$i.'</th>';

                for($j = 0; $j < count($lines); $j++)
                {
                    echo '<td class="'.$lines[$j]->name.'"></td>';
                }

                echo '</tr>';
            }

            echo '</tbody>';
        ?>
</table>

<script>
    printMonthlyCalendarColors(<?php echo json_encode($reservations).','.json_encode($lines).','.json_encode($month); ?>);
    printMonthlyTasks(<?php echo json_encode($reservations).','.json_encode($tasks).','.json_encode($lines).','.json_encode($month); ?>);
</script>
