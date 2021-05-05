<?php

namespace ProcessWire;

include("../../../index.php"); // bootstrap ProcessWire

$input = readline('Sure you want to delete all proteins from database? (yes/no): '.PHP_EOL);

if ($input!=="yes"){
	echo "No modifications done. Bye!"."\n";
	die();
}


$time_pre = microtime(true);
$count = 0;
if ($input==="yes"){

	echo "Deleting... ";
	

	$dePages = wire('pages')->find("parent=proteins");
	try {
		$database->beginTransaction();	
		foreach ($dePages as $dePage)
		{	
			// echo $i++. " ".$dePage['title']."\n";
			$dePage->delete();
			$count +=1;
		}
		$database->commit();
	} catch(\Exception $e) {
		$database->rollBack();
	}

	echo "Done\n";


	$time_post = microtime(true);
	$t = $time_post - $time_pre;
	// $m = memory_get_usage();
	echo $count."\n";
	echo "Files deleted per second: " . round($count/$t, 3). "\n";
}

?>