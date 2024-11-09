<?php

require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {

    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    public function start() {
        $this->clear();

        $this->repeat = true;

       
        $this->size = (int)readline("Enter the size of the roster: ");

        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            $this->entrance();
        }
    }

    public function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();

            $choice = (int)readline("Enter your choice: ");
            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    $this->repeat = false;
                    break;
                default:
                    echo "Invalid input. Please try again.\n";
                    readline("Press \"Enter\" key to continue...");
                    break;
            }
        }
        echo "Process terminated.\n";
        exit;
    }

    public function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
    }

    public function addMenu() {
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");

        $this->empType($name, $address, $age, $companyName);
    }

    public function empType($name, $address, $age, $companyName) {
        $this->clear();
        echo "--- Employee Type Selection ---\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Type of Employee: ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $companyName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $companyName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $companyName);
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                $this->empType($name, $address, $age, $companyName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $companyName) {
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemSold = (int)readline("Enter number of items sold: ");
        $commissionRate = (float)readline("Enter commission rate per item: ");

        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsHE($name, $address, $age, $companyName) {
        $hoursWorked = (int)readline("Enter hours worked: ");
        $rate = (float)readline("Enter hourly rate: ");

        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $companyName) {
        $numberItems = (int)readline("Enter number of items completed: ");
        $wagePerItem = (float)readline("Enter wage per item: ");

        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "*** List of Employees ***\n";
        $this->roster->display();

        $employeeNumber = (int)readline("Enter the employee number to delete (or 0 to return): ");
        if ($employeeNumber > 0) {
            $this->roster->remove($employeeNumber - 1); 
        }
        readline("Press \"Enter\" key to continue...");
    }

    public function otherMenu() {
        $this->clear();
        echo "[1] Display\n";
        echo "[2] Count\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                readline("Press \"Enter\" key to continue...");
                break;
            case 0:
                break;
            default:
                echo "Invalid input. Please try again.\n";
                readline("Press \"Enter\" key to continue...");
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!\n";
                break;
        }
        readline("Press \"Enter\" key to continue...");
    }

    public function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Commission Employees: " . $this->roster->countCE() . "\n";
                break;
            case 3:
                echo "Hourly Employees: " . $this->roster->countHE() . "\n";
                break;
            case 4:
                echo "Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            case 0:
                return;
            default:
                echo "Invalid Input!\n";
                break;
        }
        readline("Press \"Enter\" key to continue...");
    }

    public function clear() {
        system('clear');
    }

    public function repeat() {
        echo "Employee Added!\n";
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue): ");
            if (strtolower($c) == 'y') {
                $this->addMenu();
            } else {
                $this->entrance();
            }
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}


$main = new Main();
$main->start();
?>
