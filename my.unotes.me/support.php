<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
?>
<?php
	include '_inc/dbconn.php';

	if (isset($_REQUEST['q_done'])){ // Marks question as 'done'
		include 'aheader.php';
		$reviewer = $acc_username;
		$qid = $_REQUEST['question_id'];

	    $sql1="UPDATE UNotesMAIN.questions SET status='REVIEWED' WHERE id='$qid'";
	    mysql_query($sql1) or die(mysql_error());
		$sql2="UPDATE UNotesMAIN.questions SET readby='$reviewer' WHERE id='$qid'";
	    mysql_query($sql2) or die(mysql_error());
		header("location:support?reviewed&success=3");
		
	} elseif (isset($_REQUEST['q_doing'])){ // Marks question as 'doing'
		include 'aheader.php';
		$reviewer = $acc_username;
		$qid = $_REQUEST['question_id'];

		$sql1="UPDATE UNotesMAIN.questions SET status='DOING' WHERE id='$qid'";
	    mysql_query($sql1) or die(mysql_error());
		$sql2="UPDATE UNotesMAIN.questions SET readby='$reviewer' WHERE id='$qid'";
	    mysql_query($sql2) or die(mysql_error());
		header("location:support?new&success=2");
		
	} elseif (isset($_REQUEST['q_delete'])){ // Deletes the question
		$qid = $_REQUEST['question_id'];

		$sql="DELETE FROM UNotesMAIN.questions WHERE id='$qid'";
		mysql_query($sql) or die(mysql_error());
		header("location:support?new&success=4");
		
	} elseif (isset($_REQUEST['q_review'])){ // Marks question as 'TO REVIEW'
		$qid = $_REQUEST['question_id'];

	    $sql="UPDATE UNotesMAIN.questions SET status='TO REVIEW' WHERE id='$qid'";
	    mysql_query($sql) or die(mysql_error());
		$sql="UPDATE UNotesMAIN.questions SET readby='' WHERE id='$qid'";
	    mysql_query($sql) or die(mysql_error());
		header("location:support?new&success=1");
	}
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
	
	<title>Support Panel | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">	
			<?php
				if ($_GET['success'] == "1") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> Successfully marked question as 'To Review'. </div>";
				} elseif ($_GET['success'] == "2") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> Successfully marked question as 'Doing'. </div>";
				} elseif ($_GET['success'] == "3") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> Successfully marked question as 'Done'. </div>";
				} elseif ($_GET['success'] == "4") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> Question deleted from database.</div>";
				}
			?>
		  
	<?php if ($acc_type == "admin"){ ?>
		<!-- Display sections -->
		<div class="row text-center">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<select class="form-control" data-error="Select your category." onchange="javascript:location.href = this.value;">
					<option value="" selected disabled>Select section to show below...</option>
					<option value="?new">Status: To review</option>
					<option value="?reviewed">Status: Already reviewed</option>
				</select>
			</div>
			<div class="col-md-3"></div>
		</div><br>

		<!-- Display different sections using php isset(GET) -->
		<?php if (isset($_GET['new'])) { ?>
		<!-- To Review section -->
		<div class="row">
		    <div class="col-xl-12 mb-6">
			  <div class="card o-hidden mb-3">
				<div class="card-header">
				  <i class="fas fa-life-ring"></i> <i>To review</i> - User Support Panel</div>
				<div class="card-body">
				  <?php
					include '_inc/dbconn.php';
					$sql1="SELECT * FROM UNotesMAIN.questions WHERE status='TO REVIEW' OR status='DOING'";
					$result=  mysql_query($sql1) or die(mysql_error());
				  ?>
				  <form action="support.php" method="POST">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
							<th>select</th>
							<th>Sender</th>
							<th>Category</th>
							<th>Message</th>
							<th>Status</th>
							<th>Date</th>
							
						</tr>
					  </thead>
					  <tbody>
						<?php
							while($rws=  mysql_fetch_array($result)){
								echo "<tr><td><input type='radio' name='question_id' value=".$rws[0];
								echo ' checked';
								echo " /></td>";
								echo "<td><b>".$rws[1]."</b> (".$rws[2].")</td>";
								echo "<td>".$rws[3]."</td>";
								echo "<td>".$rws[4]."</td>";
								echo "<td>".$rws[5];
								if ($rws[5] == "DOING"){ echo "<br>(".$rws[6].")</td>"; } else { echo "</td>";}
								echo "<td>".$rws[8]."</td>";
								echo "</tr>";
							}
						?>
					  </tbody>
					</table><br>
					<button type="submit" class="btn btn-success" name="q_done"><i class="fas fa-check"></i> Mark as 'Done'</button>
					<button type="submit" class="btn btn-warning" name="q_doing"><i class="fas fa-pencil-alt"></i> Mark as 'Doing'</button>
					<button type="submit" class="btn btn-danger" name="q_delete"><i class="fas fa-trash-alt"></i> Delete Question</button>
				  </div>
				  </form>
				</div>
			  </div>
		    </div>

		<?php } elseif (isset($_GET['reviewed'])) { ?>
		<!-- Reviewed section -->
		<div class="row">
		    <div class="col-xl-12 mb-6">
			  <div class="card o-hidden mb-3">
				<div class="card-header">
				  <i class="fas fa-life-ring"></i> <i>Reviewed</i> - User Support Panel
				</div>
				<div class="card-body">
				  <?php
					include '_inc/dbconn.php';
					$sql="SELECT * FROM UNotesMAIN.questions WHERE status='REVIEWED'";
					$result=  mysql_query($sql) or die(mysql_error());
				  ?>
				  <form action="support.php" method="POST">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
							<th>select</th>
							<th>Sender</th>
							<th>Category</th>
							<th>Message</th>
							<th>Status</th>
							<th>Reviewed by</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
							while($rws=  mysql_fetch_array($result)){
								echo "<tr><td><input type='radio' name='question_id' value=".$rws[0];
								echo ' checked';
								echo " /></td>";
								echo "<td><b>".$rws[1]."</b> (".$rws[2].")</td>";
								echo "<td>".$rws[3]."</td>";
								echo "<td>".$rws[4]."</td>";
								echo "<td>".$rws[5]."</td>";
								echo "<td>".$rws[6]."</td>";
								echo "</tr>";
							}
						?>
					  </tbody>
					</table><br>
					<button type="submit" class="btn btn-success" name="q_review"><i class="fas fa-clipboard-list"></i> Mark as 'TO REVIEW'</button>
					<button type="submit" class="btn btn-danger" name="q_delete"><i class="fas fa-trash-alt"></i> Delete Question</button>
				  </div>
				  </form>
				</div>
			  </div>
		   </div>
		  </div> <!-- /.row -->
		  
		<?php } ?> 
      </div><!-- /.container-fluid -->
	  
	<?php } else { // non-admins can't access this page
		header('location:notes?error=2');
	} ?>

    <?php include 'afooter.php' ?>