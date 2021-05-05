<?php 
// Load proteins 
// This program is meant to run on console, NOT from a browser
// IMPORTANT NOTE: input file MUST be sorted by protein name or id
namespace ProcessWire;

include("../../../index.php"); // bootstrap ProcessWire

$folder = "data_website/";
$file = $config->paths->assets . $folder . "sequence_test.txt";

$input = readline('Sure you want to upload proteins from '.$file.'? (yes/no): '.PHP_EOL);
if ($input!=="yes"){
    echo "No modifications done. Bye!"."\n";
    die();
}
$trans_size = readline('Size of transaction: '.PHP_EOL);



echo "Loading file {$file}\n";

$handle = fopen($file, "r");
if(!$handle) {echo "Error, file not opened correctly!";exit();}

$time_ini = microtime(true);
$time_pre = $time_ini;

$index_prev = -1;
$header_rows = 0;

try {
    
    $template = $templates->get('protein'); 
    $parent = $pages->get('template=proteins'); 
    $database->beginTransaction();

    for ($i = 0; $row = fgetcsv($handle, 0, " "); ++$i) 
    {

        if ($row[0][0] === "#"){$header_rows++;continue;}


        $title         	= $row[0];
        $index         	= $row[1];
        $align_start 	= $row[2];
        $align_end  	= $row[3];
        $metacluster   	= $row[4];
        // $align_AA    	= $row[5];

        // TODO: add check to verify no data was previously loaded 
        // (not included now to reduce loading time) 
        // HOWTO: if( $pages->count("template=protein, name=$title") == 0){
        if ($index !== $index_prev)
        {
        	$page = new Page();
    		$page->template      = $template;
            $page->parent        = $parent;
    		$page->title         = $title;
            $page->name          = $title;
        }


        $label = new Event();
        $label->metacluster = $metacluster;
        $label->align_start = $align_start;
        $label->align_end  =  $align_end;
        $page->protein_labels->add($label);

    	$page->save();

        $index_prev=$index;
        
        if (($i+1-$header_rows)%$trans_size == 0)
        {
            echo $i-$header_rows + 1 ."\n"; // + 1. to enumerate rows starting from 1
            $time_post = microtime(true);
            $dt = $time_post - $time_pre;
            $time_pre = $time_post;
            // $m = memory_get_usage();
            // echo $i."\n";
            // echo "Time for loading single file: " . round($dt/1000, 3). "\n";
            echo "Delta (s): " . round($dt, 3). "\n";
            echo "Files loaded per second: " . round($trans_size/$dt, 3). "\n";
            $database->commit();
            // $pages->uncacheAll();
            gc_collect_cycles();
            $database->beginTransaction();
        }
        
    }
    $database->commit();
}
catch(\Exception $e) {
    $database->rollBack();
}


$time_post = microtime(true);
$dt = $time_post - $time_ini;
// $m = memory_get_usage();
echo $i-$header_rows + 1 ."\n";
echo "Total time: " . round($dt, 3). "\n";
echo "Files loaded per second: " . round( ($i-$header_rows + 1)/$dt, 3). "\n";
// echo "created $num pages in " . round($t, 3) . "s, " . round($t/$i, 3) . "s per page, used " . convert($m) . " memory\n";


?>