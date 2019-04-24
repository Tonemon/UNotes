<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
?>
<?php
	include '_inc/dbconn.php';
	$account_id=$_SESSION['user_id'];
	$account_name=$_SESSION['name'];

	if (isset($_REQUEST['note_create'])){ // Create note request
		// variables from notes
		$title =  $_POST['note_title'];
		$notebook =  $_POST['note_notebook'];
		$content =  $_POST['note_content'];
		$date = date("Y-m-d H:i:s");

		// setting bookmark variable
		if ($_POST['note_bookmark'] == "1"){
			$bookmark = "1";
		} else {
			$bookmark = "0";
		}

		// insert new note to table 'notes' with userid
		$sql="INSERT into UNotesDAT.notes".$account_id." values('','$account_name','$title','$content','$date','$date','$notebook','$bookmark')";
		mysql_query($sql) or die(mysql_error());
		header('location:notes?success=1');
		
	} elseif (isset($_REQUEST['note_delete'])){ // Delete note request
		
		$delnoteid= $_POST['note_id'];
		if ($delnoteid == ""){
			header('location:notes?error=3');
		} else {
			$sql_delete="DELETE FROM UNotesDAT.notes".$account_id." WHERE id = '$delnoteid'";
			mysql_query($sql_delete) or die(mysql_error());
			header('location:notes?success=2');
		}
	} elseif (isset($_REQUEST['note'])){ // View note request
		$itemid = $_GET['note'];
			$sql2="SELECT * FROM UNotesDAT.notes".$account_id." LEFT JOIN UNotesDAT.notebook".$account_id." on UNotesDAT.notes".$account_id.".notebook = notebook".$account_id.".notebook_id WHERE id='$itemid'";
			$result2=  mysql_query($sql2) or die(mysql_error());
			$rws2=  mysql_fetch_array($result2);
		?>
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
	
	<title>Viewing: <?php echo $rws2[2]; ?> | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">		  
		  <div class="row">
			<div class="col-xl-12 mb-6">
			<script type="text/javascript">
				function myFunction() {
				  $('#viewnoteModal').modal(show);
				} 
			</script>
			  <div class="card o-hidden mb-3" id="general">
				  <div class="panel-group" id="accordion">
					  <div class="panel panel-default">
						<div class="panel-heading">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="color: inherit; text-decoration: none">
							  <div class="card-header">
							  <i class="fas fa-pencil-alt"></i>
							  Viewing note: <i><?php echo $rws2[2]; ?></i></div>
							</a>
						</div>
						<div id="collapse2" class="panel-collapse in">
						  <div class="panel-body">
							  <div class="card-body">
								<form action="edit.php" method="POST">	
									  <div class="row">
										<div class="col-xl-7 form-group">
											<input type="hidden" name="note_id" value="<?php echo $itemid; ?>"/>
											<small id="emailHelp" class="form-text">Note Title</small>
											<input type="text" class="form-control" name="note_alter_title" value="<?php echo $rws2[2]; ?>">
										</div>
										<div class="col-xl-5 form-group">
											<small id="emailHelp" class="form-text">Notebook</small>
											<select class="form-control" name="note_alter_notebook">
												<?php // option depends on selection of notebook or not
												if ($rws2[8] == ""){ ?>
													<option value="" disabled selected>No notebook selected.</option>
													<option value="" disabled>Select one of your notebooks below to add it to or select none.</option>
													<option value="" disabled></option>
												<?php } else { ?>
													<option value="<?php echo $rws2[8]; ?>" selected>current notebook: <?php echo $rws2[9].' ('.strtolower($rws2[10]).')'; ?></option>
													<option value="" disabled>Select one of your notebooks below to change it to or select none.</option>
													<option value="" disabled></option>
												<?php } ?>
													<?php include '_inc/dbconn.php';
														$sql3="SELECT * FROM UNotesDAT.notebook".$account_id;
														$result3=  mysql_query($sql3) or die(mysql_error());
														
														while($rws3=  mysql_fetch_array($result3)){
															// displaying notebooks
															echo "<option value='".$rws3[0]."'>".$rws3[1]." (".strtolower($rws3[2]).")</option>";
														} 
													?>
													<option value="">None</option>
											</select>
										</div>
									</div>
									<small class="form-text">Note content</small>
									<textarea class="form-control" name="note_alter_content" rows="10"><?php echo $rws2[3]; ?></textarea>
									<small class="form-text"><input type="checkbox" name="note_alter_bookmark" value="1"  <?php if ($rws2[7] == "1"){ echo "checked";} ?>> Bookmark Note (This will pin your note at the top of the notes page.)</small><br>
									<div class="text-right">
										<a href="notes" class="btn btn-secondary">Discard</a>
										<a href="#" class="btn btn-danger" role="button" data-toggle="modal" data-target="#deletenoteModal" aria-haspopup="true" aria-expanded="false"><i class="fas fa-trash-alt"></i> Delete note</a>
										<button type="submit" class="btn btn-success" name="note_alter"><i class="fas fa-save"></i> Save edited note</button>
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
	  
	  <!-- Delete note Modal-->
		<div class="modal fade" id="deletenoteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle"></i> Are you sure you want to delete this note?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
			  <div class="modal-body">This note will be deleted permanently and you can't recover it in the future.
			  Please check if it's the right one, because it may lead to <b>huge problems</b> if you delete the wrong note!</div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<input class="btn btn-danger" type="submit" name="note_delete" value="I am sure, delete it!" />
				</form>
			  </div>
			</div>
		  </div>
		</div>

    <?php include 'afooter.php' ?>
	
<?php	
	} elseif (isset($_REQUEST['note_alter'])){ // Update note request
		
		$alternoteid= $_POST['note_id'];
		$alter_title=  mysql_real_escape_string($_REQUEST['note_alter_title']);
		$alter_notebook=  mysql_real_escape_string($_REQUEST['note_alter_notebook']);
		$alter_content=  mysql_real_escape_string($_REQUEST['note_alter_content']);
		$lastdate = date("Y-m-d H:i:s");

		// setting bookmark variable
		if ($_POST['note_alter_bookmark'] == "1"){
			$alter_bookmark = "1";
		} else {
			$alter_bookmark = "0";
		}
		
		$sql="UPDATE UNotesDAT.notes".$account_id." SET title='$alter_title', notebook='$alter_notebook', note='$alter_content', lastdate='$lastdate', favorite='$alter_bookmark' WHERE id='$alternoteid'";
		mysql_query($sql) or die(mysql_error());
		header('location:notes?success=3');
		
	} else {
		header("location:notes?error=1");
	}
?>