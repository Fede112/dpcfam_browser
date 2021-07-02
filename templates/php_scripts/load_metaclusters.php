<?php 
// Load proteins 
// This program is meant to run on console, NOT from a browser
// IMPORTANT NOTE: input file MUST be sorted by protein name or id
namespace ProcessWire;

include("../../../index.php"); // bootstrap ProcessWire

$folder = "data_website/metadata/";
$file = $config->paths->assets . $folder . "metadata.txt";

$input = readline('Sure you want to upload metaclusters from '.$file.'? (yes/no): '.PHP_EOL);
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

$title_prev = "";
$header_rows = 0;

try {

    $template = $templates->get('metacluster'); 
    $parent = $pages->get('template=metaclusters'); 
    $database->beginTransaction();

    for ($i = 0; $row = fgetcsv($handle, 0, " "); ++$i) 
    {

        if ($row[0][0] === "#"){$header_rows++;continue;}

        # fields from data
        $title                  = $row[0];
        $size                   = $row[1];
        $len_avg                = $row[2];
        $len_std                = $row[3];
        $lc                     = 100*$row[4];
        $cc                     = 100*$row[5];
        $dis                    = 100*$row[6];
        $tm                     = $row[7];
        $pfam_da                = $row[8];
        $pfam_da_frac           = $row[9];
        $size_uref_ukb          = $row[10];
        $pfam_overlap           = $row[11];
        $pfam_eser              = $row[12];
        
        # auxiliary
        if($title>500000){
            $dir_num=5;
        }else{
            $dir_num=intdiv((int)$title,100000)+1;
        }
        $sub_dir = "dir_".$dir_num;
        $cdhit_filename = "MC".$title . "_cdhit.fasta"; 
        $msa_filename = "MC".$title . ".msa"; 
        $hmm_filename = "MC".$title. ".hmm";


        # derived fields
        $cdhit_path = $config->paths->bulkfiles. "cdhit/".$sub_dir."/".$cdhit_filename;
        $hmm_path = $config->paths->bulkfiles. "hmm/".$sub_dir."/".$hmm_filename;
        $msa_path = $config->paths->bulkfiles. "msa/".$sub_dir."/".$msa_filename;
        if ($pfam_da=="UNK"){
            $pfam_da = "None";
        }
        
        // if( $pages->count("template=metacluster, name=$title") == 0){
            // Create new protein
            $page = new Page();
            $page->template          = $template;
            $page->parent            = $parent;
            // $page->template          = "metacluster";
            $page->title             = $title;
            $page->name              = $title;
            $page->size              = $size;
            $page->len_avg           = $len_avg;
            $page->len_std           = $len_std;
            $page->lc                = $lc;
            $page->cc                = $cc;
            $page->dis               = $dis;
            $page->tm                = $tm;

            $page->size_uref_ukb     = $size_uref_ukb;
            $page->cdhit_path        = $cdhit_path;
            $page->msa_path          = $msa_path;
            $page->hmm_path          = $hmm_path;
            $page->pfam_da           = $pfam_da;
            $page->pfam_da_frac      = $pfam_da_frac;
            $page->pfam_overlap      = $pfam_overlap;
            $page->pfam_eser         = $pfam_eser;
            $page->save();
        // }else{
            // TODO Update existing data
        // }

        
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
    
} catch(\Exception $e) 
{
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