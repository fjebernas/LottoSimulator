
<table class="center-text table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
        <th scope="col" class="col-md-1">Ticket ID</th>
        <?php
        for ($i = 1; $i <= Ticket::$combination_count; $i++) {
            echo "<th scope='col' class='col-md-1'>Digit #{$i}</th>";
        }
        ?>
        <th scope="col" class="col-md-1">Roll event ID</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ticket->ticket_id = $row['ticket_id'];

                extract($row);
                
                $td_String = '';
                for ($i = 1; $i <= Ticket::$combination_count; $i++) {
                    $td_String .= $ticket->isWinningDigit(${'digit_' . $i}) ? "<td class='bg-success text-light'>${'digit_' . $i}</td>" : "<td>${'digit_' . $i}</td>";
                }

                echo "<tr>
                            <th scope='row'>{$ticket_id}</td>"
                            . $td_String .
                            "<td>RE: {$roll_event_id}</td>
                        </tr>";
            }
        } else {
            echo "<tr>
                    <td colspan='8'><center><i>No tickets</i></center></td>
                </tr>";
        }
        ?>
    </tbody>
</table>