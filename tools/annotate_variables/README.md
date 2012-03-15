## Annotate Variables

The variable annotation code should:

* Take a file with variables listed within it;
* Support the addition of extra triples to those variables (e.g. question groups etc.)

## Syntax

Add ">VARNAME <predicate> <object>."

to any line of a file which contains variable names either in the form 'variable = varname'

to any line of a file which contains variable names either in the form 'variable = varname' or VARNAME123 at the start of the line.

It also handles VARNAME001 to VARNAME020 (expanding out all the numerical variables in-between), and VARNAME123, VARNAME124, VARNAME125 comma separated on a single line. 

All the variable names following the >PROPNAME <predicate> <object>. command will be used as the subject of a triple ending with <predicate> <object>. 
	
To stop a particular set of triples being applied, use >PROPNAME; or set >PROPNAME to some new <predicate> and <object> values. 

### Helper Scripts
The word-mac-scripts.txt file gives an example of mac script for MS Word on Mac for search and replace over heading lines in a file.

(Note, these scripts are very blunt and output should be checked. Often text in a string will be replaced, however, as the script only looks for > values at the start of a line and is only concerned with variable names we can ignore this.)

These scripts were originally written using URIs that are now depreciated. The script 'sed-modify-URIs' uses sed to replace outdated URIS.

Run this in the input directory with:

../../scripts/sed-modify-URIs 

To ensure sub-sections do not overide other sections you can then use:

sed -i '' -f ../../scripts/sed-add-subsection-breaks *.txt


### ToDo

* Re-mark-up files with '>LEVEL <yls:roundThreeDataLevel> <yls:childLevel>.' or '>LEVEL <yls:roundThreeDataLevel> <yls:householdLevel>.'

* Re-mark-up sections at child level that repeat sections from the Household Level / add correct section headings. 

