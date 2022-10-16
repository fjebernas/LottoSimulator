<?php
include_once "./config/database.php";
include_once "./objects/ticket.php";

$database = new Database();
$db = $database->getConnection();

$page_title = "Lotto Game Home";

include_once "layout_header.php";

$ticket = new Ticket($db);

echo "<h1 class='custom-h1'>Your tickets:</h1>";

// display ticket table
$stmt = $ticket->readAllValidTickets();
include_once "tickets_table.php";

// disable 'proceed' button if no tickets, otherwise, enabled
echo "<div class='buttons'>
        <a href='add_ticket.php' class='btn btn-primary'>Add ticket</a>";
if ($stmt->rowCount() > 0) {
    echo "<a class='btn btn-warning btn-proceed'>Proceed</a>";
} else {
    echo "<a class='btn btn-warning btn-proceed disabled'>Proceed</a>";
}
echo "</div>";

include_once "layout_footer.php";
?>