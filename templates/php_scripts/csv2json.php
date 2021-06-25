<?php

namespace ProcessWire;
include("../../../index.php"); // bootstrap ProcessWire
// php function to convert csv to json format
function csvToJson($fname) {
    // open csv file
    if (!($fp = fopen($fname, 'r'))) {
        die("Can't open file...".$fname);
    }
    


    //read csv headers
    while($row = fgetcsv($fp,"1024"," ")){
    	// last header row becomes the keys
    	if ($row[0][0] !== "#"){break;}
    	// Deleting first element in row (#)
    	array_shift($row);
    	$key = $row;
    }
    // Check for header
	if (!isset($key)) {
  		die("Header not define!\n");
	}

	// parse csv rows into array
    $json = array();
    unset($row[3]); 
    unset($row[11]); 
    $row[2] = round(floatval($row[2]),2);
    $row[4] = round(100*floatval($row[4]),2);
    $row[5] = round(100*floatval($row[5]),2);
    $row[6] = round(100*floatval($row[6]),2);
    $row[7] = round(floatval($row[7]),2);
    $row[9] = round(100*floatval($row[9]),2);
    // round($row[11],2)
    // unset($row[12]); 
    $json['data'][] = array_values($row);
    while ($row = fgetcsv($fp,"1024"," ")) {
        unset($row[3]); 
        unset($row[11]);
        $row[2] = round(floatval($row[2]),2);
        $row[4] = round(100*floatval($row[4]),2); 
        $row[5] = round(100*floatval($row[5]),2); 
        $row[6] = round(100*floatval($row[6]),2); 
        $row[7] = round(floatval($row[7]),2); 
        $row[9] = round(100*floatval($row[9]),2); 
        // unset($row[12]); 
    	// Abuse of notation. Last row of header are the keys
	    $json['data'][] = array_values($row);
    }
    
    // release file handle
    fclose($fp);
    
    // encode array to json
    return json_encode($json);
}

$folder = "data_website/metadata/";
$file_in = $config->paths->assets . $folder . "metadata.txt";
$file_out = $config->paths->assets . $folder . "metadata.json";


$json_data = csvToJson($file_in);

file_put_contents($file_out, $json_data);

?>