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

?>