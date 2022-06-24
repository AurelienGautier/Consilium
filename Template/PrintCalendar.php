<div id="calendar">
    <div id="legend">
        <?php
            for($i = 0; $i < count($reservations); $i++)
            {
                echo '<div class="legend-pack">';
                echo '<div class="legend-color" id="'.$reservations[$i]->color.'"></div>';
                echo $lines[$i]->name;
                echo '</div>';
            }
        ?>
    </div>

    <table>
        <?php
            $year = 2022;
    
            $months = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    
            // Print the months
            echo('<thead>');
            echo('<th></th>');
    
            for($i = 0; $i < 12; $i++) echo('<th>'.$months[$i].'</th>');
    
            echo('</thead>');
    
            // Print the days
            echo('<tbody id="dates">');
    
            for($i = 1; $i <= 31; $i++)
            {
                echo '<tr>';
                echo '<th>'.$i.'</th>';
    
                for($j = 1; $j <= 12; $j++)
                {
                    // Allow to correctly convert the day index to date
                    $stringToAddi = ''; 
                    if($i < 10) $stringToAddi = '0';
                    
                    // Allow to correctly convert the month index to date
                    $stringToAddj = '';
                    if($j < 10) $stringToAddj = '0';
    
                    $actualDate = date_create($year.'-'.$stringToAddj.$j.'-'.$stringToAddi.$i);
                    $tdId= $year.'-'.$stringToAddj.$j.'-'.$stringToAddi.$i;
                    
                    echo '<td id="'.$tdId.'">';
                    echo '</td>';
                }
    
                echo '</tr>';
            }
    
            echo('</tbody>');
        ?>
    
        <script>
            printTasks(<?php echo json_encode($tasks); ?>);
            printCalendarColors(<?php echo json_encode($reservations); ?>);

            var legends = document.getElementsByClassName("legend-color");
            
            for(let i = 0; i < legends.length; i++)
            {
                legends[i].style['background-color'] = legends[i].id;
            }
        </script>
    </table>
</div>
