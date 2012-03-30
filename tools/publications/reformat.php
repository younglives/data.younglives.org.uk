<?php 

//To Do - add document type when we can find this from the CSV...

ini_set("auto_detect_line_endings",TRUE);
## API Key for Yahoo Tax Extraction
define("API_KEY","eCZxrlvV34Ef1rh5V9OFfErlqpLT88.rgRdbwRfx2owZPFKECFX0p3Mfp1yOJjHiww--");

## General set up
include_once("../shared_functions/simple_html_dom.php");
include_once("../shared_functions/functions.php");
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
define("RDFAPI_INCLUDE_DIR",dirname(__FILE__)."/../rap/api/");
include_once(RDFAPI_INCLUDE_DIR."RdfAPI.php");
$model = ModelFactory::getDefaultModel();
include_once("../shared_functions/models.php");
define("YLCONCEPT","http://data.younglives.org.uk/data/concepts/");
define("YLTHEMES","http://data.younglives.org.uk/data/themes/");


## Useful Variables
$csv_codes = array("CR" => "Country Report", "J" => "Journal Article", "PB" => "Policy brief", "PP"=> "Policy Paper", "SP" => "Student paper", "TN" => "Technical note", "WP" => "Working paper"); # Codes used in the CSV export from the Acecss research database. 

//This converts the names used in the CSV database to those taken from the website
$theme_shortnames = array("Dynamics" => "DynamicsOfChildhoodPoverty","Children's experiences" => "ChildrensExperiencesOfPoverty", "Learning/time-use/transitions" => "Schooling-Time-useAndLifeTransitions", "cross-cutting"=>"Cross-cuttingAnalysis");


// Cut down the title to a single string we can compare
function token_title($string) {
	$string = str_replace(array(":","-"," ","?",".","\n",'"',"#",","),"",strtolower($string));
//	$string = preg_replace("/&#?[a-z0-9]{2,8};/i","",$string);
	
	if(strpos($string,"\n")) {
		$string = substr($string,0,strpos($string,"\n")); 
	}
	$string = strtolower(preg_replace("/[\W]*/i","",$string));
	return $string;
}

function fetch_yl_pubs() { 
	$publications = file_get_html('http://www.younglives.org.uk/search?advanced_search=True&SearchableText=&Subject_usage%3Aignore_empty=operator%3Aand&theme_usage%3Aignore_empty=operator%3Aand&topic_usage%3Aignore_empty=operator%3Aand&portal_type%3Alist=Publication&sort_on=&b_size%3Aint=500&submit=Search');

	foreach($publications->find(".contenttype-publication a") as $publication) {
		$pubTitle = token_title((string)$publication->plaintext);
		$publication_list[$pubTitle] = (string)$publication->href;
	}
	
	return $publication_list;
}

function fetch_csv_pubs(){
	$file = fopen("data/pubdatabase.csv","r");

	$keys = fgetcsv($file);
	
	while(!feof($file))
	  {
	  	$row = fgetcsv($file);
		$return[token_title($row[3])] = array_combine($keys,$row);
	  }
	fclose($file);
	
	return $return;
}

function extract_terms($string) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://search.yahooapis.com/ContentAnalysisService/V1/termExtraction");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, true);

	$data = array(
	    'appid' => API_KEY,
		'output' => 'json',
	    'context' => $string);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);

	return json_decode($output);
}

//Run the code
$younglives_website_pubs = fetch_yl_pubs();
$younglives_database_pubs = fetch_csv_pubs();


$model->load("data/r4d.ttl");
$data = $model->rdqlQuery("SELECT ?resource, ?description, ?title WHERE (?resource, <http://purl.org/dc/elements/1.1/description>, ?description), (?resource, <http://purl.org/dc/elements/1.1/title>, ?title )");

$SKOSres = New Resource(YLCONCEPT."conceptScheme");
$model->add(New Statement($SKOSres,$RDF_type,$SKOS_ConceptScheme));
$model->add(New Statement($SKOSres,$RDFS_label,new Literal("Unstructured concepts extracted from document")));


foreach($data as $publication) {
	$model->add(New Statement($publication['?resource'],$DC_type,New Resource("http://purl.org/dc/dcmitype/Text")));

	$dcpubtoken = token_title($publication['?title']->label);
	$log[$dcpubtoken] = "R4D";
	echo $dcpubtoken . " - ". $publication['?title']->label. "\n";
	foreach($younglives_website_pubs as $pubkey => $puburi) {
		if(strpos($dcpubtoken,$pubkey)) {
			$model->add(New Statement($publication['?resource'],$OWL_sameAs,New Resource($puburi)));
			echo "Same as ".$puburi."\n";
			$log[$dcpubtoken] .= ";WEBSITE";
		}
	}
	foreach($younglives_database_pubs as $pubkey => $data) {
		if(strpos($dcpubtoken,$pubkey)) {
			echo "Found matching entry in database: ".$publication['?title']->label ." is ".$data['Title']."\n\n";
			$log[$dcpubtoken] .= ";PUBS_CSV";
			//TO DO - Now use the data we have to assign this to an appropriate Young Lives category
			if($data['Website sub-theme']) {
				//We're attaching to one or more subthemes
				if(strpos($data['Website sub-theme'],";")) { $themes = explode($data['Website sub-theme'],";"); } else { $themes = array($data['Website sub-theme']);}
				foreach($themes as $theme) {
					$termRes = New Resource(YLTHEMES.format_var_string($theme));
					$model->add(New Statement($publication['?resource'],$DC_subject,$termRes));
					echo "Adding official theme . $theme\n";
				}
			} else {
				//We're not hanging anything direct just yet
			}
			unset($younglives_database_pubs[$pubkey]);
		}
	}
	
	$terms = extract_terms($publication['?description']->label);
	echo "Associating terms: ";
	foreach($terms->ResultSet->Result as $term) {
		if(strlen($term) > 3) {
			$termRes = New Resource(YLCONCEPT.format_var_string($term));
			$model->add(New Statement($publication['?resource'],$DC_subject,$termRes));
			$model->addWithoutDuplicates(New Statement($termRes,$RDF_type,$SKOS_Concept));
			$model->addWithoutDuplicates(New Statement($termRes,$SKOS_inScheme,$SKOSres));
			$model->addWithoutDuplicates(New Statement($termRes,$SKOS_prefLabel,new Literal($term)));
			echo $term .";";
		}
	}
	echo "\n\n";
}


foreach($younglives_database_pubs as $pubkey => $data) {
	$log[$pubkey] = "CSV_INITIAL";

	$resource = New Resource("http://data.younglives.org.uk/publications/".$pubkey);
	$model->add(New Statement($resource,$DC_type,New Resource("http://purl.org/dc/dcmitype/Text")));
	$model->add(New Statement($resource,$DC_title,New Literal($data['Title'])));
	$model->add(New Statement($resource,$DC_creator,New Literal($data['Authors'])));
	$model->add(New Statement($resource,$DC_date,New Literal($data['Date'])));

	if($data['Website sub-theme']) {
		//We're attaching to one or more subthemes
		if(strpos($data['Website sub-theme'],";")) { $themes = explode($data['Website sub-theme'],";"); } else { $themes = array($data['Website sub-theme']);}
		foreach($themes as $theme) {
			$termRes = New Resource(YLTHEMES.format_var_string($theme));
			$model->add(New Statement($publication['?resource'],$DC_subject,$termRes));
			echo "Adding official theme . $theme\n";
		}
	} else {
		//We're not hanging anything direct just yet
	}

	foreach($younglives_website_pubs as $webpubkey => $puburi) {
		if(strpos($pubkey,$webpubkey)) {
			$model->add(New Statement($resource,$OWL_sameAs,New Resource($puburi)));
			echo "Same as ".$puburi."\n";
			$log[$pubkey] .= ";WEBSITE";
		}
	}

}

print count($younglives_database_pubs);

//$model->writeAsHtml();
$model->saveAs("data/full_publications.rdf");

