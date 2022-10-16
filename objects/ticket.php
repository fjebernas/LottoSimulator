<?php
class Ticket {
    private $conn;
    private $ticket_table_name = "Tickets";
    private $rolls_table_name = "Rolls";

    public static $digit_range = array('min' => 1, 'max' => 20);

    public $ticket_id;
    public $first_digit;
    public $second_digit;
    public $third_digit;
    public $created;
    public $is_valid;
    public $matches;
    public $roll_event_id;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function readAllValidTickets($true = "1") {
        $query = "SELECT 
                    * 
                FROM 
                " . $this->ticket_table_name . " 
                WHERE 
                    is_valid = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $true);

        $stmt->execute();
    
        return $stmt;
    }

    public function readAllTicketsWithRollEventId() {
        $query = "SELECT 
                    * 
                FROM 
                " . $this->ticket_table_name . " 
                WHERE 
                    roll_event_id = ?";

        $this->roll_event_id = htmlspecialchars(strip_tags($this->roll_event_id));

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->roll_event_id);

        $stmt->execute();
    
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO 
                    " . $this->ticket_table_name . " 
                SET 
                    first_digit=:first_digit, 
                    second_digit=:second_digit, 
                    third_digit=:third_digit, 
                    created=:created";
                        
        $stmt = $this->conn->prepare($query);

        $this->first_digit = htmlspecialchars(strip_tags($this->first_digit));
        $this->second_digit = htmlspecialchars(strip_tags($this->second_digit));
        $this->third_digit = htmlspecialchars(strip_tags($this->third_digit));

        date_default_timezone_set('Asia/Manila');
        $this->created = date('Y-m-d H:i:s');

        $stmt->bindParam(":first_digit", $this->first_digit);
        $stmt->bindParam(":second_digit", $this->second_digit);
        $stmt->bindParam(":third_digit", $this->third_digit);
        $stmt->bindParam(":created", $this->created);

        return $stmt->execute();
    }

    public function register() {
        $query = "UPDATE 
                " . $this->ticket_table_name . " 
                SET 
                    roll_event_id=:roll_event_id 
                WHERE 
                    ticket_id=:ticket_id";

        $stmt = $this->conn->prepare($query);

        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));
        $this->roll_event_id = htmlspecialchars(strip_tags($this->roll_event_id));

        $stmt->bindParam(":ticket_id", $this->ticket_id);
        $stmt->bindParam(":roll_event_id", $this->roll_event_id);

        return $stmt->execute();
    }

    public function countAndSetMatches($true = true) {
        $query = "SELECT 
                    first_digit, 
                    second_digit, 
                    third_digit 
                FROM 
                " . $this->ticket_table_name . " 
                WHERE 
                    ticket_id=:ticket_id 
                AND 
                    is_valid=:is_valid";

        $stmt = $this->conn->prepare($query);
        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

        $stmt->bindParam(":ticket_id", $this->ticket_id);
        $stmt->bindParam(":is_valid", $true);

        try {
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if ($this->isWinningDigit($row['first_digit'])) {
                        $this->updateMatchesAdd(1);
                    }
                    if ($this->isWinningDigit($row['second_digit'])) {
                        $this->updateMatchesAdd(1);
                    }
                    if ($this->isWinningDigit($row['third_digit'])) {
                        $this->updateMatchesAdd(1);
                    }
                    $this->updateMatchesAdd(0);
                }
            }
            return true;
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
    }

    public function isWinningDigit($digit) {
        $query = "SELECT 
                    rolled_digit 
                FROM 
                " . $this->rolls_table_name . " 
                WHERE 
                    rolled_digit=:digit 
                AND 
                    roll_event_id=:roll_event_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":digit", $digit);
        $stmt->bindParam(":roll_event_id", $this->roll_event_id);

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;
        } else {
            return true;
        }
    }

    private function updateMatchesAdd($num) {
        $query = "UPDATE 
                " . $this->ticket_table_name . " 
                SET 
                    matches=:matches 
                WHERE 
                    ticket_id=:ticket_id";

        $stmt = $this->conn->prepare($query);

        $this->matches = htmlspecialchars(strip_tags($this->getMatchesCount()) + $num);
        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

        $stmt->bindParam(":matches", $this->matches);
        $stmt->bindParam(":ticket_id", $this->ticket_id);

        $stmt->execute();
    }

    private function getMatchesCount() {
        $query = "SELECT 
                    matches 
                FROM 
                " . $this->ticket_table_name . " 
                WHERE 
                    ticket_id=?";

        $stmt = $this->conn->prepare($query);

        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

        $stmt->bindParam(1, $this->ticket_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['matches'] === null) {
            return 0;
        } else {
            return $row['matches'];
        }
    }

    public function invalidate($false = false) {
        $query = "UPDATE " . $this->ticket_table_name . " SET is_valid=:is_valid WHERE ticket_id=:ticket_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":is_valid", $false);
        $stmt->bindParam(":ticket_id", $this->ticket_id);

        return $stmt->execute();
    }
}
?>