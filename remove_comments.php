<?php
// remove_comments.php
// Usage: php remove_comments.php
// The script will prompt for an input filename and attempt to remove comments.
// It detects unclosed block comments (/* without */) and stray */.

// Function to read a line from standard input with an optional prompt
function read_stdin($prompt="") {
    if ($prompt) echo $prompt;
    $line = trim(fgets(STDIN));
    return $line;
}

// Main execution
$filename = read_stdin("Enter input filename: ");
if (!file_exists($filename)) {
    fwrite(STDERR, "Error: file '$filename' not found.\n");
    exit(1);
}

// Read the entire file content
$code = file_get_contents($filename);

// Block comment token count
$open_count = substr_count($code, "/*");
$close_count = substr_count($code, "*/");
$errors = [];
// Check for unclosed block comments and stray closing tokens
if ($open_count > $close_count) {
    $errors[] = "Error: Unclosed /* comment (found $open_count '/*' but only $close_count '*/').";
}
if ($close_count > $open_count) {
    $errors[] = "Error: Stray */ found without matching /* (found $close_count '*/' but only $open_count '/*').";
}
// Attempt to find precise line numbers for first unmatched token
if (!empty($errors)) {
    // locate first unmatched '/*' without a following '*/'
    $pos = strpos($code, "/*"); 
    if ($pos !== false) {
        $after = substr($code, $pos);
        if (strpos($after, "*/") === false) {
            $line = substr_count(substr($code, 0, $pos), "\n") + 1;
            $errors[] = "First unclosed /* starts at line $line.";
        }
    }
    // locate first stray '*/' without preceding '/*'
    $pos2 = strpos($code, "*/");
    if ($pos2 !== false) {
        $before = substr($code, 0, $pos2);
        if (strrpos($before, "/*") === false) {
            $line2 = substr_count($before, "\n") + 1;
            $errors[] = "First stray */ at line $line2.";
        }
    }
}

// If errors found, print and continue with partial removal
if (!empty($errors)) {
    foreach ($errors as $e) {
        echo $e . PHP_EOL;
    }
    echo "Attempting partial removal of comments where possible...\n";
}

// Remove block comments and line comments
$without_block = preg_replace('#/\*[\s\S]*?\*/#', '', $code);
$without_line = preg_replace('#//.*#', '', $without_block);

// Output to file: original_filename_no_comments.c
$outname = pathinfo($filename, PATHINFO_FILENAME) . "_no_comments.c";
file_put_contents($outname, $without_line);

echo "Comments removed. Output written to $outname\n";
?>