<?php

// Read input from user
echo "Enter input filename: ";
$filename = trim(fgets(STDIN));

// Check if file exists
if (!file_exists($filename)) {
    echo "Error: File not found.\n";
    exit(1);
}

// Read file contents
$code = file_get_contents($filename);

// Remove single-line comments
$code_no_line_comments = preg_replace('#//.*#', '', $code);

// Check block comment counts
$open_count = substr_count($code_no_line_comments, "/*");
$close_count = substr_count($code_no_line_comments, "*/");

if ($open_count != $close_count) {
    echo "Error: Invalid block comment detected.\n";
}

// Remove block comments
$code_clean = preg_replace('#/\*[\s\S]*?\*/#', '', $code_no_line_comments);

// Write output
$outname = pathinfo($filename, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outname, $code_clean);

echo "Comments removed. Output written to $outname\n";
?>