<?php include("_header.php");?>
<head>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
</head>
<!-- <link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/protein_table.css"> -->
<link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/histogram.css">



<?php
// Auxiliary Function
function pfam_da_split($pfam_da) {
	
	$pfam_da = str_replace ("PF" , "-PF", $pfam_da);
    $pfam_da = ltrim($pfam_da, '-'); 

	// $test=$test[1:];

	$test = explode ( "-" , $pfam_da);

	return $test;
}

?>



<main class="flex-shrink-0">
	<div class="container">	

	<?php //foreach ($pfam_da as $pf) {echo $pf. "\t";} ?>
	<h1 class="mt-5"><?php echo "MC".$page->title; ?></h1>
	<h4 class="mt-3"> <img src="https://img.icons8.com/ios-glyphs/30/000000/analytics.png"s/> <?php echo "General statistics"; ?> </h4>

  	<div class="row">
  	<div class="col-sm">
	
	<div style="line-height:180%;">
	Number of sequences (UniRef50): <?php echo $page->size; ?><br>
	Number of sequences (CDHIT-60%): <?php echo "Missing" ?><br>
	Average sequence length: <?php echo $page->len_avg; ?><span>&#177;</span><?php echo $page->len_std; ?><br>
	Average number of transmembrane regions: <?php echo $page->tm; ?><br>
	% Low complexity: <?php echo $page->lc; ?><br>
	% Coiled coils: <?php echo $page->cc; ?><br>
	% Disordered domains: <?php echo $page->dc; ?><br>
	</div>

	<h5 class="mt-3"><?php echo "Pfam content"; ?></h4>


	<div style="line-height:180%;">
	<?php 
	// Check if comparisson against pfam exists
	if($page->pfam_da != "-")
	{
		// check if it has a Pfam label
		if (strpos($page->pfam_da, "PF") !== false)
		{
			$pfam_das = pfam_da_split($page->pfam_da);
			$pfam_count =  count($pfam_das);
		?>
		
		Pfam equivalence: <?php for ($i=0; $i < $pfam_count; ++$i) {?> <a href="<?=$pages->get(1)->url."?category=Pfam&search_input=".$pfam_das[$i];?>" target="_blank"> <?php echo $pfam_das[$i]; ?> </a> <?php if($i!=$pfam_count-1){echo "-";}} if($pfam_count > 1){echo "(architecture)";}?><br>

		<!-- <svg width="18px" height="18px" viewBox="0 0 24 24"><g id="external_link" class="icon_svg-stroke" stroke="#666" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 13.5 17 19.5 5 19.5 5 7.5 11 7.5"></polyline><path d="M14,4.5 L20,4.5 L20,10.5 M20,4.5 L11,13.5"></path></g></svg><br>  -->

		<?php }

		else{ ?>
			Pfam equivalence: <?php echo $page->pfam_da; ?><br>
		<?php } ?>
		<!-- Pfam equivalence: <?php foreach (pfam_da_split($page->pfam_da) as $pf) {?> echo $pf. "\t";<?php } ?><br> -->

		


		Pfam overlap: <?php echo $page->pfam_overlap; ?><br>
		Pfam overlap type: <span style="color:<?=$pfam_eser_colors[$page->pfam_eser]?>;"> <strong><?= $page->pfam_eser; ?></strong></span>

	<?php 
	}
	else{
		echo "Pfam comparisson not available.";
	}?>


	</div>
    </div>
    

    
    <div class="col-sm">
	
		<figure class="highcharts-figure">
		    <div id="hist-length"></div>
		    <p class="highcharts-description">
		    </p>
		</figure>
    </div>



	</div>

	

	<?php

	// QUERY PROTEINS

	?>
	<hr/>
	<h4 class="mt-3"><?php echo "Sequences list"; ?></h4>


	<?php // $protein_matches = $pages->find("template=protein, mcs_in_protein.metacluster={$page->title})"); ?>



	<?php // if (file_exists($fasta_path)){?>
	<?php if (0){?>
	<table id="protein_table" border = '2'>
			<tr>
			<th>Protein</th>
			<th>Range</th>
			<th style="width: 100%">AA</th>
			</tr>

		<?php



			$file = fopen($fasta_path, 'r');
			
			$index = 0;
			while (($line = fgetcsv($file, 1000, '|')) !== FALSE) {
				//$line is an array of the csv elements		
				if($index%2==0){
					$uniprot = substr($line[0], 1);
					$range = $line[1];
				}
				else{

			    	echo "<tr>";
			    	echo '<td><a href="' . $config->urls->httpRoot. 'proteins/'. $uniprot . '">' . $uniprot . '</a></td>';
			    	// echo "<td>" . $uniprot . "</td>";
			    	echo "<td>" . $range . "</td>";
			    	echo "<td>" . trim($line[0]) . "</td>";
			    	echo "</tr>";
			    }
			    $index++;
				
			}
			fclose($file);
	}
	else{
		echo "<b>Sequences information not available! </b> <br>";
	}


		?>



		<h4 class="mt-3"><?php echo "Downloads"; ?></h4>


	<?php 

	// Paths
	$fasta_path = $page->fasta_path;
	$fasta_fileurl = path2url($fasta_path);
	$fasta_filename = basename($fasta_path);

	$cdhit_path = $page->cdhit_path;
	$cdhit_fileurl = path2url($cdhit_path);
	$cdhit_filename = basename($cdhit_path);

	$msa_path = $page->msa_path;
	$msa_fileurl = path2url($msa_path);
	$msa_filename = basename($msa_path);

	$hmm_path = $page->hmm_path;
	$hmm_fileurl = path2url($hmm_path);
	$hmm_filename = basename($hmm_path);
	?>


	


<!-- 	<?php

	if (file_exists($fasta_path)){ ?>
		Seeds: <a href="<?php echo $fasta_fileurl; ?>" download=<?php echo $fasta_filename; ?>> <?php echo $fasta_filename; ?> </a><br/>
	<?php
	}else
	{ ?>
		Seeds: Not available <br/>

	<?php 
	}
	?>
 -->

	</table>

	<hr/>

		
			<table class="table">
		<thead>
		    <tr>
		      <th scope="col">File</th>
		      <th scope="col">Description</th>
		      <th scope="col">Link</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td>DPCfam full seeds</td>
		      <td>DPCfam classification of the UniRef50 database (v. 201707)</td>
		      <td>
		      	<a href="<?= path2url($config->paths->bulkfiles."fasta/dpcfam_seeds.zip"); ?>" download="dpcfam_cdhit_seeds.zip">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  	</svg>
		  	 	</a>
			  </td>
		    </tr>
		    <tr>
		      <td>DPCfam cdhit-0.60 seeds</td>
		      <td>DPCfam classification of the UniRef50 database (v. 201707) filtered using 60% as the similarity threshold in cdhit.</td>

		      <td>
		      	<a href="<?= path2url($config->paths->bulkfiles."cdhit/dpcfam_cdhit_seeds.zip"); ?>" download="dpcfam_cdhit_seeds.zip">
		      	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  	</svg>
			  	</a>
			  </td>
		    </tr>
		    <tr>
		      <td>DPCfam MSA</td>
		      <td>Multiple sequence alignment of each Metacluster using DPCfam cdhit-060 seeds as input.</td>
		      <td>
		      	<a href="<?= path2url($config->paths->bulkfiles."msa/dpcfam_msas.zip"); ?>" download="dpcfam_msas.zip">
		      	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  	</svg>
			  	</a>
			  </td>
		    </tr>
		    <tr>
		      <td>DPCfam HMM profiles</td>
		      <td>HMM-profiles for all MCs.</td>
		      <td>
		      	<a href="<?= path2url($config->paths->bulkfiles."hmm/dpcfam_hmms.zip"); ?>" download="dpcfam_hmms.zip">
		      	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  				<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"></path>
  				<path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"></path>
			  	</svg>
			  	</a>
			  </td>
		    </tr>
		    </tbody>

		    <caption style="font-size: .9rem;
								color: #767676;
								width: 80%;
								padding-top: .5rem;">Table 1: DPCfam full output and post processed files.
			</caption>
		</table>


	</div>


</main>

<script>


	async function getData() {
		// const response = await fetch('/site/config.php');
		const response = await fetch('/site/assets/data_website/fasta/dir_1/MC2000.fasta');
		const data = await response.text();
		// console.log(data);

		const rows = data.split('\n');
		for (let i = 0; i < rows.length; i++){
			if ( rows[i].startsWith(">") ){
				// console.log(rows[i].split("|")[1].split("-"));				
				const range = rows[i].match(/(\d+)-(\d+)/g)[0].split("-");
				const len = range[1]-range[0]+1;
				domains_len.push(len);
				
			}

			
		}
	}


	async function chartHist(){
		await getData();

		Highcharts.chart('hist-length', {
			chart: {
		        plotBackgroundColor: null,
		        plotBorderWidth: null,
		        plotShadow: false,
		        reflow: false,
	    	},
		    title: {
		        text: '',
		    },

		    xAxis: [{
		        title: { text: 'Domain length' },
		        alignTicks: false,
		        /* opposite: true */
		    }],

		    yAxis: [{
		        title: { text: 'Counts' },
		        /* opposite: true */
		    }],
		    
		    
		    
		    series: [{
		        name: 'Histogram',
		        type: 'histogram',
		         xAxis: 0,
		        yAxis: 0, 
		        baseSeries: 1,
		        showInLegend: false,
		        // zIndex: -1
		    }, {
		        data: domains_len,
                showInLegend: false,
		        visible:false,
		    }]
		});


	}

	
const domains_len = [];
chartHist();

	

 </script>

<?php include("_footer.php");?>
