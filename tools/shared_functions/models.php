<?php

//Set up Data Cube
$QB_prefix = "http://purl.org/linked-data/cube#";
$QB_MeasureProperty = new Resource($QB_prefix."MeasureProperty");
$QB_AttributeProperty = new Resource($QB_prefix."AttributeProperty");
$QB_DimensionProperty = new Resource($QB_prefix."DimensionProperty");
$QB_ComponentProperty = new Resource($QB_prefix."ComponentProperty");
$QB_DataStructureDefinition = new Resource($QB_prefix."DataStructureDefinition");
$QB_codeList = new Resource($QB_prefix."codeList");
$QB_structure = new Resource($QB_prefix."structure");
$QB_dimension = new Resource($QB_prefix."dimension");
$QB_order = new Resource($QB_prefix."order");
$QB_component = new Resource($QB_prefix."component");
$QB_measure = new Resource($QB_prefix."measure");
$QB_DataSet = new Resource($QB_prefix."DataSet"); //The class
$QB_dataSet = new Resource($QB_prefix."dataSet"); //The property
$QB_Observation = new Resource($QB_prefix."Observation");
$QB_measureType = new Resource($QB_prefix."measureType");

//qb:Attachable qb:AttributeProperty qb:CodedProperty qb:ComponentProperty qb:ComponentSet qb:ComponentSpecification qb:DataSet qb:DataStructureDefinition qb:DimensionProperty qb:MeasureProperty qb:Observation qb:Slice qb:SliceKey
// qb:attribute qb:codeList qb:component qb:componentAttachment qb:componentProperty qb:componentRequired qb:concept qb:dataSet qb:dimension qb:measure qb:measureDimension qb:measureType   qb:observation qb:order qb:slice qb:sliceKey qb:sliceStructure qb:structure qb:subSlice

//Set up SDMX
$SDMX_prefix = "http://purl.org/linked-data/sdmx#";
$SDMX_obsValue = new Resource($SDMX_prefix."obsValue");

//SDMX Dimensions
$SDMX_dimension_prefix = "http://purl.org/linked-data/sdmx/2009/dimension#";
$SDMX_dimension_sex = new Resource($SDMX_dimension_prefix."sex");

//SDMX Codes
$SDMX_code_prefix = "http://purl.org/linked-data/sdmx/2009/code#";
$SDMX_code['Male'] = new Resource($SDMX_code_prefix."sex-M");
$SDMX_code['Female'] = new Resource($SDMX_code_prefix."sex-F");
$SDMX_code['Both'] = new Resource($SDMX_code_prefix."NA");

//SDMX Measures
$SDMX_measure_prefix = "http://purl.org/linked-data/sdmx/2009/measure#";


//Set up SKOS
$SKOS_prefix = "http://www.w3.org/2004/02/skos/core#";
$SKOS_ConceptScheme = new Resource($SKOS_prefix."ConceptScheme");
$SKOS_Concept = new Resource($SKOS_prefix."Concept");
$SKOS_inScheme = new Resource($SKOS_prefix."inScheme");
$SKOS_prefLabel = new Resource($SKOS_prefix."prefLabel");
$SKOS_topConceptOf = new Resource($SKOS_prefix."topConceptOf");
$SKOS_hasTopConcept = new Resource($SKOS_prefix."hasTopConcept");
$SKOS_notation = new Resource($SKOS_prefix."notation");
$SKOS_broader = new Resource($SKOS_prefix."broader");
$SKOS_narrower = new Resource($SKOS_prefix."narrower");

//Set up SCOVO
$SKOVO_prefix = "http://purl.org/NET/scovo#";
$SKOVO_Dataset = new Resource($SKOVO_prefix."Dataset");
$SKOVO_Dimension = new Resource($SKOVO_prefix."Dimension");
$SKOVO_Item = new Resource($SKOVO_prefix."Item");
$SKOVO_dataset = new Resource($SKOVO_prefix."dataset");
$SKOVO_datasetOf = new Resource($SKOVO_prefix."datasetOf");
$SKOVO_dimension = new Resource($SKOVO_prefix."dimension");
$SKOVO_max = new Resource($SKOVO_prefix."max");
$SKOVO_min = new Resource($SKOVO_prefix."min");


//Set up XSD
$XSD_prefix = "http://www.w3.org/TR/xmlschema-2/";


//Set up Ontologies
$GEO_prefix = "http://ontologi.es/place/";


// RDFS concepts
$RDFS_prefix = "http://www.w3.org/2000/01/rdf-schema#";
$RDFS_Resource = new Resource($RDFS_prefix . 'Resource');
$RDFS_Literal = new Resource($RDFS_prefix . 'Literal');
$RDFS_Class = new Resource($RDFS_prefix . 'Class');
$RDFS_Datatype = new Resource($RDFS_prefix . 'Datatype');
$RDFS_Container = new Resource($RDFS_prefix . 'Container');
$RDFS_ContainerMembershipProperty = new Resource($RDFS_prefix . 'ContainerMembershipProperty');
$RDFS_subClassOf = new Resource($RDFS_prefix . 'subClassOf');
$RDFS_subPropertyOf = new Resource($RDFS_prefix . 'subPropertyOf');
$RDFS_domain = new Resource($RDFS_prefix . 'domain');
$RDFS_range = new Resource($RDFS_prefix . 'range');
$RDFS_label = new Resource($RDFS_prefix . 'label');
$RDFS_comment = new Resource($RDFS_prefix . 'comment');
$RDFS_member = new Resource($RDFS_prefix . 'member');
$RDFS_seeAlso = new Resource($RDFS_prefix . 'seeAlso');
$RDFS_isDefinedBy = new Resource($RDFS_prefix . 'isDefinedBy');

//RDF 
// RDF concepts (constants are defined in constants.php)
$RDF_Alt = new Resource(RDF_NAMESPACE_URI . RDF_ALT);
$RDF_Bag = new Resource(RDF_NAMESPACE_URI . RDF_BAG);
$RDF_Property = new Resource(RDF_NAMESPACE_URI . RDF_PROPERTY);
$RDF_Seq = new Resource(RDF_NAMESPACE_URI . RDF_SEQ);
$RDF_Statement = new Resource(RDF_NAMESPACE_URI . RDF_STATEMENT);
$RDF_List = new Resource(RDF_NAMESPACE_URI . RDF_LIST);
$RDF_nil = new Resource(RDF_NAMESPACE_URI . RDF_NIL);
$RDF_type = new Resource(RDF_NAMESPACE_URI . RDF_TYPE);
$RDF_rest = new Resource(RDF_NAMESPACE_URI . RDF_REST);
$RDF_first = new Resource(RDF_NAMESPACE_URI . RDF_FIRST);
$RDF_subject = new Resource(RDF_NAMESPACE_URI . RDF_SUBJECT);
$RDF_predicate = new Resource(RDF_NAMESPACE_URI . RDF_PREDICATE);
$RDF_object = new Resource(RDF_NAMESPACE_URI . RDF_OBJECT);
$RDF_Description = new Resource(RDF_NAMESPACE_URI . RDF_DESCRIPTION);
$RDF_ID = new Resource(RDF_NAMESPACE_URI . RDF_ID);
$RDF_about = new Resource(RDF_NAMESPACE_URI . RDF_ABOUT);
$RDF_aboutEach = new Resource(RDF_NAMESPACE_URI . RDF_ABOUT_EACH);
$RDF_aboutEachPrefix = new Resource(RDF_NAMESPACE_URI . RDF_ABOUT_EACH_PREFIX);
$RDF_bagID = new Resource(RDF_NAMESPACE_URI . RDF_BAG_ID);
$RDF_resource = new Resource(RDF_NAMESPACE_URI . RDF_RESOURCE);
$RDF_parseType = new Resource(RDF_NAMESPACE_URI . RDF_PARSE_TYPE);
$RDF_Literal = new Resource(RDF_NAMESPACE_URI . RDF_PARSE_TYPE_LITERAL);
$RDF_Resource = new Resource(RDF_NAMESPACE_URI . RDF_PARSE_TYPE_RESOURCE);
$RDF_li = new Resource(RDF_NAMESPACE_URI . RDF_LI);
$RDF_nodeID = new Resource(RDF_NAMESPACE_URI . RDF_NODEID);
$RDF_datatype = new Resource(RDF_NAMESPACE_URI . RDF_DATATYPE);
$RDF_seeAlso = new Resource(RDF_NAMESPACE_URI . RDF_SEEALSO);




// OWL concepts
$OWL_AnnotationProperty = new Resource(OWL_NS . 'AnnotationProperty');
$OWL_AllDifferent = new Resource(OWL_NS . 'AllDifferent');
$OWL_allValuesFrom = new Resource(OWL_NS . 'allValuesFrom');
$OWL_backwardCompatibleWith = new Resource(OWL_NS . 'backwardCompatibleWith');
$OWL_cardinality = new Resource(OWL_NS . 'cardinality');
$OWL_Class = new Resource(OWL_NS . 'Class');
$OWL_complementOf = new Resource(OWL_NS . 'complementOf');
$OWL_Datatype = new Resource(OWL_NS . 'Datatype');
$OWL_DatatypeProperty = new Resource(OWL_NS . 'DatatypeProperty');
$OWL_DataRange = new Resource(OWL_NS . 'DataRange');
$OWL_DatatypeRestriction = new Resource(OWL_NS . 'DatatypeRestriction');
$OWL_DeprecatedClass = new Resource(OWL_NS . 'DeprecatedClass');
$OWL_DeprecatedProperty = new Resource(OWL_NS . 'DeprecatedProperty');
$OWL_distinctMembers = new Resource(OWL_NS . 'distinctMembers');
$OWL_differentFrom = new Resource(OWL_NS . 'differentFrom');
$OWL_disjointWith = new Resource(OWL_NS . 'disjointWith');
$OWL_equivalentClass = new Resource(OWL_NS . 'equivalentClass');
$OWL_equivalentProperty = new Resource(OWL_NS . 'equivalentProperty');
$OWL_FunctionalProperty = new Resource(OWL_NS . 'FunctionalProperty');
$OWL_hasValue = new Resource(OWL_NS . 'hasValue');
$OWL_incompatibleWith = new Resource(OWL_NS . 'incompatibleWith');
$OWL_imports = new Resource(OWL_NS . 'imports');
$OWL_intersectionOf = new Resource(OWL_NS . 'intersectionOf');
$OWL_InverseFunctionalProperty = new Resource(OWL_NS . 'InverseFunctionalProperty');
$OWL_inverseOf = new Resource(OWL_NS . 'inverseOf');
$OWL_maxCardinality = new Resource(OWL_NS . 'maxCardinality');
$OWL_minCardinality = new Resource(OWL_NS . 'minCardinality');
$OWL_Nothing = new Resource(OWL_NS . 'Nothing');
$OWL_ObjectClass = new Resource(OWL_NS . 'ObjectClass');
$OWL_ObjectProperty = new Resource(OWL_NS . 'ObjectProperty');
$OWL_ObjectRestriction = new Resource(OWL_NS . 'ObjectRestriction');
$OWL_oneOf = new Resource(OWL_NS . 'oneOf');
$OWL_onProperty = new Resource(OWL_NS . 'onProperty');
$OWL_Ontology = new Resource(OWL_NS . 'Ontology');
$OWL_priorVersion = new Resource(OWL_NS . 'priorVersion');
$OWL_Property = new Resource(OWL_NS . 'Property');
$OWL_Restriction = new Resource(OWL_NS . 'Restriction');
$OWL_sameAs = new Resource(OWL_NS . 'sameAs');
$OWL_sameClassAs = new Resource(OWL_NS . 'sameClassAs');
$OWL_sameIndividualAs = new Resource(OWL_NS . 'sameIndividualAs');
$OWL_samePropertyAs = new Resource(OWL_NS . 'samePropertyAs');
$OWL_someValuesFrom = new Resource(OWL_NS . 'someValuesFrom');
$OWL_SymmetricProperty = new Resource(OWL_NS . 'SymmetricProperty');
$OWL_Thing = new Resource(OWL_NS . 'Thing');
$OWL_TransitiveProperty = new Resource(OWL_NS . 'TransitiveProperty');
$OWL_unionOf = new Resource(OWL_NS . 'unionOf');
$OWL_versionInfo = new Resource(OWL_NS . 'versionInfo');




// DC concepts
$DC_contributor = new Resource(DC_NS . 'contributor');    
$DC_coverage = new Resource(DC_NS . 'coverage');  
$DC_creator = new Resource(DC_NS . 'creator');  
$DC_date = new Resource(DC_NS . 'date');  
$DC_description = new Resource(DC_NS . 'description');  
$DC_format = new Resource(DC_NS . 'format');  
$DC_identifier = new Resource(DC_NS . 'identifier');  
$DC_language = new Resource(DC_NS . 'language');  
$DC_publisher = new Resource(DC_NS . 'publisher');  
$DC_rights = new Resource(DC_NS . 'rights');  
$DC_source = new Resource(DC_NS . 'source');  
$DC_subject = new Resource(DC_NS . 'subject');  
$DC_title = new Resource(DC_NS . 'title');  
$DC_type = new Resource(DC_NS . 'type');  

?>