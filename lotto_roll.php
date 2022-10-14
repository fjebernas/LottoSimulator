<?php
$event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;

include_once "./config/database.php";
include_once "./objects/ticket.php";
include_once "./objects/lottomachine.php";

$database = new Database();
$db = $database->getConnection();

$ticket = new Ticket($db);

$lottoMachine = new LottoMachine($db);

$page_title = "Lotto roll";

include_once "layout_header.php";

echo "<h1 class='custom-h1'>Its RNG time.</h1>";

if (!isset($event_id)) {
    if ($lottoMachine->createRollEvent()) {
        $lottoMachine->setRollEventID();

        $stmt = $ticket->readAllValidTickets();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $ticket->ticket_id = $row['ticket_id'];
                $ticket->roll_event_id = $lottoMachine->roll_event_id;
                $ticket->register();
            }
        }
        echo "<div class='alert alert-success'>Created roll event with ID: " . $lottoMachine->roll_event_id . ". Tickets are also registered.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed creating roll event.</div>";
    }
}
?>

<?php
//if form was submitted
if ($_POST) {
    $lottoMachine->roll_event_id = $_POST['event_id'];
    $lottoMachine->roll_counter += $_POST['roll_counter'] === 0 ? 1: $_POST['roll_counter'];
    
    if ($lottoMachine->roll()) {
        $lottoMachine->roll_counter = $lottoMachine->roll_counter + 1;
        echo "<div class='alert alert-success'>Roll success. " . $lottoMachine->roll_counter . "th digit is " . $lottoMachine->rolled_digit . "</div>";
    } else {
        echo "<div class='alert alert-danger'>Roll fail.</div>";
    }
}
?>

<div class="jumbotron">
    <h1 class="display-4">
        <?php 
        echo isset($lottoMachine->rolled_digit) ? $lottoMachine->rolled_digit : "--";
        ?>
    </h1>
    <p class="lead">Rolled number</p>
    <p class="lead">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="hidden" name="event_id" value="<?php echo $lottoMachine->roll_event_id; ?>">
            <input type="hidden" name="roll_counter" value="<?php echo $lottoMachine->roll_counter; ?>">
            <?php
            if ($lottoMachine->roll_counter < 5) {
                echo "<button class='btn btn-primary btn-lg' type='submit'>Roll!</button>";
            } else {
                echo "</form>";
                echo "<form action='./lotto_results.php' method='post'>";
                echo "<input type='hidden' name='event_id' value='" . $event_id . "'>";
                echo "<button class='btn btn-info btn-lg' type='submit'>See results</button>";
            }
            ?>
        </form>
    </p>
</div>

<?php
echo "<h2>Your tickets:</h2 >";
$ticket->roll_event_id = $lottoMachine->roll_event_id;
$stmt = $ticket->readAllTicketsWithRollEventId();
include "./tickets_table_result.php";
?>

<?php
include_once "layout_footer.php";
?>