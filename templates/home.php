<?php include("_header.php");?>


<?php
$config->debug = true;
session_start();



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
		if(isset($_GET["search_input"]) ){ 


			echo "<hr/>"; ?>
			<!-- DPCfam -->
			<?php
			$search_input = $input->get->text("search_input");
			$search_input = $sanitizer->text($search_input); // processwire sanitizer

			// echo $pages->findOne("template=metacluster, (title=)")->url()."<br>";
			
			// array of mc pages which match the search input
			$mc_matches = new pageArray(); 

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
			}


			if($_GET["category"]=="Pfam"){
				// TODO: implement comma separated protein list
				$mc_matches = $pages->find("template=metacluster, (pfam_label='$search_input')"); // processwire  selector
			}


			if($_GET["category"]=="Proteins"){
				// TODO: search for all mc_matches containing this particular protein
				// TODO: output mc_matches as PageArray
				$protein_match = $pages->find("template=protein, title='$search_input')");
				
				foreach($protein_match as $protein){
					foreach ($protein->mcs_in_protein as $region) {
						$mc_matches->add($pages->findOne("template=metacluster, (title=$region->metacluster)") );	
					}
					}
				

			}

			?>
		    

		    <?php

			// decide filename based of # of MCs
			if ($mc_matches->count == 1)
				$filename = "MC".$mc_matches[0]->name."_seeds.csv";
			else{
				$filename = "seeds_".rand().".csv";
			}

		

			

			////////////////////////			
			// No results from query
			////////////////////////
			if( $mc_matches->count == 0 ){ ?>
				<p>No results for that query!</p>
			
			<?php }

			////////////////////////
			// Single result
			////////////////////////
			elseif( $mc_matches->count == 1 )
			{

				$mc_url = $config->urls->httpRoot . "metaclusters/" . $mc_matches[0]->title;
				// redirect to metacluster page				
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $mc_url");
				die();
			?>

		    				

			<?php

			}
			
			////////////////////////
			// Multiple results
			////////////////////////
			elseif ($mc_matches->count > 1) 
			{
				//// Hyperlinks ?>
				<h3><?php echo "Results for " ,$search_input ,":" ?></h3>
	    		

				<?php
				foreach($mc_matches as $item) { ?>
 				   <a href="<?php echo $item->url; ?>"><?php echo "MC".$item->title; ?></a><br/>

				<?php } ?>

				<br/>
				<h4><?php echo "Downloads"; ?></h4>
				<?php $_SESSION['ids'] = (string) $mc_matches; ?>
				<a href="<?php echo $config->urls->httpRoot."download/?fasta"; ?>">  seeds_cdhit060.fasta </a><br/>
				<a href="<?php echo $config->urls->httpRoot."download/?hmm"; ?>">  models.hmm </a><br/>

			<?php 
			}




			}else 
			
			{
				// NO $search_input!!
			}
			?>








		
		<script>

		$(document).ready(function() {
       	$('#example').dataTable( {
        "scrollX": true
       	} );
     	} );
		</script>



<!--      	<script>
            document
                .getElementById('target')
                .addEventListener('change', function () {
                    'use strict';
                    var vis = document.querySelector('.vis'),   
                        target = document.getElementById(this.value);
                    if (vis !== null) {
                        vis.className = 'inv';
                    }
                    if (target !== null ) {
                        target.className = 'vis';
                    }
            });
        </script> -->


        <style type="text/css">.inv {
    display: none;
} </style>
        

	</div>



    




  	<?php
      // <form>
      //   <div class="inner-form">
      //     <div class="input-field first-wrap">
      //       <div class="input-select">
      //         <select data-trigger="" name="choices-single-defaul">
      //           <!-- <option placeholder="">Category</option> -->
      //           <option>DPCfam</option>
      //           <option>Pfam</option>
      //           <option>Proteins</option>
      //         </select>
      //       </div>
      //     </div>
      //     <div class="input-field second-wrap">
      //       <input id="search" type="text" placeholder="Enter Keywords?" />
      //     </div>

      // </form>
    ?>

</main>

<?php include("_footer.php");?>


