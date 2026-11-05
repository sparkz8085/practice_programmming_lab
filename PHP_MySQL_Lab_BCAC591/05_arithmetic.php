<?php
$result = null;
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $a = filter_input(INPUT_POST, "a", FILTER_VALIDATE_FLOAT);
    $b = filter_input(INPUT_POST, "b", FILTER_VALIDATE_FLOAT);
    $op = $_POST["op"] ?? "";
    if ($a === false || $a === null || $b === false || $b === null) $error = "Enter valid numbers.";
    elseif ($op === "divide" && (float)$b == 0.0) $error = "Division by zero is not allowed.";
    else {
        switch ($op) {
            case "add": $result = $a + $b; break;
            case "minus": $result = $a - $b; break;
            case "multiply": $result = $a * $b; break;
            case "divide": $result = $a / $b; break;
            case "modulus": $result = fmod($a, $b); break;
            default: $error = "Choose an operation.";
        }
    }
}
?>
<form method="post"><input type="number" step="any" name="a" required><input type="number" step="any" name="b" required><select name="op"><option value="add">Addition</option><option value="minus">Minus</option><option value="multiply">Multiplication</option><option value="divide">Division</option><option value="modulus">Modulus</option></select><button>Calculate</button></form>
<?php if ($error) echo htmlspecialchars($error); if ($result !== null) echo "Result: " . htmlspecialchars((string)$result); ?>