const fs = require('fs');
const args = process.argv.slice(2);

if (args.length !== 1) {
    console.error("The program requires exactly one argument (input file).");
    process.exit(1);
}

const inputFile = args[0];

try {
    // Regex to match every single line comment
    const singleCommentRegex = new RegExp("\\/\\/.*", "g");
    // Regex to match every block comment
    const multiCommentRegex = new RegExp("\\/\\*[\\s\\S]*?\\*\\/", "g")
    
    // Read the file content
    const content = fs.readFileSync(inputFile, 'utf-8');
    
    // Remove valid comments
    let output = content.replace(singleCommentRegex, "").replace(multiCommentRegex, "");

    // Regexes to match invalid comments
    const invalidCommentRegexes = [
        new RegExp("\\/\\*", "g"),
        new RegExp("\\*\\/", "g"),
        new RegExp("\\/[^/*\\w]", "g"),
    ]
    let lines = new Set();
    for (const regex of invalidCommentRegexes) {
        // Match all invalid comments
        const matches = output.matchAll(regex);
        for (const match of matches) {
            // Get line number of each invalid comment
            let lineNumber = output.substring(0, match.index).split("\n").length;
            lines.add(lineNumber);
        }
    }

    // Sort lines and print
    let sortedLines = Array.from(lines).sort((a, b) => a - b);
    for (const line of sortedLines) {
        console.error("Invalid comment found at line: " + line);
    }

    // Write output to file
    fs.writeFileSync("output.c", output);
    console.log("Output file created: output.c");
} catch (err) {
    console.error("Error reading file:", err);
}
