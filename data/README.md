## Initial Data

This folder contains key RDF data files to be loaded into the data.younglives.org.uk triple store.

These are written in N3 syntax, and should be updated to reflect changes in the study structure. 

## Files

### pages.n3

This file contains the pages of content made avaialable on the site.

Note: OntoWiki appears to have a bug that means text that was imported from triple quoted blocks (""") cannot be deleted through OntoWiki. If you are updating page contents and loading into an existing install, you may need to delete the data directly in the underlying Virtuoso database using isql. 

### study.n3

This file contains key annotations about the structure of the study. 

### SelectedStatistics.n3 

This file contains RDF data cubes for key statistics in the Young Lives study. Currently from an import in February 2012. 

## See Also

There are other files that need to go into a full build of the triple store:

/tools/publications/data/full_publications.rdf

/young_lives_themes/data/themes.rdf
/young_lives_themes/data/Additional_themes_methods.rdf

/spss_ddi_rdf/data/rdf/*