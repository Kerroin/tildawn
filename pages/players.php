<!DOCTYPE html>
<?php
require("../controller/azure.php");
$players = getPlayers();
//getPlayers -> (id, amulet, firstname, lastname, team, score)

$causesBonus = getCauses("Bonus");
$causesMalus = getCauses("Malus");
//getCauses -> cause, category, value

//add link to player information
//export scoreboard (format?)
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>'tildawn - Players</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        <?php include("nav.php");?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Players</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
				
				
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						    <button type="button" class="btn btn-info">Export Scoreboard</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Amulet</th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Team</th>
                                        <th>Score</th>
										<th>Score with Team</th>
										<th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
								    <?php 
									    $parity = 1;
									    foreach ($players as $player){
										    if($parity == 1){
												echo '<tr class="odd">';
											}
                                            else{
												echo '<tr class="even">';
											}
                                            echo '<td>'.$player['amulet'].'</td>';
                               				echo '<td>'.$player['firstname'].'</td>';
                                            echo '<td>'.$player['lastname'].'</td>';
                                            echo '<td>'.$player['team'].'</td>';
                                            echo '<td>'.$player['score'].'</td>';
											echo '<td>'.calculateWeightedScore($player).'</td>';
                                            echo '<td style="text-align:center;"><button type="button" class="btn btn-success btn-circle" data-toggle="modal" data-player="'.$player['id'].'" data-target="#addBonus"><i class="fa fa-plus"></i></button>   <button type="button" class="btn btn-danger btn-circle" data-toggle="modal" data-player="'.$player['id'].'" data-target="#addMalus"><i class="fa fa-minus"></i></button></td>';							
										    echo '</tr>';
										}
								    ?>
									
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                           
                            <!-- Modal Bonus -->
                            <div class="modal fade" id="addBonus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add Bonus to Player</h4>
                                        </div>
										<form name="bonus" role="form" method="post" action="../controller/addBonusMalus.php">

											<div class="modal-body">
													<div class="form-group">
														<select name="name" class="form-control">
															<?php foreach($causesBonus as $cause){?>
															<option><?php echo $cause["name"]; ?></option>
															<?php };
															?>
														</select>
													</div>
													<input type="hidden" class="id" name="id" value="">
													<input type="hidden" name="src" value="player">
												
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
												<button type="submit" class="btn btn-primary">Save</button>
											</div>
										</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
							<!-- Modal Malus -->
                            <div class="modal fade" id="addMalus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Add Malus to Player</h4>
                                        </div>
										<form name="malus" role="form" method="post" action="../controller/addBonusMalus.php">
										<div class="modal-body">
                                        
											    <div class="form-group">
													<select name="name" class="form-control" onchange="fillValue(this.value)">
														<?php foreach($causesMalus as $cause){?>
														<option><?php echo $cause["name"]; ?></option>
														<?php };
														?>
													</select>
												</div>
												<input type="hidden" class="id" name="id" value="">
												<input type="hidden" name="src" value="player">
										
										</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
										</div>
										</form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
	
	<!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
			order: [[5, 'desc']],
			"columnDefs": [
				{ "orderable": false, "targets": 6 },
				{ "width": "5%", "targets": 6 }
			]
        });
    });
    </script>
	<script>
	$('#addBonus').on('show.bs.modal', function (event){
        var button = $(event.relatedTarget)
        var player = button.data('player')
		var modal = $(this)
        modal.find('.modal-body .id').val(player)
	})
	</script>

</body>

</html>
