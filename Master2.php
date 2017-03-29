<?php
   //require("data.php");
   $page['title'] = "The Master Schedule";
   
    $db_ip = "172.16.5.201";
    
    if(isset($_POST['Planned']))
    {
        echo "Submitting\n";
        print_r($_POST);
        //; $i++ throwing error
        for($i = 0; $i<count($_POST['Planned']); $i++)
        //for($i = 0; $i<count($_POST['Planned']);)
        {
            $dataString = "Planned=".$_POST['Planned'][$i].",Sched=" . $_POST['Sched'][$i].",RFC=" . $_POST['RFC'][$i].",TechName=" . $_POST['TechName'][$i].";";
        }
        echo "\n".$dataString;
        // set post fields
        $post = [
        'submit' => 'true',
        'activity_name' => 'DataSend',
        'params'   => [
        'Data' => $dataString
        ]
        ];
    
    } else {
        $post = [
        'submit' => 'true',
        'activity_name' => 'GetDBMsg',
        'params'   => [
        'CustomData' => '',
        //'SendToSema' => '0'
        ]
        ];
    }
    
    $result = "";
	
    //print_r($_POST);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://".$db_ip."/Deployments/Master2.php");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    if(isset($_POST['DONE']) === true){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    }
    //callbacks functions for the CURL library
    //   curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');
    //curl_setopt($ch, CURLOPT_WRITEFUNCTION, 'read_body');
    
    $result = curl_exec($ch);
    
    
    if ($error = curl_error($ch)) {
        echo "Error: $error<br />\n";
    }
    
    // define callback functions
    
    // Return the number of bytes actually written or return -1 to signal error to
    // the library (it will  cause it to abort the transfer with a CURLE_WRITE_ERROR
    // return code). (Added in 7.7.2)
    function read_header($ch, $string)
    {
        $length = strlen($string);
        echo "Header: $string<br />\n";
        return $length;
    }
    
    // Return the number of bytes actually taken care of.  If that amount differs
    // from the amount passed to your function, it'll signal an error to the library
    // and it will abort the transfer and return CURLE_WRITE_ERROR.
    function read_body($ch, $string)
    {
        
        $length = strlen($string);
        echo "String: $string<br />\n";
        echo "Received $length bytes<br />\n";
        return $length;
    }
    
    $results = json_decode($result,true);
    
    include("_assets/header.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<meta name="Deployments" content="width=device-width, initial-scale=1.0">
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
<form name="itemsform" action="" method="post" id="envoySubmit">
<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
<td colspan="4" style="text-align: right;"><input type="submit" class="button" name="submit" value="DONE" /></td>
</tr>
</div>
</section>
<script type="text/javascript">
function sendData() {
    var inputs = document.getElementById('equipment-table').getElementsByTagName('input'),
    data = [],
    name, Planned[], Sched[], RFC[], TechName[];
    
    for (var i = 0; i < inputs.length; i++) {
        if ( inputs[i].type === 'submit') {
            continue;
        }
        
        var dataString = ''; for (var i = 0, len = input.length; i<len,i++) { dataString += 'Planned' + i + '=' + Planned[i] + ',Sched' + i + '=' + Sched[i] + ',RFC' + i + '=' + RFC[i] + 'TechName' + i + '=' + TechName[i] + ','; }
        
        var array_objects = [
        {'name': 'Planned[]';},
        {'name': 'Sched[]';},
        {'name': 'RFC[]';},
        {'name': 'TechName[]';},
        ]
        var array_to_join = [];
        
        for (x = 0; x < array_objects.length;
             x++) {
            _.map(array_objects[x], function(key, value) {
                  array_to_join.push(key + '=' + value);
                  });
        }
        document.body.innerHTML =
        array_to_join.join(', ');
    }
}
}

var array_objects = [
{'name': 'Planned[]';},
{'name': 'Sched[]';},
{'name': 'RFC[]';},
{'name': 'TechName[]';},
]
var array_to_join = [];

for (x = 0; x < array_objects.length;
     x++) {
    _.map(array_objects[x], function(key, value) {
          array_to_join.push(key + '=' + value);
          });
}
document.body.innerHTML =
array_to_join.join(', ');


window.onclick = (function(){
               document.itemsform.submit();
               sendData();
               }
               </script>
               </body>
               </html>
               <?php
               include("/_assets/footer.php");
               
?>
