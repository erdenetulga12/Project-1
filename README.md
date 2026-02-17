# Regular expression using Javascript and PhP

This folder contains two programs, called "project1.js" and "project1.php", that use
regular expressions to find invalid comments in a C file.

The programs follow these requirements:

1. can remove the valid comments in the C program.
2. can find the invalid comments and print out an error message.

## Compilation and Execution

The programs require one command-line argument: the input file.

To run the Javascript program, navigate to the project directory and run:

```bash
node project1.js detect_cycle.c
```

To run the PHP program, navigate to the project directory and run:

```bash
php project1.php detect_cycle.c
```

Make sure to have Node.js and PHP installed on your system.

### Output

The program will print out the line numbers of any invalid comments found in the
input file.

```bash
Invalid comment found at line: 19
Invalid comment found at line: 58
Invalid comment found at line: 165
Output file created: output.c
```

The program will also create an output file (output.c) with the valid comments removed.
