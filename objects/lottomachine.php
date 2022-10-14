<?php
class LottoMachine {
    private $conn;
    private $roll_event_table_name = "Roll_Events";
    private $rolls_table_name = "Rolls";

    public $rolled_digit;
    public $roll_event_id;
    public $timestamp;

    public $roll_counter = 0;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createRollEvent() {
        $query = "INSERT INTO 
                    " . $this->roll_event_table_name . " 
                    SET 
                        created=:created";

        $stmt = $this->conn->prepare($query);

        date_default_timezone_set('Asia/Manila');
        $this->timestamp = date('Y-m-d H:i:s');

        $stmt->bindParam(":created", $this->timestamp);
        
        return $stmt->execute();
    }

    public function setRollEventID() {
        $query = "SELECT 
                        roll_event_id 
                    FROM 
                        " . $this->roll_event_table_name . " 
                    WHERE 
                        created = ? 
                    LIMIT 
                        0,1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->timestamp);
        $stmt->execute();
    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $this->roll_event_id = $row['roll_event_id'];
    }

    public function roll() {
        $randomDigit = null;

        do {
            $randomDigit = rand(1, 15);
        } while ($this->isDigitAlreadyInTable($randomDigit));

        $query = "INSERT INTO 
                    " . $this->rolls_table_name . " 
                    SET 
                        rolled_digit=:rolled_digit, 
                        created=:created, 
                        roll_event_id=:roll_event_id";

        $stmt = $this->conn->prepare($query);

        $this->rolled_digit = $randomDigit;
        $this->roll_event_id = htmlspecialchars(strip_tags($this->roll_event_id));

        date_default_timezone_set('Asia/Manila');
        $this->timestamp = date('Y-m-d H:i:s');

        $stmt->bindParam(":rolled_digit", $this->rolled_digit);
        $stmt->bindParam(":roll_event_id", $this->roll_event_id);
        $stmt->bindParam(":created", $this->timestamp);
        
        return $stmt->execute();
    }

    function isDigitAlreadyInTable($digit) {
        $query = "SELECT 
                        rolled_digit, 
                        roll_event_id 
                    FROM 
                    " . $this->rolls_table_name . " 
                    WHERE 
                        rolled_digit = ?
                    AND 
                        roll_event_id= " . $this->roll_event_id;

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $digit);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false;
        }
        return true;
    }

    function getRollEventRolledDigits() {
        $query = "SELECT rolled_digit FROM " . $this->rolls_table_name . " WHERE roll_event_id=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->roll_event_id);
        $stmt->execute();

        return $stmt;
    }
}
?>