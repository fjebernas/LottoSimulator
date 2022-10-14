<?php
$event_id = $_POST['event_id'];

include_once "./config/database.php";
include_once "./objects/ticket.php";
include_once "./objects/lottomachine.php";

$database = new Database();
$db = $database->getConnection();

$ticket = new Ticket($db);
$ticket->roll_event_id = $event_id;
$stmt_tickets = $ticket->readAllTicketsWithRollEventId();

if ($stmt_tickets->rowCount() > 0) {
    while ($row = $stmt_tickets->fetch(PDO::FETCH_ASSOC)) {
        $ticket->ticket_id = $row['ticket_id'];
        $ticket->countAndSetMatches();
        $ticket->invalidate();
    }
}

$lottoMachine = new LottoMachine($db);
$lottoMachine->roll_event_id = $event_id;
$stmt_rolls = $lottoMachine->getRollEventRolledDigits();

$page_title = "Lotto results";

include_once "layout_header.php";

echo "<h1 class='custom-h1'>Lotto results: </h1>";
?>

<?php
echo "<div class='rolls-container d-flex flex-row container'>";
if ($stmt_rolls->rowCount() > 0) {
    while ($row = $stmt_rolls->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<div class='text-center card text-white bg-info mb-3' style='max-width: 10rem; margin-right: 10px;'>
                <div class='card-header'>Rolled digit</div>
                <div class='card-body'>
                    <h1 class='card-title'>{$rolled_digit}</h1>
                </div>
            </div>";
    }
}
echo "</div>";
?>

<?php
echo "<h2>Your tickets:</h2 >";
$ticket->roll_event_id = $event_id;
$stmt = $ticket->readAllTicketsWithRollEventId();
include "./tickets_table_result.php";
?>

<div class="buttons">
    <a href="./index.php" class="btn btn-primary">Back to home</a>
</div>

<?php
include_once "layout_footer.php";
?>