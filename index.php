<?php
include_once "./config/database.php";
include_once "./objects/ticket.php";

$database = new Database();
$db = $database->getConnection();

$page_title = "Lotto Game Home";

include_once "layout_header.php";

$ticket = new Ticket($db);

echo "<h1 class='custom-h1'>Your tickets:</h1>";

$stmt = $ticket->readAllValidTickets();
include_once "tickets_table.php";

echo "<div class='buttons'>
        <a href='add_ticket.php' class='btn btn-primary'>Add ticket</a>";

if ($stmt->rowCount() > 0) {
    echo "<a href='lotto_roll.php' class='btn btn-warning'>Proceed</a>";
} else {
    echo "<a href='lotto_roll.php' class='btn btn-warning disabled'>Proceed</a>";
}

echo "</div>";



include_once "layout_footer.php";
?>