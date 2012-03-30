## About

The SPSS_Data_Cube scripts are designed to read SPSS files and generate summary statistics as a datacube for all the variables in the dataset. 

The following rscripts, run with a folder of SPSS files as the working directory, should generate a series of CSV files organised into folders relating to the relevant SPSS file. 

```r
library("foreign")

files<-dir(".",".sav")
for(f in 1:length(files)) {  
   folder<-sub(".sav","",files[f])
   
   data<-read.spss(files[f])
   vars<-names(data)
   
   dir.create(paste("output/",folder,sep=""))
   print(paste("Processing ",folder))
   
    for(i in 1:length(vars)) {
        print(vars[i])       write.csv(data.frame(names=names(table(data[i])),freq=as.vector(table(data[i])),proportion=as.vector(prop.table(table(data[i])))),paste("output/",folder,"/",vars[i],sep="")) 

    }
           
}
```

## Process

With the CSV files generated we should be able to

* Generate a dataset and data structure definition (addWithoutDuplicates)
* Record an observation with dimensions for:
** Variable (the MeasureProperty)
** Cohort
** Country
** Round 

Later on we can check for variables which share the same codeList and we can then assert a seeAlso (or similar) relationship between their datasets to highlight that they can be compared / represented together. 

## Notes
