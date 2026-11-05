<?php
class Student {
    public string $name;
    public int $rollNo;
    public function __construct(string $name, int $rollNo) {
        $this->name = $name;
        $this->rollNo = $rollNo;
    }
    public function display(): string {
        return "Name: " . htmlspecialchars($this->name) . "<br>Roll No: " . $this->rollNo;
    }
}
$student = new Student("John", 2);
echo $student->display();
?>