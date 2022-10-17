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
    for ($i = 1; $i <= Ticket::$combination_count; $i++) {
        $ticket->digits[$i] = $_POST['digit' . $i];
    }

    if ($ticket->create()) {
        echo "<div class='alert alert-success'>Ticket successfully created.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed creating ticket.</div>";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chkbx-random-digits">
        <label class="form-check-label" for="chkbx-random-digits">Random digits</label>
    </div>

    <?php
    // create a string and populate it with options for the select inputs depending on the digit range from Ticket
    $optionString = '';
    for ($digit=Ticket::$digit_range['min']; $digit <= Ticket::$digit_range['max']; $digit++) {
        $optionString .= '<option>' . $digit . '</option>';
    }

    // generate n amount of select inputs depending on the combination count from Ticket class
    for ($i=1; $i<=Ticket::$combination_count; $i++) {
        echo "<div class='form-group'>
                <label for='digit{$i}'>Digit #{$i}:</label>
                <select name='digit{$i}' class='form-control' id='digit{$i}'>"
                . $optionString .
                "</select>
            </div>";
    }
    ?>

    <a href="./prepare_tickets.php" class="btn btn-danger">Go back</a>
    <button type="submit" class="btn btn-success">Submit</button>
</form>

<!-- hidden div for holding digit range data to be used in js -->
<div class="d-none concealed-data" 
    data-range-min=<?php echo Ticket::$digit_range['min'] ?> 
    data-range-max=<?php echo Ticket::$digit_range['max'] ?>>
</div>

<?php
include_once "layout_footer.php";
?>