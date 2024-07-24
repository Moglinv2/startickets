<?php
// movies.php
header('Content-Type: application/json');

echo json_encode([
    "verAhora" => [
        "tt9362726", // Spider-Man: Across the Spider-Verse
        "tt6791350", // Guardians of the Galaxy Vol. 3
        "tt10366206", // John Wick: Chapter 4
        "tt2771200"  // The Little Mermaid
    ],
    "proximamente" => [
        "tt9032400", // Dune: Part Two
        "tt5742374", // Killers of the Flower Moon
        "tt6343314", // The Marvels
        "tt1690956"  // Aquaman and the Lost Kingdom
    ]
]);
?>
