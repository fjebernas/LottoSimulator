<?php
include_once "./config/database.php";
include_once "./objects/ticket.php";

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

$page_title = "Create ticket";

include_once "layout_header.php";
?>

<h1 class="custom-h1">Create new ticket:</h1>

<?php
//if form was submitted
if ($_POST) {
    $ticket->first_digit = $_POST['first_digit'];
    $ticket->second_digit = $_POST['second_digit'];
    $ticket->third_digit = $_POST['third_digit'];

    if ($ticket->create()) {
        echo "<div class='alert alert-success'>Ticket successfully created.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed creating ticket.</div>";
    }
}
?>

<!-- hidden div for holding digit range data to be used in js -->
<div class="d-none concealed-data" 
    data-range-min=<?php echo Ticket::$digit_range['min'] ?> 
    data-range-max=<?php echo Ticket::$digit_range['max'] ?>>
</div>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chkbx-random-digits">
        <label class="form-check-label" for="chkbx-random-digits">Random digits</label>
    </div>
    <div class="form-group">
        <label for="digit1">First digit:</label>
        <select name="first_digit" class="form-control" id="digit1">
            <?php
            for ($i=Ticket::$digit_range['min']; $i <= Ticket::$digit_range['max']; $i++) {
                echo "<option>" . $i . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="digit2">Second digit:</label>
        <select name="second_digit" class="form-control" id="digit2">
            <?php
            for ($i=Ticket::$digit_range['min']; $i <= Ticket::$digit_range['max']; $i++) {
                echo "<option>" . $i . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="digit3">Third digit:</label>
        <select name="third_digit" class="form-control" id="digit3">
            <?php
            for ($i=Ticket::$digit_range['min']; $i <= Ticket::$digit_range['max']; $i++) {
                echo "<option>" . $i . "</option>";
            }
            ?>
        </select>
    </div>
    <a href="./prepare_tickets.php" class="btn btn-danger">Go back</a>
    <button type="submit" class="btn btn-success">Submit</button>
</form>

<?php
include_once "layout_footer.php";
?>