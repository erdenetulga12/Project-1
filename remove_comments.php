<?php

//Read input from user
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

// Write output
$fileName = pathinfo($fileName, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($fileName, $codeNoComments);

echo "Comments removed. Output written to $fileName\n";

?>