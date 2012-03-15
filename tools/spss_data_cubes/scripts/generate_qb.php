<?php
//ARGH. Need to re-model.
//DSD should include dimension property for variable - and measureProperty is a count!


/**
 * @author Tim Davies (tim@practicalparticipation.co.uk)
 * @version 0.2
 *
 * Usage, call at the command line: php generate_qb.php [context file] [config file] [codelist file]
 * Give relative or absolute paths for each argument. Arguments must be passed in order
 * If you want to omit and argument and use the defaults, enter 'default' for that argument.
 * 
 */
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

//Defaults
$defaultCountry = "unknown";
$defaultRound = "Round3";
$defaultCohort = "unknown";

//Includes
define("RDFAPI_INCLUDE_DIR",dirname(__FILE__)."/../../rap/api/");
include_once(RDFAPI_INCLUDE_DIR."RdfAPI.php");
include_once("../../shared_functions/functions.php");
ini_set('memory_limit', '1024M');
global $category_cache;

//We need to load our context, config and then fetch our existing store of code-list values. 
$context = load_context((!($argv[1] == "default")) ? $argv[1] : null);

$ns = load_config((!($argv[2] == "default")) ? $argv[2] : null);

//Check for our required namespaces
if(!$ns['*']) { log_message("Please make sure config.csv includes a default namespace (*) to be used in generating provenance information (etc.)",1);}
if(!$ns['studymeta']) { log_message("Please make sure config.csv includes a namespace for 'studymeta' to hold study meta-data",1);}
if(!$ns['var']) { log_message("Please make sure config.csv includes a namespace for 'var' to profile a prefix for variables",1);}
if(!$ns['stats']) { log_message("Please make sure config.csv includes a namespace for 'stats' to profile a prefix for statistics",1);}
$prefix_stats = $ns['stats'];
$code_prefix = $ns['*']."code-";


/*
//Load code lists
$vardef = ModelFactory::getDefaultModel();
$vardeffile = !($argv[3] == "default") ? $argv[3] : null;
if(file_exists("../../spss_ddi_rdf/data/rdf/all.rdf")) { 
	log_message("Loading variable definitions");
	$vardef->load("../../spss_ddi_rdf//data/rdf/all.rdf");
	log_message("Found an existing variable definition file to work from",0);
} else {
	log_message("WARNING: No variable definition file found. ");
}
*/


$model = ModelFactory::getDefaultModel();
include("../../shared_functions/models.php");

$folders = directory_list("../data/csv/",false);


//Temporary limit
$folders = array_slice($folders,0,6);


foreach($folders as $folder => $folderName) {
	
	if(strlen($folderName) > 2) {
		echo "\n\nProcessing $folderName\n\n";

		$model = ModelFactory::getDefaultModel();
		include("../../shared_functions/models.php");
		
		//Set up the dimensions for this file. ()
		$thisCountry = new Resource($ns['*'].$defaultCountry);
		$thisRound = new Resource($ns['*'].$defaultRound);
		$thisCohort = new Resource($ns['*'].$defaultCohort);
		
		foreach($context[$folderName] as $properties) {
			switch($properties['p']) {
				case "yls:country":
					$thisCountry = resource_or_literal($properties['o'],$ns);
				break;
				case "yls:cohort":
					$thisCohort = resource_or_literal($properties['o'],$ns);
				break;
				case "yls:round": 
					$thisRound = resource_or_literal($properties['o'],$ns);
				break;
			}
		}

		//Now find all the variables to look through 
		$files = directory_list("../data/csv/".$folderName."/",false);

		foreach($files as $file => $fileName) {
			if(strlen($fileName) > 2 ) {
				echo "\n Processing: $fileName "; $n=1;
				

					
					$dsd = setUpDSD($fileName,$ns,&$model);	
			
					if(strlen($fileName) > 2) {
						$row = 1;
					
						if (($handle = fopen("../data/csv/".$folderName."/".$fileName, "r")) !== FALSE) {
							$data = fgetcsv($handle, 1000, ","); //Skip first header line...
						    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
									echo $n++. ", ";
								//Record an observation attached to the given dataset and using $data[1] and $data[2]
									$observation = new Resource($prefix_stats."stats-$fileName-".uniqid()); //Note: Improve this ID 
									$model->add(new Statement($observation,$RDF_type,$QB_Observation));
									$model->add(new Statement($observation,$QB_dataSet,$dsd['dataset']));
									$model->add(new Statement($observation,$RDFS_label,new Literal("Frequency of {$fileName}")));
									$model->add(new Statement($observation,$dsd['country'],$thisCountry)); 
									$model->add(new Statement($observation,$dsd['round'],$thisRound));
									$model->add(new Statement($observation,$dsd['cohort'],$thisCohort));
									$model->add(new Statement($observation,$dsd['variable'], new Resource($code_prefix.format_var_string($data[1]))));
								
									$count = new Literal($data['2']); 
									$count->setDatatype("http://www.w3.org/2001/XMLSchema#decimal");
									$model->add(new Statement($observation,$QB_measureType,$dsd['frequency']));
									$model->add(new Statement($observation,$dsd['frequency'],$count));
									
										//Record an observation attached to the given dataset and using $data[1] and $data[2]
										$observation = new Resource($prefix_stats."stats-$fileName-".uniqid()); //Note: Improve this ID 
										$model->add(new Statement($observation,$RDF_type,$QB_Observation));
										$model->add(new Statement($observation,$QB_dataSet,$dsd['dataset']));
										$model->add(new Statement($observation,$RDFS_label,new Literal("Frequency of {$fileName}")));
										$model->add(new Statement($observation,$dsd['country'],$thisCountry)); 
										$model->add(new Statement($observation,$dsd['round'],$thisRound));
										$model->add(new Statement($observation,$dsd['cohort'],$thisCohort));
										$model->add(new Statement($observation,$dsd['variable'], new Resource($code_prefix.format_var_string($data[1]))));

										$count = new Literal($data['3']); 
										$count->setDatatype("http://www.w3.org/2001/XMLSchema#float");
										$model->add(new Statement($observation,$QB_measureType,$dsd['proportion']));
										$model->add(new Statement($observation,$dsd['proportion'],$count));
						    }
						    fclose($handle);
						}
					}
				}
		}
		
		log_message("Writing to file");
		$model->saveAs("../data/rdf/$folderName.n3","n3");
	}
}

log_message("Writing to file");
$model->saveAs("../data/rdf/output.n3", "n3");


function setUpDSD($varname,$ns,&$model) {
	include("../../shared_functions/models.php");
	$prefix_vars = $ns['var'];
	$prefix_structure = $ns['*'];
	//Establish the measure
	
	//And create the dimensions we'll need later
	$country = new Resource($prefix_structure."country");
	$round = new Resource($prefix_structure."round");
	$cohort = new Resource($prefix_structure."cohort");	
	$variable = new Resource($prefix_vars.$varname);
	$frequency = new Resource($prefix_vars."frequency");
	$proportion = new Resource($prefix_vars."proportion");


	//Establish the data structure definition & the components
	$dsd = new Resource($prefix_vars."dsd-".$varname);
	$model->add(new Statement($dsd,$RDF_type,$QB_DataStructureDefinition));

	$componentCountry = new Resource($prefix_structure."component-country");
	$model->addWithoutDuplicates(new Statement($componentCountry,$QB_dimension,$country));
	$model->addWithoutDuplicates(new Statement($componentCountry,$QB_order,new Literal(1)));
	$model->add(new Statement($dsd,$QB_component,$componentCountry));

	$componentRound = new Resource($prefix_structure."component-round");
	$model->addWithoutDuplicates(new Statement($componentRound,$QB_dimension,$round));
	$model->addWithoutDuplicates(new Statement($componentRound,$QB_order,new Literal(2)));
	$model->add(new Statement($dsd,$QB_component,$componentRound));

	$componentCohort = new Resource($prefix_structure."component-cohort");
	$model->addWithoutDuplicates(new Statement($componentCohort ,$QB_dimension,$cohort));
	$model->addWithoutDuplicates(new Statement($componentCohort ,$QB_order,new Literal(3)));
	$model->add(new Statement($dsd,$QB_component,$componentCohort));

	$componentVariable = new Resource($prefix_structure."component-".$varname);
	$model->addWithoutDuplicates(new Statement($componentVariable,$QB_dimension,$variable));
	$model->addWithoutDuplicates(new Statement($componentVariable ,$QB_order,new Literal(4)));
	$model->add(new Statement($dsd,$QB_component,$componentVariable));
	
	$componentMeasureType = new Resource($prefix_structure."component-measureType");
	$model->addWithoutDuplicates(new Statement($componentMeasureType,$QB_dimension,$QB_measureType));
	$model->addWithoutDuplicates(new Statement($componentVariable ,$QB_order,new Literal(5)));
	$model->add(new Statement($dsd,$QB_component,$componentMeasureType));
	
	$componentFrequency = new Resource($prefix_structure."component-frequency");
	$model->addWithoutDuplicates(new Statement($componentFrequency,$QB_measure,$frequency));
	$model->add(new Statement($dsd,$QB_component,$componentFrequency));
	
	$componentProportion = new Resource($prefix_structure."component-proportion");
	$model->addWithoutDuplicates(new Statement($componentProportion,$QB_measure,$proportion));
	$model->add(new Statement($dsd,$QB_component,$componentProportion));
	

	//Now set up the dataset and link to it.
	$dataset = new Resource($prefix_structure."dataset-".$varname);
	$model->add(new Statement($dataset,$RDF_type,$QB_DataSet));
	$model->add(new Statement($dataset,$QB_structure,$dsd));

	return array('dataset'=>$dataset,'country'=>$country,'round'=>$round,'cohort'=>$cohort, 'variable'=>$variable,'frequency'=>$frequency,'proportion'=>$proportion);
}



/*Offcuts
//We check to see what type of variable this is. 
echo "Searching for Type\n";
$rdql_query = "SELECT ?type WHERE\n (<".$ns['var'].$fileName."> studymeta:variableRepresentation ?type )  USING studymeta FOR <".$ns['studymeta'].">";
$rdqlIter = $vardef->rdqlQueryasIterator($rdql_query);

if($rdqlIter->countResults()) {
	$result = $rdqlIter->next();
	$type = (string)$result["?type"];
}

if(!strpos($type,"NumericRepresentation")) {
*/


