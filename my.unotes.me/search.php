<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
?>
<?php
	$email=$_SESSION['user_email'];
	include '_inc/dbconn.php';
	$sql="SELECT * FROM UNotesMAIN.users WHERE email='$email'";
	$result=  mysql_query($sql) or die(mysql_error());
	$rws=  mysql_fetch_array($result);
                
	// logged in account id & users name and surname
	$account_id= $rws[0];
	$account_name= $rws[1];
                
	$_SESSION['user_id']=$account_id;
	$_SESSION['name']=$account_name;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" type="image/png" href="vendor/img/favicon.png"/>
	<meta name="description" content="UNotes - Your Notes Online">
    <meta name="author" content="UNotes Group">

    <!-- Bootstrap core CSS-->
    <link href="vendor/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts/styles for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/css/sb-admin.css" rel="stylesheet">

    <!-- Page level plugin CSS-->
    <link href="vendor/js/datatables/dataTables.bootstrap4.css" rel="stylesheet">
	
	<title>Search for Notes | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">		  
		  <div class="row">
			<div class="col-xl-12 mb-6">
			  <div class="card o-hidden mb-3" id="general">
				  <div class="panel-group" id="accordion">
					  <div class="panel panel-default">
						<div class="panel-heading">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="color: inherit; text-decoration: none">
							  <div class="card-header">
							  <i class="fas fa-search"></i>
							  Search for Notes</div>
							</a>
						</div>
						<div id="collapse2" class="panel-collapse in">
						  <div class="panel-body">
							  <div class="card-body">
								<form action="edit" method="POST">
									<?php include '_inc/dbconn.php';
										$sql="SELECT * FROM UNotesDAT.notes".$account_id." LEFT JOIN UNotesDAT.notebook".$account_id." on UNotesDAT.notes".$account_id.".notebook = notebook".$account_id.".notebook_id";
										//$sql="SELECT * FROM notes".$account_id; old sql without group function
										$result=  mysql_query($sql) or die(mysql_error());
										$num_rows = mysql_num_rows($result);
									?>	
									<small id="emailHelp" class="form-text">Your have <b><?php echo $num_rows; if ($num_rows == "1") { echo " note</b>."; } else { echo " notes</b> in total."; } ?> Use the <b><i class="fas fa-search"></i> search bar</b> on the right to <b><i class="fas fa-filter"></i> filter</b> your results (<i>notebooks can also be filtered</i>).</small><br>	
									  <div class="table-responsive">
										<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										  <thead>
											<tr>
											  <th>Title</th>
											  <th>Note Content</th>
											  <th>Last Modified</th>
											</tr>
										  </thead>
										  <tbody>
											<?php
												while($rws=  mysql_fetch_array($result)){
													// color matching the badges
													if ($rws[10] == "LIGHTBLUE") {
														$badgecolor = "info";
													} elseif ($rws[10] == "BLUE") {
														$badgecolor = "primary";
													} elseif ($rws[10] == "GRAY") {
														$badgecolor = "secondary";
													} elseif ($rws[10] == "GREEN") {
														$badgecolor = "success";
													} elseif ($rws[10] == "RED") {
														$badgecolor = "danger";
													} elseif ($rws[10] == "YELLOW") {
														$badgecolor = "warning";
													} elseif ($rws[10] == "BLACK") {
														$badgecolor = "dark";
													}
														
													// table output
													echo "<tr onclick='location.href=`edit?note=$rws[0]`'>";
													echo "<td><i class='far fa-sticky-note'></i> ".$rws[2]." <span class='badge badge-".$badgecolor."'>".$rws[9]."</span></td>";
													echo "<td> <i>".substr($rws[3], 0, 70)."...</i></td>";
													echo "<td> ".$rws[5]."</td>";
													echo "</a></tr>";
												} ?>
										  </tbody>
										</table><br>
									  </div>
							  </div>
						  </div>
						</div>
					  </div>
				  </div> 
			  </div>
			</div>
		  </div> <!-- /.row -->
      </div><!-- /.container-fluid -->

    <?php include 'afooter.php' ?>