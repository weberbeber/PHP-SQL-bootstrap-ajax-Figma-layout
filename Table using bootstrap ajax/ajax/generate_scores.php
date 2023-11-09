<?php
$minScore = 1;
$maxScore = 100;
$randomScore = rand($minScore, $maxScore);

// Возвращаем значение обратно в JavaScript в формате JSON
echo json_encode(['score' => $randomScore]);
