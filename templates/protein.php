<?php include("_header.php");?>
<link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/protein_diagram.css">

<!-- jquery for changing placeholder with selection-->
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"> </script>

<main class="flex-shrink-0">
	<div  class="container">	

		
		<h1 class="mt-5"><?= $page->title; ?> <a style="margin-top: 0px; margin-left: -5px;" href="<?="https://www.uniprot.org/uniprot/". $page->title; ?>" target="_blank"> <svg style="overflow: visible" width="20px" height="20px" viewBox="0 0 24 24"><g id="external_link" class="icon_svg-stroke" stroke="#125DD9" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 13.5 17 19.5 5 19.5 5 7.5 11 7.5"></polyline><path d="M14,4.5 L20,4.5 L20,10.5 M20,4.5 L11,13.5"></path></g></svg></a></h1>

		<!-- <?php echo count($page->protein_labels); ?> -->


		<section class = "diagram">
			<div class="parent"> 
				<div class="line"></div>
				<div class="line_len_right"><strong><?= "|".$page->protein_length;?></strong></div>
				<div class="line_len_left"><strong>1|</strong></div>
				<?php
				// $diag_min = 1;
				// $diag_max = $page->protein_length;
				
				$colors = array("#FF6384", "#36A2EB", "#4BC0C0", "#7B83EB","#FFCE5C");

				// $colors = array("rgba(255, 99, 132, .90)", "rgba(54, 162, 235, .90)", "rgba(75, 192, 192, .90)", "rgba(123, 131, 235, .90)","rgba(255, 206, 92, .90)");
				
				# decide size of diagram and dict color
				$diag_min = 100000;
				$diag_max = 0;

				$dpcfam_color = array();
				$pfam_color = array();
				$index=0;
				if (count($page->protein_labels)>=1){
					
					foreach ($page->protein_labels as $label){
						# diag. limits
						$diag_min = ($label->align_start < $diag_min) ? $label->align_start : $diag_min;
						$diag_max = ($label->align_end > $diag_max) ? $label->align_end : $diag_max;
						
						# color dict
						$family = "MC".$label->metacluster;
						if (!array_key_exists($family,$dpcfam_color)) {
							$dpcfam_color[$family]=$colors[$index%count($colors)];
							$index++;
						}
					}
				}
				$index=2; // pfam colors starts from a different point than dpcfam
				if (count($page->pfam_protein_labels)>=1){
					
					foreach ($page->pfam_protein_labels as $label){
						# diag. limits
						$diag_min = ($label->align_start < $diag_min) ? $label->align_start : $diag_min;
						$diag_max = ($label->align_end > $diag_max) ? $label->align_end : $diag_max;
			
						# color dict
						$family = "PF".str_pad($label->metacluster,5,"0",STR_PAD_LEFT);
						if (!array_key_exists($family,$pfam_color)) {
							$pfam_color[$family]=$colors[$index%count($colors)];
							$index++;
						}
					}
				}

				$diag_len = $diag_max - 0 + 10;

				?>

				
				<?php
				#------------------
				# plot pfam domains
				#------------------
				$index = 0;
				foreach ($page->pfam_protein_labels as $label) {
					$domain_len = ($label->align_end - $label->align_start + 1);
					$domain_len_perc = 100*$domain_len/$diag_len;
					$family = "PF".str_pad($label->metacluster,5,"0",STR_PAD_LEFT);
					?>

					<div class="pfam_box" style="left:<?= 100*($label->align_start)/$diag_len."%;";?> width:calc(<?= $domain_len_perc ."%"?>); background:<?= $pfam_color[$family];?>" title="<?= $family  ."&#13;start: ". $label->align_start ."&#13;end: ".$label->align_end;?>"><div class="wrapper"><?= $family; ?></div></div>


					<?php $index++;?>

				<?php }
				?>


				<?php
				#--------------------
				# plot dpcfam domains
				#--------------------
				if (count($page->protein_labels)>=1){

					$index = 0;
					foreach ($page->protein_labels as $label) {
						$domain_len = ($label->align_end - $label->align_start + 1); 
						$domain_len_perc = 100*$domain_len/$diag_len;
						$family = "MC".$label->metacluster;
						?>

						<div class="dpcfam_white_box" style="left:<?= 100*($label->align_start)/$diag_len."%;";?> width:calc(<?= $domain_len_perc ."%"?>);?>"><div class="wrapper"><?= "" ?></div></div>
						<div class="dpcfam_box" style="left:<?= 100*($label->align_start)/$diag_len."%;";?> width:calc(<?= $domain_len_perc ."%"?>); background:<?= $dpcfam_color[$family];?>" title="<?= $family  ."&#13;start: ". $label->align_start ."&#13;end: ".$label->align_end;?>"><div class="wrapper"><?= $family ?></div></div>

						<?php $index++;?>


					<?php }

				}

				?>


				<?php
				#------------------
				# Buttons
				#------------------
				$pfam_disabled = "";
				if (count($page->pfam_protein_labels)===0){
					$pfam_disabled = "disabled";
				}
				?>
			</div>
			<!-- <br> -->
			<section class = buttons>
			<div class = parent>
	 			<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" id="dpcfamCheckbox" value="option1" checked disabled>
				  <label class="form-check-label" for="dpcfamCheckbox">DPCfam</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" id="pfamCheckbox" value="option2" onclick="checkAddress()" <?= $pfam_disabled?>>
				  <label class="form-check-label" for="pfamCheckbox">Pfam</label>
				</div>
			</div>
			</section>
		</section>


		


	<!-- ------------------------------------------------------------------- -->
	<h4><strong>List of domains</strong></h4>
	<!-- <hr style="height:4px;border:none;color:#333;background-color:#333;width: 80%;" /> -->
	<hr/>

	<table class="table table-bordered table-striped" style="width: 60%;">
	  <thead>
	    <tr>
	      <th style="width: 40%;">DPCfam domains</th>
	      <th style="width: 40%;">Range</th>
	      <th style="width: 20%;text-align: left;">DPCfam web</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($page->protein_labels as $label){ 
			$family = "MC".$label->metacluster;?>
	    	<tr>
		      <td><?= $family?></td>
		      <td><?= $label->align_start."-".$label->align_end;?></td>

		      <td style=" text-align: left;"><a href="<?=$pages->get(1)->url."?category=DPCfam&search_input=".$family;?>" target="_blank"> <?php echo "search" ?>
			  </td>
		    </tr>
		<?php 
		} 
		?>
	  </tbody>
	</table>

	<?php if (count($page->pfam_protein_labels)!==0){ ?>
		<!-- <hr style="height:4px;border:none;color:#333;background-color:#333;width: 80%;" /> -->
		<hr/>


	
		<table class="table table-bordered table-striped" style="width: 72%;">
		  <thead>
		    <tr>
		      <th style="width: 24%;">Pfam domains</th>
		      <th style="width: 24%;">Range</th>
		      <th style="width: 12%;text-align: left;">DPCfam web</th>
		      <th style="width: 12%;text-align: left;">Pfam web</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach($page->pfam_protein_labels as $label){ 
				$family = "PF".str_pad($label->metacluster,5,"0",STR_PAD_LEFT);?>
		    	<tr>
			      <td><?= $family?></td>
			      <td ><?= $label->align_start."-".$label->align_end;?></td>
			      <td style=" text-align: left;"><a href="<?=$pages->get(1)->url."?category=Pfam&search_input=".$family;?>" target="_blank"> <?php echo "search" ?>
				  </td>
			      <td style=" text-align: left;"><a href="<?php echo "http://pfam.xfam.org/family/".$family; ?>" target="_blank"> <?php echo "search" ?>  <svg style="overflow: visible" width="18px" height="18px" viewBox="0 3 24 24"><g id="external_link" class="icon_svg-stroke" stroke="#125DD9" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 13.5 17 19.5 5 19.5 5 7.5 11 7.5"></polyline><path d="M14,4.5 L20,4.5 L20,10.5 M20,4.5 L11,13.5"></path></g></svg></a>
			      </td>
			    </tr>
			<?php 
			} 
			?>
		  </tbody>
		</table>
	<?php 
	}?>
</main>

<script type="text/javascript">
	function checkAddress()
	{
	    var pfam_chkBox = document.getElementById('pfamCheckbox');
	    var dpcfam_chkBox = document.getElementById('dpcfamCheckbox');
	    var dpcfam_label = document.getElementsByClassName('dpcfam_box');
	    var dpcfam_white_label = document.getElementsByClassName('dpcfam_white_box');
	    var pfam_label = document.getElementsByClassName('pfam_box');
	    
	    if (pfam_chkBox.checked)
	    {
	    	// console.log("checked!")
	    	for(i = 0; i < dpcfam_white_label.length; i++) {
    			dpcfam_white_label[i].style.top = '-50%';
    			// dpcfam_white_label[i].style.opacity = '.9';
  			}
  			for(i = 0; i < dpcfam_label.length; i++) {
    			dpcfam_label[i].style.top = '-50%';
    			dpcfam_label[i].style.opacity = '.9';
  			}
  			for(i = 0; i < pfam_label.length; i++) {
    			pfam_label[i].style.opacity = '.9';
    			pfam_label[i].style.visibility = 'visible';
  			}
	    }
	    else
	    {
	    	// console.log("non checked!")
	    	
	    	for(i = 0; i < pfam_label.length; i++) {
    			pfam_label[i].style.opacity = '0';
    			pfam_label[i].style.visibility = 'hidden';
  			}
	    	for(i = 0; i < dpcfam_white_label.length; i++) {
    			dpcfam_white_label[i].style.top = '0%';
    			// dpcfam_white_label[i].style.opacity = '.95';
  			}
  			
	    	for(i = 0; i < dpcfam_label.length; i++) {
    			dpcfam_label[i].style.top = '0%';
    			dpcfam_label[i].style.opacity = '.9';
  			}
  			
	    	
	    }
	}

</script>

<?php include("_footer.php");?>