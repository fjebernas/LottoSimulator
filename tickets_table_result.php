
<table class="center-text table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
        <th scope="col" class="col-md-1">Ticket ID</th>
        <th scope="col" class="col-md-2">First digit</th>
        <th scope="col" class="col-md-2">Second digit</th>
        <th scope="col" class="col-md-2">Third digit</th>
        <th scope="col" class="col-md-1">Roll event ID</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ticket->ticket_id = $row['ticket_id'];
                extract($row);
                $first_digit_td = $ticket->isWinningDigit($first_digit) ? "<td class='bg-success text-light'>{$first_digit}</td>" : "<td>{$first_digit}</td>";
                $second_digit_td = $ticket->isWinningDigit($second_digit) ? "<td class='bg-success text-light'>{$second_digit}</td>" : "<td>{$second_digit}</td>";
                $third_digit_td = $ticket->isWinningDigit($third_digit) ? "<td class='bg-success text-light'>{$third_digit}</td>" : "<td>{$third_digit}</td>";
                echo "<tr>
                            <th scope='row'>{$ticket_id}</td>"
                            . $first_digit_td
                            . $second_digit_td
                            . $third_digit_td .
                            "<td>RE: {$roll_event_id}</td>
                        </tr>";
            }
        } else {
            echo "<tr>
                    <td colspan='5'><center><i>No tickets</i></center></td>
                </tr>";
        }
        ?>
    </tbody>
</table>