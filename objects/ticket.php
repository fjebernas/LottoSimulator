<?php
class Ticket {
    private $conn;
    private $ticket_table_name = "6_42_tickets";
    private $rolls_table_name = "Rolls";

    public static $combination_count = 6;
    public static $digit_range = array('min' => 1, 'max' => 42);

    public $ticket_id;

    public $digits = array(1 => '', 
                        2 => '',
                        3 => '',
                        4 => '',
                        5 => '',
                        6 => ''
                    );
    public $created;
    public $is_valid;
    public $matched_digits;
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
        $digits_query_component = '';
        for ($i = 1; $i <= count($this->digits); $i++) {
            $digits_query_component .= 'digit_' . $i . '=:' . 'digit_' . $i . ',';
        }

        $query = "INSERT INTO 
                    " . $this->ticket_table_name . " 
                SET "
                    . $digits_query_component
                    . "created=:created";
                        
        $stmt = $this->conn->prepare($query);

        for ($i = 1; $i <= count($this->digits); $i++) {
            $this->digits[$i] = htmlspecialchars(strip_tags($this->digits[$i]));
        }

        date_default_timezone_set('Asia/Manila');
        $this->created = date('Y-m-d H:i:s');

        for ($i = 1; $i <= count($this->digits); $i++) {
            $stmt->bindParam(':' . 'digit_' . $i, $this->digits[$i]);
        }
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

    public function countAndSetMatchedDigits($true = true) {
        $digits_query_component = '';
        for ($i = 1; $i <= count($this->digits); $i++) {
            $digits_query_component .= 'digit_' . $i;
            $digits_query_component .= $i < count($this->digits) ? ',' : ' ';
        }

        $query = "SELECT "
                    . $digits_query_component .
                "FROM 
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
                    for ($i = 1; $i <= count($this->digits); $i++) {
                        if ($this->isWinningDigit($row['digit_' . $i])) {
                            $this->updateMatchedDigitsAdd(1);
                        }
                    }
                    $this->updateMatchedDigitsAdd(0);
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

    private function updateMatchedDigitsAdd($num) {
        $query = "UPDATE 
                " . $this->ticket_table_name . " 
                SET 
                    matched_digits=:matched_digits 
                WHERE 
                    ticket_id=:ticket_id";

        $stmt = $this->conn->prepare($query);

        $this->matched_digits = htmlspecialchars(strip_tags($this->getMatchedDigitsCount()) + $num);
        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

        $stmt->bindParam(":matched_digits", $this->matched_digits);
        $stmt->bindParam(":ticket_id", $this->ticket_id);

        $stmt->execute();
    }

    private function getMatchedDigitsCount() {
        $query = "SELECT 
                    matched_digits 
                FROM 
                " . $this->ticket_table_name . " 
                WHERE 
                    ticket_id=?";

        $stmt = $this->conn->prepare($query);

        $this->ticket_id = htmlspecialchars(strip_tags($this->ticket_id));

        $stmt->bindParam(1, $this->ticket_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['matched_digits'] === null) {
            return 0;
        } else {
            return $row['matched_digits'];
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