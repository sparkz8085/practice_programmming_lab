<?php
$grade = "";
$mark = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mark = filter_input(INPUT_POST, "marks", FILTER_VALIDATE_INT);
    if ($mark === false || $mark === null || $mark < 0 || $mark > 100) $grade = "Enter marks between 0 and 100.";
    elseif ($mark >= 90) $grade = "Grade: A+";
    elseif ($mark >= 80) $grade = "Grade: A";
    elseif ($mark >= 70) $grade = "Grade: B";
    elseif ($mark >= 60) $grade = "Grade: C";
    elseif ($mark >= 50) $grade = "Grade: D";
    else $grade = "Grade: F";
}
?>
<form method="post"><label>Marks: <input type="number" name="marks" min="0" max="100" required value="<?= htmlspecialchars((string)$mark) ?>"></label><button>Check grade</button></form>
<p><?= htmlspecialchars($grade) ?></p>