<?php
$scores = [60, 75, 80, 90, 70];

$sum = array_sum($scores);
$count = count($scores);
$avg = $sum / $count;

$max = max($scores);
$min = min($scores);

$topScores = [];
foreach ($scores as $score) {
    if ($score > $avg) {
        $topScores[] = $score;
    }
}

echo "Avg: " . round($avg) . ", Top: ";
print_r($topScores);
?>
