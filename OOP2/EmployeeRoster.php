<?php
class EmployeeRoster {
    private $roster = [];

    public function __construct($rosterSize) {
        $this->roster = array_fill(0, $rosterSize, null);
    }

    public function add(Employee $e) {
        foreach ($this->roster as $key => $employee) {
            if ($employee === null) {
                $this->roster[$key] = $e;
                return;
            }
        }
    }

    public function remove($index) {
        if (isset($this->roster[$index])) {
            $this->roster[$index] = null;
        }
    }

    public function count() {
        return count(array_filter($this->roster));
    }

    public function countCE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof CommissionEmployee));
    }

    public function countHE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof HourlyEmployee));
    }

    public function countPE() {
        return count(array_filter($this->roster, fn($e) => $e instanceof PieceWorker));
    }

    public function display() {
        foreach ($this->roster as $employee) {
            if ($employee !== null) echo $employee . PHP_EOL;
        }
    }

    public function displayCE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof CommissionEmployee) echo $employee . PHP_EOL;
        }
    }

    public function displayHE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof HourlyEmployee) echo $employee . PHP_EOL;
        }
    }

    public function displayPE() {
        foreach ($this->roster as $employee) {
            if ($employee instanceof PieceWorker) echo $employee . PHP_EOL;
        }
    }

    public function payroll() {
        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo $employee->getName() . "'s Earnings: " . $employee->earnings() . PHP_EOL;
            }
        }
    }
}
?>
