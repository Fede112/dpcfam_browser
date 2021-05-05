asdsadsa

<?php include("_header.php");?>

<main class="flex-shrink-0">
    <div class="container"> 

        <h1>Bulk upload</h1>
        <?php if(!isset($_GET['type'])){
            echo "<a href='?type=mcs'>MCs</a><br>";
            echo "<a href='?type=proteins'>Protein seeds</a><br>";
            echo "<a href='?type=hmms'>Hmms</a><br>";
        }else{

            $folder = "data_website";

            // load MC metadata
            if($_GET['type'] == 'mcs')
            {
                $file = $config->paths->assets . $folder . "/metadata/mc_statistics.txt";
                echo "Loading file <strong>{$file}</strong><br>";
                $handle = fopen($file, "r");

                if(!$handle) {echo "Error, file not opened correctly!";exit();}
                for ($i = 0; $row = fgetcsv($handle, 0, " "); ++$i) {

                    if ($row[0][0] === "#"){continue;}

                    # fields from data
                    $title                  = $row[0];
                    $size                   = $row[1];
                    $len_avg                = $row[2];
                    $len_std                = $row[3];
                    $pfam_label             = $row[4];
                    $pfam_fracDA            = $row[5];
                    $pfam_eser              = $row[6];
                    $size_uref_ukb          = $row[7];
                    $pfam_overlap           = $row[8];
                    $pfam_eser              = $row[9];
                    
                    # auxiliary
                    if($title>500000){
                        $dir_num=5;
                    }else{
                        $dir_num=intdiv((int)$title,100000)+1;
                    }
                    $sub_dir = "dir_".$dir_num;
                    $fasta_filename = "MC".$title . "_cdhit.fasta"; 
                    $hmm_filename = "MC".$title. ".hmm";


                    # derived fields
                    $fasta_path = $config->paths->bulkfiles. "fasta/".$sub_dir."/".$fasta_filename;
                    $hmm_path = $config->paths->bulkfiles. "hmms/".$sub_dir."/".$hmm_filename;
                    if ($pfam_label=="UNK"){
                        $pfam_label = "None";
                    }
                    
                    if( $pages->count("template=metacluster, name=$title") == 0){
                        // Create new protein
                        $p = new Page();
                        $p->template          = "metacluster";
                        $p->title             = $title;
                        $p->size              = $size;
                        $p->len_avg           = $len_avg;
                        $p->len_std           = $len_std;
                        $p->size_uref_ukb     = $size_uref_ukb;
                        $p->fasta_path        = $fasta_path;
                        $p->hmm_path          = $hmm_path;
                        $p->pfam_label        = $pfam_label;
                        $p->pfam_fracDA       = $pfam_fracDA;
                        $p->pfam_overlap      = $pfam_overlap;
                        $p->pfam_eser         = $pfam_eser;
                        $p->save();

                    }else{
                        // TODO Update existing data
                    }
                    echo "<br>";
                }
                echo "Done!";

            }


            // load proteins 
            // IMPORTANT NOTE: input file MUST be sorted by protein name or id

            // TODO: add check to verify no data was previously loaded 
            // HOWTO: if( $pages->count("template=protein, name=$title") == 0){

            if($_GET['type'] == 'proteins'){
                die("Loading proteins from browser is temporary disabled.");   
                $file = $config->paths->assets . $folder . "/sequence_test.txt";
                echo "Loading file <strong>{$file}</strong><br>";

                $handle = fopen($file, "r");

                $title_prev = "";
                for ($i = 0; $row = fgetcsv($handle, 0, " "); ++$i) {
                    $title         = $row[0];
                    $index         = $row[1];
                    $sequenceStart = $row[2];
                    $sequenceEnd   = $row[3];
                    $metacluster   = $row[4];
                    $sequenceAA    = $row[5];

                    if ($title !== $title_prev){
                        
                        // Create new protein
                        $p = new Page();
                        $p->template      = "protein";
                        $p->title         = $title;
                        $p->index         = $index;
                        $p->sequenceStart = $sequenceStart;
                        $p->sequenceEnd   = $sequenceEnd;
                        $p->metacluster   = $metacluster;
                        $p->sequenceAA    = $sequenceAA;
                        $p->save();

                    }else{
                        
                    }
                    echo "<br>";

                    // if($i==50){
                    //     echo "done";
                    //     break;

                    // }

                }
            }


            // load hmm files
            if($_GET['type'] == 'hmms'){
                $file = $config->paths->assets . $folder . "/lt1000_001_1.hmm";
                echo "Loading file <strong>{$file}</strong><br>";
                $handle = fopen($file, "r");
                
                // $pa = $pages->find("has_parent!=2,id!=2|7,status<".Page::statusTrash.",include=all");
                // foreach ($pa as $p) {
                //     echo "<li>$p->path</li>";
                // }

                if($handle){
                    while (($line = fgets($handle)) !== false) {
                        // if(str_starts_with($line,"NAME")){ // PHP8.0
                        if (substr( $line, 0, 4 ) === "NAME" ){
                            $title = substr($line,8);
                            // $link =  $title )
                        }
                        
                        // if(str_starts_with($line,"HMM ")){ // PHP8.0
                        if (substr( $line, 0, 4 ) === "HMM " ){
                            $profile = $line;
                            while($line = fgets($handle)){
                                // if(str_starts_with($line,"//")){
                                if (substr( $line, 0, 2 ) === "//" ){
                                    if( $pages->count("template=hmm,name=$title") == 0){
                                        // Create new protein
                                        $p = new Page();
                                        $p->template = "hmm";
                                        $p->title    = $title;
                                        $p->profile  = $profile;
                                        $p->save();
                                        echo "Creating page! ". $title; 

                                    }else{
                                        echo $title;

                                        echo "ERROR!";
                                    }
                                    break;
                                }
                                $profile .= $line;
                                
                            }
                        }
                    }

                    fclose($handle);
                } else {
                    echo "Error opening".$file;
                }
                echo "Done!";


            }

        } ?>
    <div>
</main>
<?php include("_footer.php");?>
