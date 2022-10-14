
<table class="center-text table table-hover table-bordered">
    <thead class="thead-light">
        <tr>
        <th scope="col" class="col-md-1">Ticket ID</th>
        <th scope="col" class="col-md-2">First digit</th>
        <th scope="col" class="col-md-2">Second digit</th>
        <th scope="col" class="col-md-2">Third digit</th>
        <th scope="col" class="col-md-3">Date created</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>
                            <th scope='row'>{$ticket_id}</td>
                            <td>{$first_digit}</td>
                            <td>{$second_digit}</td>
                            <td>{$third_digit}</td>
                            <td>{$created}</td>
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