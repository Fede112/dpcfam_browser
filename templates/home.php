<?php include("_header.php");?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php


if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}




// if (isset($_GET['search_input'])){
//      $search_input = $sanitizer->text($_GET['search_input']) // processwire sanitizer
//     	$search_input = substr($search_input, 2) // remove MC
//      $query = $pages->find('template=protein, title={$search_input}') // buscá processwire  selector
//      echo "Resultados " . $query->count

//      foreach ($query as $item) {
//          echo $item->title;
//      }
// }
?>



<!-- Begin page content -->
<main class="flex-shrink-0">
	<div class="container">
		<h1 class="mt-5">DPCfam search</h1>

		<!-- SEARCH FORM -->
		<form id="home-main-search" action="<?php $_PHP_SELF ?>" method="GET">
			<div id="search-elements">
				<select data-trigger="" name="category" id="target">
					<!-- <option placeholder="">Category</option> -->
					<option <?php if ($_GET['category'] == 'DPCfam') { ?>selected="true" <?php }; ?>value="DPCfam">DPCfam</option>
					<option <?php if ($_GET['category'] == 'Pfam') { ?>selected="true" <?php }; ?>value="Pfam">Pfam</option>
					<option <?php if ($_GET['category'] == 'Proteins') { ?>selected="true" <?php }; ?>value="Proteins">Proteins</option>
				</select>

				<?php $value = isset($_GET["search_input"]) ? $_GET["search_input"]: ''; ?>
				
			    <input type="search" class="form-control form-control-lg" name="search_input" id="search_input" placeholder="MC1234" aria-describedby="search_inputHelp" value="<?php echo $value?>">

			    <!-- <img  class="loader_anim" style="float:right;" id='loading' width="100px" src="http://rpg.drivethrustuff.com/shared_images/ajax-loader.gif"/>  -->

				<button type="submit" class="btn btn-primary">
					<svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                  <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
	                </svg>
				</button>

			</div>

			    <!-- <pfam_label for="search_input" class="form-pfam_label">Cluster Name</pfam_label> -->

		    <div id="search_inputHelp" class="form-text">Enter single query or comma separated values.</div>

	        <!-- <div id="DPCfam" class="vis">Content 1</div>
	        <div id="Pfam" class="inv">Content 2</div>
	        <div id="Proteins" class="inv">Content 3</div> -->


		</form>


		<!-- SEARCH RESULTS -->
		<?php
		// All queries, independently of the category, will output a set of MCs pages stored in $mc_matches
		if(isset($_GET["search_input"]) )
		{ 

			echo "<hr/>"; ?>
			<section>
			<!-- DPCfam -->
			<?php
			$search_input = $input->get->text("search_input");
			$search_input = $sanitizer->text($search_input); // processwire sanitizer

			// echo $pages->findOne("template=metacluster, (title=)")->url()."<br>";
			
			// array of mc pages which match the search input
			$mc_matches = new pageArray(); 
			//----------------------
			// Display DPCfam results
			//----------------------
			if($_GET["category"]=="DPCfam"){

				$mc_matches_str = explode(',', $search_input);
				// print_r(count($mc_matches));

				foreach ($mc_matches_str as $mcID) {
					$mcID = substr($mcID,2);
					$page = $pages->get("template=metacluster, (title=$mcID)");
					if($page->id) { // check don't have NullPage
  						$mc_matches->add($page);
					}
				}
				
				// single results
				if( $mc_matches->count == 1 )
				{

					$mc_url = $config->urls->httpRoot . "metaclusters/" . $mc_matches[0]->title;
					// redirect to metacluster page				
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: $mc_url");
					die();
				}
			
				// multiple results
				elseif ($mc_matches->count > 1) 
				{
					//// Hyperlinks ?>
					<h3><?php echo "Results for " ,$search_input ,":" ?></h3>
		    		
					<ul>
					<?php
					foreach($mc_matches as $item) { ?>
	 				   <li><a href="<?php echo $item->url; ?>"><?php echo "MC".$item->title; ?></a></li>
					<?php 
					}?>
					<ul>
				<?php
				}
			}

			//---------------------
			// Display Pfam results
			//---------------------
			if($_GET["category"]=="Pfam"){?>

				<h4><?php echo "MCs matching with ".$search_input. " ranked by overlap:" ?></h4>
				<?php
				// TODO: implement comma separated protein list
				$mc_matches = $pages->find("template=metacluster, (pfam_da='$search_input'),sort=-pfam_overlap"); // processwire  selector
  				?>
				<ol style="margin-top: 25px">
				<?php
				foreach($mc_matches as $item) { 
					if( $mc_matches->count >= 1 ){?>
						<li style="padding: 1px">
      					<a href="<?php echo $item->url; ?>"><?php echo "MC".$item->title; ?></a>
      					<div class="progress" style="width: 10%" data-toggle="tooltip" data-placement="right" title="<?= 'overlap: '. 100*$item->pfam_overlap. "%" ?>">
							<div class="progress-bar" role="progressbar" aria-valuenow="70"
							aria-valuemin="0" aria-valuemax="100" style="background:<?=$pfam_eser_colors[$item->pfam_eser]?>; width:<?=100*$item->pfam_overlap?>%">
							<span class="sr-only"><strong><?= 100*$item->pfam_overlap."%"?></strong></span>
							</div>
						</div> 
  						</li>
  
						
						
					<?php 
					}

				}?>
				</ol>
			<?php
			}



			//---------------------
			// Display Proteins results
			//---------------------
			if($_GET["category"]=="Proteins"){
				$options = array();
				$options['findIDs'] = 1;
				$options['findOne'] = true;

				$time_ini = microtime(true);
				$protein_page = $pages->find("template=protein, title='$search_input'", $options);
				$time_pos = microtime(true);
				echo "search time: " . round($trans_size/$dt, 3). "\n";
				// $protein_page = $pages->get("template=protein, title='$search_input'");

				// if(!($protein_page instanceof NullPage)) 
				if(($protein_page > 0)) 
				{
					// redirect to protein page
					$protein_url = $config->urls->httpRoot . "proteins/" . $search_input;
					$session->redirect($protein_url);
					// echo $protein_url;
					// header("HTTP/1.1 301 Moved Permanently");
					// header("Location: $protein_url");
					// die();
				}

			}

			?>
		    
			</section>



			<section>
		    <?php
		    //----------------------
			// Downloads
			//----------------------
				
		    if( $mc_matches->count > 0 ){ 
		    ?>
			

		
				
				<h4><?php echo "Download query results"; ?></h4>
				<?php $_SESSION['ids'] = (string) $mc_matches; ?>
				<ul>
					<li><a href="<?= $config->urls->httpRoot."download/?fasta"; ?>">  seeds_cdhit060.zip </a></li>
					<li><a href="<?= $config->urls->httpRoot."download/?msa"; ?>">  MSAs.zip </a></li>
					<li><a href="<?= $config->urls->httpRoot."download/?hmm"; ?>">  HMMs.zip </a></li>
				</ul>
			<?php
			}?>
			</section>

			


			<?php 
			//----------------------
			// No results from query
			//----------------------
			if( $mc_matches->count == 0 ){ ?>
				<p>No results for that query!</p>
			
			<?php }?>


			


		<?php

		}else 
		
		{
			// NO $search_input!!
		}
		?>



	</div>



</main>



<?php include("_footer.php");?>



<script type="text/javascript">

// change placeholder based on select
$('#target').change(function(){
    const dbText = $(this).find(':selected').text();
    
    $('#search_input').attr('placeholder', function(){
    	
    	if (dbText=="DPCfam") {
        	return "MC1234"
        }
        if (dbText=="Pfam") {
        	return "PF00123"
        }
        if (dbText=="Proteins") {
        	return "A0A009EE19"
        }
        
    });
    
    // change text
	if (dbText=="DPCfam") {
		$('#search_inputHelp').text( "Enter single query or comma separated values.");
    }
    if (dbText=="Pfam") {
    	$('#search_inputHelp').text("Enter single query.");
    }
    if (dbText=="Proteins") {
    	$('#search_inputHelp').text("Enter single UniProt code.");
    }
  // trigger change on page load to set initial placeholder
}).change()
</script>









