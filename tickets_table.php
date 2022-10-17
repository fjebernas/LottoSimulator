
<table class="center-text table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
        <th scope="col" class="col-md-1">Ticket ID</th>
        <?php
        for ($i = 1; $i <= Ticket::$combination_count; $i++) {
            echo "<th scope='col' class='col-md-1'>Digit #{$i}</th>";
        }
        ?>
        <th scope="col" class="col-md-2">Date created</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                
                $td_String = '';
                for ($i = 1; $i <= Ticket::$combination_count; $i++) {
                    $td_String .= "<td>${'digit_' . $i}</td>";
                }

                echo "<tr>
                            <th scope='row'>{$ticket_id}</td>"
                            . $td_String .
                            "<td>{$created}</td>
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