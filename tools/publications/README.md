## Publications Data

At present, Young Lives maintain an access database of publications with brief title, author and category details. The Young Lives website includes pages for some of these publications. The DFID funded Research for Development platform also provides linked data on some Young Lives supported through DFID funding.

In future, a single source of publications data, tagged according to young lives themes, will be available from the Young Lives website. 

For the time being we have to make some manual efforts to convert data formats.

## Preparation

pubdatabase.csv and r4d.ttl must be in the data/ folder.

pubdatabase.csv should have a single header row.

## Generating the data
The reformat script:

* Takes an extract of data from the Research for Development database (r4d.ttl, supplied) built to contain any papers funded by Young Lives funding, and,
** Checks if there is a matching publication on the website to get a sameAs URL
** Checks if there is a matching publication in the pubdatabase.csv export from Young Lives access database of publications in order to extract relevant themes
* Checks for any entries in the pubdatabase.csv that have not been matched and creates records for these.

