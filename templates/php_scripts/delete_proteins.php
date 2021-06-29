<?php

namespace ProcessWire;

include("../../../index.php"); // bootstrap ProcessWire

$input = readline('Sure you want to delete all proteins from database? (yes/no): '.PHP_EOL);

if ($input!=="yes"){
	echo "No modifications done. Bye!"."\n";
	die();
}

$trans_size = readline('Size of transaction: '.PHP_EOL);

$time_init = microtime(true);
$time_pre = $time_init;
$count = 1;
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
			
			if (($count)%$trans_size == 0)
		    {
		        // echo $i-$header_rows + 1 ."\n"; // + 1. to enumerate rows starting from 1
		        $time_post = microtime(true);
		        $dt = $time_post - $time_pre;
		        $time_pre = $time_post;
		        // $m = memory_get_usage();
		        // echo $i."\n";
		        // echo "Time for loading single file: " . round($dt/1000, 3). "\n";
		        echo "Pages deleted: ". $count . "\n";
		        echo "Delta (s): " . round($dt, 3). "\n";
		        echo "Pages deleted per second: " . round($trans_size/$dt, 3). "\n";
		        $database->commit();
		        // $pages->uncacheAll();
		        gc_collect_cycles();
		        $database->beginTransaction();
		    }

		}
		$database->commit();
	} catch(\Exception $e) {
		$database->rollBack();
	}

	echo "Done\n";


	$time_post = microtime(true);
	$dt = $time_post - $time_init;
	// $m = memory_get_usage();
	// echo $count."\n";
	echo "Average pages deleted per second: " . round($count/$dt, 3). "\n";
	echo "Total pages deleted: " . $count - 1 . "\n";
}

?>