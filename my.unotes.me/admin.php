<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
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
	
	<title>Admin Panel | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">	
			<?php
				if ($_GET['success'] == "1") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> New user added. </div>";
				} elseif ($_GET['success'] == "2") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> User information changed.</div>";
				} elseif ($_GET['success'] == "3") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> User successfully deleted.</div>";
				} elseif ($_GET['success'] == "4") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> User request deleted.</div>";
				} elseif ($_GET['success'] == "5") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> User request approved.</div>";
				} elseif ($_GET['success'] == "6") {
					echo "<div class='alert alert-success alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-check'></i> User record deleted.</div>";
				} elseif ($_GET['error'] == "1") {
					echo "<div class='alert alert-warning alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
				} elseif ($_GET['error'] == "2") {
					echo "<div class='alert alert-warning alert-dismissible'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<i class='fas fa-exclamation-triangle'></i> This Email address or username already exists! Please choose another one and try again.</div>";
				} elseif ($_GET['error'] == "3") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> New passwords do not match. No information was changed.</div></div>';
				} 
			?>
		  
	<?php if ($acc_type == "admin"){ // show this when user is admin ?>
		<div class="row text-center">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<select class="form-control" data-error="Select your category." onchange="javascript:location.href = this.value;">
					<option value="" selected disabled>Select section to show below...</option>
					<?php if ($account_id == "1") { ?>
						<option value="?new">Add New User / Account Requests</option>
					<?php } else { ?>
						<option value="?new">Accept/Reject Account Requests</option>
					<?php } ?>
					<option value="?all">Existing Users</option>
					<option value="?removed">Deleted Users</option>
				</select>
			</div>
			<div class="col-md-3"></div>
		</div><br>

		<!-- Display different sections using php isset(GET) -->
		<?php if (isset($_GET['new'])) { ?>
		<!-- Add new users row -->
		  <div class="row">
		    <?php if ($account_id == "1"){ echo '<div class="col-xl-4 mb-6">'; // only owner can add accounts manually
				} else { echo '<div class="col-xl-4 mb-6" style="display: none;">'; } ?>
			  <div class="card o-hidden mb-3" id="general">
				<div class="card-header">
				  <i class="fas fa-user-plus"></i>
				  Add New User</div>
				<div class="card-body">
					<form action="admin-edit" method="POST">
						<table class="mx-3">
							<tr>
								<td>Full Name</td>
								<td><input type="text" class="form-control" name="newuser_name" required="required" /></td>
							</tr>
							<tr>
								<td>Username</td>
								<td><input type="text" class="form-control" name="newuser_username" required="required" /></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td>
									Male <input type="radio" name="newuser_gender" value="M" required="required" /> <b>or</b>
									Female <input type="radio" name="newuser_gender" value="F" />
								</td>
							</tr>
							<tr>
								<td>DOB</td>
								<td><input type="date" class="form-control" name="newuser_dob" required="required" /></td>
							</tr>
							<tr>
								<td>Account type &nbsp;</td>
								<td>
									<select class="form-control" name="newuser_account" required="required" >
										<option value="normal">Normal User</option>
										<option value="premium">Premium User</option>
										<?php if ($account_id == "1"){ ?>
											<option value="" disabled></option>
											<option value="admin">Administrator</option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Address</td>
								<td><input class="form-control" name="newuser_address" required="required" /></td>
							</tr>
							<tr>
								<td>Mobile</td>
								<td><input type="text" class="form-control" name="newuser_mobile" required="required" /></td>
							</tr>

							<tr>
								<td>Email</td>
								<td><input type="email" class="form-control" name="newuser_email" required="required" /></td>
							</tr>
							<tr>
								<td>Password</td>
								<td><input type="password" class="form-control" name="newuser_pwd" required="required" /></td>
							</tr>
						</table><br>
						<button type="submit" class="btn btn-success" name="add_user"><i class="fas fa-user-plus"></i> Add new user</button>
					</form>
				</div>
			  </div>
			</div>
		<!-- Approve new users row -->
			<?php if ($account_id != "1"){ echo '<div class="col-xl-12 mb-6">'; // makes column bigger if not owner
			} else { echo '<div class="col-xl-8 mb-6">'; } ?>
			  <div class="card o-hidden mb-3" id="transfer">
				<div class="card-header">
				  <i class="fas fa-user-edit"></i>
				  Approve Account Requests</div>
				<div class="card-body">
					<form action="admin-edit" method="POST">
					<div class="table-responsive">
					<small id="emailHelp" class="form-text">The account requests below are coming from the <a href="http://unotes.me/register" target="_blank">unotes.me/register</a> page.</small><br>
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<?php
							include '_inc/dbconn.php';
							$sql5="SELECT * FROM UNotesMAIN.newusers";
							$result5=  mysql_query($sql5) or die(mysql_error());

							$sql_min5="SELECT MIN(id) from UNotesMAIN.users";
							$result_min5=  mysql_query($sql_min5);
							$rws_min5=  mysql_fetch_array($result_min5);
						?>
						<thead>
						<tr>
							<th></th>
							<th>Name (email)</th>
							<th>Username</th>
							<th>Account type</th>
							<th>Address</th>
							<th>Mobile</th>
							<th>DOB</th>
							<th>Gender</th>
						</tr>
						</thead>
						<tbody>
						<?php
                     while($rws5=  mysql_fetch_array($result5)){
                        echo "<tr><td><input type='radio' name='approve_id' value=".$rws5[0];
                        if($rws5[0]==$rws_min5[0]) echo' checked';
                        echo " /></td>";
                        
                        echo "<td><b>".$rws5[1]."</b> (".$rws5[3].")</td>";
								echo "<td>".$rws5[2]."</td>";
								echo "<td>".$rws5[6]."</td>";
								echo "<td>".$rws5[7]."</td>";
								echo "<td>".$rws5[8]."</td>";
								echo "<td>".$rws5[5]."</td>";
                        echo "<td>".$rws5[4]."</td>";
                        echo "</tr>";
                     }
                  ?>
					  </tbody>
					</table>
					</div><br>
					<button type="submit" class="btn btn-success" name="new_user_approve"><i class="fas fa-check"></i> Approve User Request</button>
					<button type="submit" class="btn btn-danger" name="new_user_delete"><i class="fas fa-trash-alt"></i> Delete User Request</button>
				  </form>
				</div>
			  </div>
		  </div> <!-- /.row -->

		<?php } elseif (isset($_GET['all'])) { ?>
		<!-- Edit existing users row -->
		  <div class="row">
			<div class="col-xl-12 mb-6">
			  <div class="card o-hidden mb-3" id="transfer">
				<div class="card-header">
				  <i class="fas fa-user-edit"></i>
				  Display/Edit Customer</div>
				<div class="card-body">
					<form action="admin-edit" method="POST">
					<div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<?php
							include '_inc/dbconn.php';
							if ($account_id == "1"){ // check if owner (will allow to edit all users)
								$query2="SELECT * FROM UNotesMAIN.users";
								$res2=  mysql_query($query2) or die(mysql_error());
							} else { // if admin, but not an owner, show only all normal/premium users
								$query2="SELECT * FROM UNotesMAIN.users WHERE account='normal' OR account='premium'";
								$res2=  mysql_query($query2) or die(mysql_error());
							}
							
							$sql_min="SELECT MIN(id) from UNotesMAIN.users";
							$result_min=  mysql_query($sql_min);
							$rws2=  mysql_fetch_array($result_min);
						?>
						<thead>
						<tr>
							<th></th>
							<th>id</th>
							<th>name</th>
							<th>username</th>
							<th>email address</th>
							<th>last login</th>
							<th>account type</th>
							<th>account status</th>
						</tr>
						</thead>
						<tbody>
						<?php
                  	while($rws=  mysql_fetch_array($res2)){
                        echo "<tr><td><input type='radio' name='user_id' value=".$rws[0];
                        if($rws[0]==$rws2[0]){ echo ' checked'; }
                        echo " /></td>";
                        echo "<td>".$rws[0]."</td>";
                        echo "<td>".$rws[1]."</td>";
								echo "<td>".$rws[11]."</td>";
								echo "<td>".$rws[7]."</td>";
								echo "<td>".$rws[9]."</td>";
								echo "<td>".$rws[4]."</td>";
                        echo "<td>".$rws[10]."</td>";
                        echo "</tr>";
                     }
                  ?>
					  </tbody>
					</table>
					</div><br>
					<button type="submit" class="btn btn-warning" name="edit_user"><i class="fas fa-user-edit"></i> Edit user</button>
					<a href="#" class="btn btn-danger" id="pagesDropdown" data-toggle="modal" data-target="#deleteModal" aria-haspopup="true"><i class="fas fa-trash-alt"></i> Delete user</a>
				</div>
			  </div>
			</div>
		  </div> <!-- /.row -->
		  
		  <!-- Delete user Modal-->
		<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle"></i> Permanently delete this user?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
			 <div class="modal-body">This user will be deleted permanently and you can't recover it in the future.
			  Please check if it's the right one, because it may lead to <b>huge problems</b> if you delete the wrong user!<br><br>
			  <b>Remember</b>: If you want to warn a user first, set the <b>account status</b> to <b>disabled</b> by editing the account. After 2 warnings the account should be deleted.<br>
			  	<small id="typeHelp" class="form-text">Reason</small>
					<select class="form-control" name="delete_reason" required="required">
						<option value="## inactive ##" selected>Inactive for a long period (+2 years)</option>
						<option value="## unusual ##">Unusual or fraudulent activity</option>
						<option value="## exploiting ##">User exploiting (premium) features</option>
						<option value="## other ##">Other</option>
					</select>
			 </div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger" name="delete_user"><i class="fas fa-trash-alt"></i> Delete this user!</button>
			  </div>
			 </form>
			</div>
		  </div>
		</div>

		<?php } elseif (isset($_GET['removed'])) { ?>
		<!-- Delete users section -->
		<div class="row">
			<div class="col-xl-12 mb-6">
			  <div class="card o-hidden mb-3" id="transfer">
				<div class="card-header">
				  <i class="fas fa-user-minus"></i>
				  Deleted Users</div>
				<div class="card-body">
				  <form action="admin-edit" method="POST">
					<div class="table-responsive">
					<small class="form-text">The users on this this page are either removed or they closed their account. The reason can be found on the right.<br>NOTICE: These accounts <b>cannot</b> be recovered! This page allows you <b>only</b> to <b>keep track of removed accounts</b> and can be used when someone contacts us about their deleted account.</small><br>
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
						<?php
							include '_inc/dbconn.php';
							$query2="SELECT * FROM UNotesMAIN.usersclosed";
							$res2=  mysql_query($query2) or die(mysql_error());
							
							$sql_min="SELECT MIN(id) from UNotesMAIN.usersclosed";
							$result_min=  mysql_query($sql_min);
							$rws2=  mysql_fetch_array($result_min);
						?>
						<thead>
						<tr>
							<th></th>
							<th>name (id)</th>
							<th>Type</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>How</th>
							<th>Reason</th>
						</tr>
						</thead>
						<tbody>
						<?php
                        while($rws=  mysql_fetch_array($res2)){
                           echo "<tr><td><input type='radio' name='record_id' value=".$rws[0];
                           echo " /></td>";
                           echo "<td>".$rws[1]." (<b>".$rws[0]."</b>)</td>";
									echo "<td>".$rws[3]."</td>";
									echo "<td>".$rws[4]."</td>";
									echo "<td>".$rws[5]."</td>";
									echo "<td>".$rws[6]."</td>";
									if ($rws[7] == "## inactive ##"){
										echo "<td><i>This user has been inactive for too long (+2 years).</i></td>";
									} elseif ($rws[7] == "## unusual ##"){
										echo "<td><i>This account showed unusual/fraudulent activity.</i></td>";
									} elseif ($rws[7] == "## exploiting ##"){
										echo "<td><i>This account was used for exploiting purposes.</i></td>";
									} elseif ($rws[7] == "## other ##"){
										echo "<td><i>This account is deleted because of other (unlisted) reasons.</i></td>";
									} else {
										echo "<td>".$rws[7]."</td>";
									}
                      		echo "</tr>";
                        }
                        ?>
					  </tbody>
					</table>
					</div><br>
					<button type="submit" class="btn btn-danger" name="delete_record"><i class="fas fa-trash-alt"></i> Delete selected record</button>
				  </form>
				</div>
			  </div>
			</div>
		  </div> <!-- /.row -->

		<?php } ?> 
      </div><!-- /.container-fluid -->
	  
	<?php 
		} else { // non-admins can't access this page
			header('location:notes?error=2');
		} 

	?>
   <?php include 'afooter.php' ?>