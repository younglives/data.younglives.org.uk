<?php
include_once("../../shared_functions/functions.php");
$arrCountry = array("Ethiopia"=>"yls:Ethiopia","Vietnam"=>"yls:Vietnam","India"=>"yls:India","Peru"=>"yls:Peru");
$arrCohort = array("OlderChild"=>"yls:olderCohort","YoungerChild"=>"yls:youngerCohort");

$countries = directory_list("../data/spss/".$argv[1]."/",null);

echo "File,Predicate,Object\n";
echo "*,yls:round,yls:roundThree";

foreach($countries as $country) {
	if(strlen($country) > 2) {
		echo $country;
		$cohorts = directory_list("../data/spss/".$argv[1]."/".$country."/",null);
		foreach($cohorts as $cohort) {
			if(strlen($cohort) > 2) {
				$files = directory_list("../data/spss/".$argv[1]."/".$country."/".$cohort."/",null);
				foreach($files as $filename => $file) {
					if(strlen($file) > 2) {
						$outname = $country."-".$cohort."-".$file;
						copy($filename,"../data/spss/".$outname.".sav");
						echo $outname.",yls:country,".$arrCountry[str_replace("_".$argv[1],"",$country)]."\n";
						echo $outname.",yls:cohort,".$arrCohort[$cohort]."\n";						
						if(strpos($file,"stbl")) {
							echo $outname.",rdf:type,yls:AdditionalVariable\n";						
						} else {
							echo $outname.",rdf:type,yls:Question\n";													
						}
					}
				}
			}
		}
		
	}
}


