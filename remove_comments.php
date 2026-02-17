<?php

// Read input from user
echo "Enter input filename: ";
$filename = trim(fgets(STDIN));

// Check file exists
if (!file_exists($filename)) {
    echo "Error: File not found.\n";
    exit(1);
}

// Read file contents
$code = file_get_contents($filename);

// Block comment check
$open_count = substr_count($code, "/*");
$close_count = substr_count($code, "*/");

if ($open_count != $close_count) {
    echo "Error: Invalid block comment detected.\n";
}

// Remove block comments
$code = preg_replace('#/\*[\s\S]*?\*/#', '', $code);

// Remove single-line comments
$code = preg_replace('#//.*#', '', $code);

// Write output file
$outname = pathinfo($filename, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outname, $code);

echo "Comments removed. Output written to $outname\n";
?>