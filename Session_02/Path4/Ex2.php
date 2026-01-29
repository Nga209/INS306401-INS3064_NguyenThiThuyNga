<?php
$students = [
    ['name' => 'A', 'grade' => 90],
    ['name' => 'B', 'grade' => 78],
    ['name' => 'C', 'grade' => 85]
];

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Grade</th></tr>";

foreach ($students as $student) {
    echo "<tr>";
    echo "<td>{$student['name']}</td>";
    echo "<td>{$student['grade']}</td>";
    echo "</tr>";
}

echo "</table>";
?>
