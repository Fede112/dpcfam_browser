<?php include("_header.php");?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?php echo $config->urls->templates ?>styles/dt.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->

<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"> </script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/natural.js"></script>


    

<main class="flex-shrink-0">
	<div class="container">	
		
		<h1 class="mt-5"><?= $page->title; ?></h1>
		
		<!-- <div style="padding: 25px 0px 25px 0px;"> -->
		<div style="padding: 25px 0px 25px 0px;">
    	<?= $page->body; ?>

  		</div>

	    
		<!-- Begin page content -->

		<!-- class="table table-striped" -->
		<!-- table table-striped nowrap -->
		<table id="example" class="table table-striped nowrap" style="width:100%">
		        <thead>
		            <tr>
		                <th>Name</th>
		                <th>Size Uni50</th>
		                <th>Avg. Len</th>
		                <th>% LC</th>
		                <th>% CC</th>
		                <th>% DIS</th>
		                <th>TM</th>
		                <th>Pfam DA</th>
		                <th>% DA</th>
		                <th>Size Uni50-UniKB</th>
		                <th>Overlap type</th>
		            </tr>
		        </thead>
		        <tfoot>
		            <tr>
		                <th>Name</th>
		                <th>Size Uni50</th>
		                <th>Avg. Len</th>
		                <th>% LC</th>
		                <th>% CC</th>
		                <th>% DIS</th>
		                <th>TM</th>
		                <th>Pfam DA</th>
		                <th>% DA</th>
		                <th>Size Uni50-UniKB</th>
		                <th>Overlap type</th>
		            </tr>
		        </tfoot>
<!-- 	            <caption style="font-size: .9rem;
								color: #767676;
								width: 80%;
								padding-top: .5rem;">Table 1: Summary of measurements of the content of each MC.
				</caption> -->
		</table>

		<div style="padding: 25px 0px 25px 0px;">
    	<?= $page->body_extra; ?>

  		</div>

	</div>
</main>


<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
    	// /var/www/html/dpcfam_innodb/site/assets/data_website/metadata/metadata.json
        "ajax": "/site/assets/data_website/metadata/metadata.json",
        "cache": true,
        "deferRender": true,
        // "createdRow": function ( row, data, index ) {
            // $('td', row).eq(10).addClass(row[10]);
    	// }, 	

    	
        "columnDefs": [
    	    { className: "my_class", "targets": [ 6 ] },
	        {
	            // The `data` parameter refers to the data for the cell (defined by the
	            // `data` option, which defaults to the column being worked with, in
	            // this case `data: 0`.
	            "render": function ( data, type, row ) {
	            	if ( type === 'display') {
	                return '<a href="' + data + '">' + 'MC' + data + '</a>';
	                }
	                // sort based on numbers (trick based on orthogonal data: 
	                // https://datatables.net/manual/data/orthogonal-data)
	                else{
	                	return data;
	                }

	            },
	            "targets": 0

	        },        	
        	// { "visible": false,  "targets": [ 3 ] }
        	{
 				"createdCell": function (td, cellData, rowData, row, col) {
                $(td).addClass(cellData);
            	},
   				"targets": 10 // first CELL That will be checked,
   			},

        ]

    } );
} );


</script>



<?php include("_footer.php");?>
<!-- // echo "<a href='$child->url'>MC$child->title</a><br>"; -->

