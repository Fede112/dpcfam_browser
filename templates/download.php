<?php

session_start();

$mc_matches_ids = $_SESSION['ids'];
// TODO: check if searching by page-id is faster (thats my assumption)
$mc_matches = $pages->find("id=$mc_matches_ids"); 

$temp_dir = $files->tempDir('downloads');
// echo $temp_dir."<br>";
$temp_dir->setRemove(false);
$temp_dir->removeExpiredDirs(dirname($temp_dir), $config->erase_tmpfiles); // remove dirs older than $config->erase_tmpfiles seconds


if(isset($_GET['fasta']))
{
	$zip_file = $temp_dir . "fasta_cdhit60.zip";
	$page_path_prop = "cdhit_path"; // to decide which path to retrieve from page
}
if(isset($_GET['msa']))
{
    $zip_file = $temp_dir . "msas.zip";
    $page_path_prop = "msa_path"; // to decide which path to retrieve from page
}
if(isset($_GET['hmm']))
{
	$zip_file = $temp_dir . "hmms.zip";
	$page_path_prop = "hmm_path";
}



$matches_path = array();
foreach($mc_matches as $item)
{
    echo $item->$page_path_prop . "<br>";
	array_push($matches_path,$item->$page_path_prop);
	// array_push($matches_hmm_path,$item->hmm_path);
}

echo $zip_file."<br>";
print_r($matches_path);//."<br>";
echo basename($zip_file)."<br>";
// create zip
$result_zip = $files->zip($zip_file, $matches_path);


// clean output buffer before sending header
ob_clean();

if (headers_sent()) 
{
    echo 'HTTP header already sent';
} else {
    if (!is_file($zip_file)) {
        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
        echo 'File not found';
    } else if (!is_readable($zip_file)) {
        header($_SERVER['SERVER_PROTOCOL'].' 403 Forbidden');
        echo 'File not readable';
    } else {
        header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: ".filesize($zip_file));
        header("Content-Disposition: attachment; filename=\"".basename($zip_file)."\"");
        readfile($zip_file);
        exit;
    }
}



?>