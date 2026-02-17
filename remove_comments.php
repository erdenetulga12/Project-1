<?php
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
    exit(1);
}

// Read file contents
$code = file_get_contents($filename);

// Remove line comments first (//), then block comments (/* */)
$codeNoLineComments = preg_replace('#//.*#', '', $code);

// Remove block comments
$codeNoProperComments = preg_replace('#/\*[\s\S]*?\*/#', '', $codeNoLineComments);

// Output
$outName = pathinfo($filename, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outName, $codeNoProperComments);

echo "Comments removed. Output written to $outName\n";
?>