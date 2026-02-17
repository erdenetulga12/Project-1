<?php

// Read input from user
echo "Enter input filename: ";
$fileName = trim(fgets(STDIN));

// Check if file exists
if (!file_exists($fileName)) {
    echo "Error: File not found.\n";
    exit(1);
}

// Read file contents
$code = file_get_contents($fileName);

// Remove single-line comments
$codeNoLineComments = preg_replace('#//.*#', '', $code);

// Remove block comments
$codeNoComments = preg_replace('#/\*[\s\S]*?\*/#', '', $codeNoLineComments);

// If "/*" still exists = unclosed comment
$offset = 0;
while (($pos = strpos($codeNoComments, "*/", $offset)) !== false) {
    $line = substr_count(substr($codeNoComments, 0, $pos), "\n") + 1;
    echo "Error: Stray */ detected at line $line.\n";
    $offset = $pos + 2; // Move past the "*/" to find any additional occurrences
}

// If "*/" still exists = stray closing
$offset = 0;
while (($pos = strpos($codeNoComments, "/*", $offset)) !== false) {
    $line = substr_count(substr($codeNoComments, 0, $pos), "\n") + 1;
    echo "Error: Unclosed /* detected at line $line.\n";
    $offset = $pos + 2;
}

// Write output
$outFileName = pathinfo($fileName, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outFileName, $codeNoComments);

echo "Comments removed where possible. Output written to $outFileName\n";
?>