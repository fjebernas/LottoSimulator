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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="form-group">
        <label for="digit1">First digit:</label>
        <select name="first_digit" class="form-control" id="digit1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
        </select>
    </div>
    <div class="form-group">
        <label for="digit2">First digit:</label>
        <select name="second_digit" class="form-control" id="digit2">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
        </select>
    </div>
    <div class="form-group">
        <label for="digit3">First digit:</label>
        <select name="third_digit" class="form-control" id="digit3">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
        </select>
    </div>
    <a href="./index.php" class="btn btn-danger">Cancel</a>
    <button type="submit" class="btn btn-success">Submit</button>
</form>

<?php
include_once "layout_footer.php";
?>