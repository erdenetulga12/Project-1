<?php
<<<<<<< HEAD
// remove_comments.php
// Usage: php remove_comments.php

// Read user input from command line
function read_stdin($prompt="") {
    if ($prompt) echo $prompt;
    return trim(fgets(STDIN));
}

// Get filename from user and check if it exists
$filename = read_stdin("Enter input filename: ");
if (!file_exists($filename)) {
    fwrite(STDERR, "Error: file '$filename' not found.\n");
=======

// Read input from user
echo "Enter input filename: ";
$fileName = trim(fgets(STDIN));

// Check if file exists
if (!file_exists($fileName)) {
    echo "Error: File not found.\n";
>>>>>>> f1e45dd9fb48611dba3b2d6f1e5785087f6d2302
    exit(1);
}

// Read file contents
<<<<<<< HEAD
$code = file_get_contents($filename);

// Remove line comments first (//), then block comments (/* */)
$codeNoLineComments = preg_replace('#//.*#', '', $code);

// Remove block comments
$codeNoProperComments = preg_replace('#/\*[\s\S]*?\*/#', '', $codeNoLineComments);

// Output
$outName = pathinfo($filename, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outName, $codeNoProperComments);

echo "Comments removed. Output written to $outName\n";
=======
$code = file_get_contents($fileName);

// Remove single-line comments
$codeNoLineComments = preg_replace('#//.*#', '', $code);

// Check block comment counts
$openCount = substr_count($codeNoLineComments, "/*");
$closeCount = substr_count($codeNoLineComments, "*/");

if ($openCount != $closeCount) {
    echo "Error: Invalid block comment detected.\n";
}

// Remove block comments
$codeClean = preg_replace('#/\*[\s\S]*?\*/#', '', $codeNoLineComments);

// Write output
$outName = pathinfo($fileName, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outName, $codeClean);

echo "Comments removed. Output written to $outName\n";

>>>>>>> f1e45dd9fb48611dba3b2d6f1e5785087f6d2302
?>