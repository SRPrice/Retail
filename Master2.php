
<?php
    require("/_functions/data.php");
    $page['title'] = "The Master Schedule";

    
//retrieve information from database pilotstores
    $attrs = array(PDO::ATTR_PERSISTENT => true);
	$pdo = new PDO("mysql:dbname=retailsys;host=localhost", "root", "root", $attrs);
	
// the following tells PDO we want it to throw Exceptions for every error.
// this is far more useful than the default mode of throwing php errors
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// prepare the statement. the place holders allow PDO to handle substituting
// the values, which also prevents SQL injection
$stmt = $pdo->prepare("SELECT * from micros UNION ALL SELECT * from infor UNION ALL SELECT * FROM omc");

// bind the parameters
$stmt->bindValue(":productTypeId", 6);
$stmt->bindValue(":brand", "Slurm");

// initialise an array for the results 
$store = array();
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $store[] = $row;
    }
}
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['store']))
        {
            echo "Submitting\n";
	    //print_r($_POST);
            $dataString = "store=" . $_POST['store'] . ",POStype=" . $_POST['POStype'] . "Version=" . $_POST['Version'];
            // set post fields
            $post = [
            'submit' => 'true',
            'activity_name' => 'DataSend',
            'params'   => [
                'Data' => $dataString
            ]
            ];
        }
       
        $result = "";
	print_r($_POST);
	
	    function read_header($string)
        {
            $length = strlen($string);
            echo "Header: $string<br />\n";
            return $length;
        }
	
	}
// set PDO to null in order to close the connection
$pdo = null;

	include("_assets/header.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="Results" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js">
<link href="_assets/css/style.css" type="text/css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.css"/>

</head>
<body>
<section class="blue">
<div id="my-div">
<div align= "center">
<div class="row">
<div class="small-12 columns">
</div>
<h3 class="blue">Master Schedule</h3>
</div>
<div class="row">
<div class="row">
<form action="" method="post">
<table id="example" class="TableRegistry" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Select</th>
							<th>Store</th>
                            <th>POS Type</th>
							<th>Version</th>
							<th>Planned Deployment</th>
							<th>Scheduled Go Live</th>
							<th>RFC</th>
							<th>Tech Name </th>
						</tr>
					 </thead>
					 <tfoot>
					 <tr>
							<th>Select</th>
							<th>Store</th>
                            <th>POS Type</th>
							<th>Version</th>
							<th>Planned Deployment</th>
							<th>Scheduled Go Live</th>
							<th>RFC</th>
							<th>Tech Name </th>
						</tr>
					 </tfoot>
				   <tbody>
				   <?php
				  foreach($store as $row) {					
					?>
					<tr>
					<td><input type="checkbox" name="TextBox[]"></td>
					<td><?= $row['store']; ?></td>
                    <td><?= $row['POStype']; ?></td>
					<td><?= $row['Versions']; ?></td>
					<td><input type="text" name="Planned" id="Planned" name="Planned[]"></td>
					<td><input type="text" type="text" name="Sched" id="Sched" name="Sched[]"></td>
					<td><input type="text" name="RFC" id="RFC" name="RFC[]"></td>
					<td><input type="text" name="TechName" id="TechName" name="TechName[]"></td>
				   </tr>
				   <?php
				  }
				  ?>
				  
			</tbody>
                </table>
</div>
<div align="center">
</div class="col-sm-7">
<div class="dataTables_paginate paging_simple_numbers" id="example_paginate">
<ul class="pagination">
<li class="paginate_button previous disabled" id="example_previous"><a href="#" aria-controls="example" data-dt-idx="0" tabindex="0">Previous</a></li>
<li class="paginate_button active"><a href="#" aria-controls="example" data-dt-idx="1" tabindex="0">1</a></li>
<li class="paginate_button "><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0">2</a></li>
<li class="paginate_button next" id="example_next"><a href="#" aria-controls="example" data-dt-idx="3" tabindex="0">Next</a></li>
</ul>
</div>
</div>
<div align="center">
<div class="small-12 columns text-center">
<a href="http://localhost/Retail/master.php" class="clear-filters">Search Again</a>
<a href="Master.xlsm" class="clear-filters">Export To Excel File</a>
<a href="//pdfcrowd.com/url_to_pdf/" class="clear-filters">Save to PDF</a>
</div>
</div>
</div>
</section>

<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/dt-1.10.12/datatables.min.js"></script>

<script type="text/javascript" type="text/javascript">
$('#datatableId tfoot tr').appendTo('#datatableId thead');
</script>
<script type="text/javascript" type="text/javascript">
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
</script>
<div align="center'>
 <tr>
	<td colspan="4" style="text-align: center;"><input type="submit" name="submit" value="save" /></td>
	    </tr>
		</div>
</section>
<!--This is the code I am trying to parse and then send to the database -->
<script type="text/javascript">
function sendData() {
    var inputs = document.getElementById('example').getElementsByTagName('input'),
    data = [],
    name, TextBox, store, POStype, Version, Planned, Sched, RFC, TechName;
    
    for (var i = 0; i < inputs.length; i++) {
        if ( inputs[i].type === 'submit') {
            continue;
        }
        
        if ( inputs[i].value ) {
            name = inputs[i].name.split('-val');
            TextBox = inputs[i].name.split('TextBox');
            
            if (TextBox.length > 1) {
                data.push({name: name[0], TextBox: inputs[i].value});
            }
            else {
                data.push({name: name[0], store: inputs[i].value});
            }
            else {
                data.push({name: name[0], POStype: inputs[i].value});
            }
			else {
                data.push({name: name[0], Version: inputs[i].value});
            }
			else {
                data.push({name: name[0], Planned: inputs[i].value});
            }
			else {
                data.push({name: name[0], Sched: inputs[i].value});
            }
			else {
                data.push({name: name[0], RFC: inputs[i].value});
            }
			else {
                data.push({name: name[0], TechName: inputs[i].value});
            }
        }
    }
 }

</script>
<?php
use retailsys\ORM\deployments;
$data = [
	'store', 'POStype', 'Version', 'Planned', 'Sched', 'RFC', 'TachName'
];
$articles = deployments::get('Articles');
$entities = $articles->newEntities($this->request->getData());

// In a controller.
foreach ($store as $row) {
    // Save row
    $articles->save($row);
};
?>
<script type="text/javascript">   
window.onclick(function(){
document.example.save();
sendData();
}
 </script>
 <!-- Here ^ I do not have anythign to send it to the DB -->
</body>
</html>
<?php
    include("/_assets/footer.php");
    ?>
