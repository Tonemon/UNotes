<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
?>
<?php
	include '_inc/dbconn.php';
	$account_id=$_SESSION['user_id'];
	$account_name=$_SESSION['name'];

	if (isset($_REQUEST['add_user'])){ // Create user request
		// variables from user information
		$new_name=  mysql_real_escape_string($_REQUEST['newuser_name']);
		$new_username=  mysql_real_escape_string($_REQUEST['newuser_username']);
		$new_gender=  mysql_real_escape_string($_REQUEST['newuser_gender']);
		$new_dob=  mysql_real_escape_string($_REQUEST['newuser_dob']);
		$new_account=  mysql_real_escape_string($_REQUEST['newuser_account']);
		$new_address=  mysql_real_escape_string($_REQUEST['newuser_address']);
		$new_mobile=  mysql_real_escape_string($_REQUEST['newuser_mobile']);
		$new_email= mysql_real_escape_string($_REQUEST['newuser_email']);
		$new_date= date("Y-m-d H:i:s");
		
		//salting of password as encryption
		$salt="@3e6jQsK&na*&#3j";
		$new_password= sha1($_REQUEST['newuser_pwd'].$salt);
		
		// insert new user to table 'users'
		if ($new_account == "premium" OR $new_account == "admin"){ // set 'waspremium' to 1 if premium
			$sql="INSERT into UNotesMAIN.users values('','$new_name','$new_gender','$new_dob','$new_account','$new_address','$new_mobile','$new_email','$new_password','','ACTIVE','$new_username','offline','1')";
			mysql_query($sql) or die(header('location:admin?new&error=2'));
		} else {
			$sql="INSERT into UNotesMAIN.users values('','$new_name','$new_gender','$new_dob','$new_account','$new_address','$new_mobile','$new_email','$new_password','','ACTIVE','$new_username','offline','0')";
			mysql_query($sql) or die(header('location:admin?new&error=2'));
		}
		
		// Getting userid of the new user and creating two tables: notes.#id# and notebook.#id# 
		$sql2="SELECT * FROM UNotesMAIN.users WHERE name='$new_name'";
		$result2=mysql_query($sql2) or die(mysql_error());
		$rws2=  mysql_fetch_array($result2);

		$newuser_id=$rws2[0];
		
		$sql3="CREATE TABLE UNotesDAT.notes".$newuser_id." (id int(5) AUTO_INCREMENT, user varchar(255), title varchar(255), note longtext, date datetime, lastdate datetime, notebook int(10), favorite int(1), PRIMARY KEY (id))";
		mysql_query($sql3) or die(mysql_error()); // table notes.#id# created

		$sql4="CREATE TABLE UNotesDAT.notebook".$newuser_id." (notebook_id int(10) AUTO_INCREMENT, name varchar(20), color varchar(10), PRIMARY KEY (notebook_id))";
		mysql_query($sql4) or die("Error while creating table 'notebook'."); // table notebook.#id# created

		// inserting a dummy note and notebook with earlier info in user's table: notes.#id# and notebook.#id#
		$dummy_title="Welcome to your first note!";
		$dummy_content="This is your first note. We also created a new notebook for you called: information and tagged it with a blue color.
We are really happy to see you using UNotes. Thats why we think its important to keep up with future updates.
With UNotes you get your own notes and notebooks and it will always be free! With UNotes Premium you get a more options, like
tags, sharing and more. We are currently depending on our users and every premium subscription will support us. For more
information goto http://unotes.me/premium. Thanks!

You can go ahead and delete this note and/or the notebook if you dont need it anymore.";
		$dummy_notebook_title="info";
		$dummy_notebook_color="LIGHTBLUE";
		
		$sql5="INSERT into UNotesDAt.notes".$newuser_id." values('1','$new_name','$dummy_title','$dummy_content','$new_date','$new_date','1','0')";
		mysql_query($sql5) or die("Error while creating dummy note.");
		$sql6="INSERT into UNotesDAT.notebook".$newuser_id." values('1','$dummy_notebook_title','$dummy_notebook_color')";
		mysql_query($sql6) or die("Error while creating dummy notebook.");
		header('location:admin?all&success=1');
		
	} elseif (isset($_REQUEST['delete_user'])){ // Delete user request
		$delete_id= $_POST['user_id'];
		$delete_reason= $_POST['delete_reason'];

		if ($delete_id != "1"){ // if id is not the id of the owner
			// getting more user information
			$delete_info="SELECT * FROM UNotesMAIN.users WHERE id='$delete_id'";
        	$delete_result=  mysql_query($delete_info) or die("Error while getting more information.");
        	$del=  mysql_fetch_array($delete_result);
		
			// delete user tables: notes.#id# & notebook.#id#
			$sql_delete2="DROP TABLE UNotesDAT.notes$delete_id";
        	mysql_query($sql_delete2) or die("Error deleting users 'notes' table.");
			$sql_delete3="DROP TABLE UNotesDAT.notebook$delete_id";
        	mysql_query($sql_delete3) or die("Error deleting users 'notebook' table.");

        	// inserting into 'usersclosed' & deleting from 'users' table
        	$deletesql_1="INSERT into UNotesMAIN.usersclosed values('$delete_id','$del[1]','$del[11]','$del[4]','$del[6]','$del[7]','deleted','$delete_reason')";
			mysql_query($deletesql_1) or die("Error while inserting into 'usersclosed' table.");
        	$deletesql_2="DELETE FROM UNotesMAIN.users WHERE id='$delete_id'";
        	mysql_query($deletesql_2) or die("Error while deleting user from 'users' table.");
        	header('location:admin?removed&success=3');

		} else { // delete id == id of the owner
			header('location:admin?all&error=1');
		}
	} elseif (isset($_REQUEST['delete_record'])){ // Delete user record from deleted user page
		$record_id= $_POST['record_id'];
		
		if ($record_id == ""){
			header('location:admin?all&error=1');
		} else { // delete user from users table
			$sql_delete1="DELETE FROM UNotesMAIN.usersclosed WHERE id='$record_id'";
        	mysql_query($sql_delete1) or die("Error deleting user from 'usersclosed' table.");
			header('location:admin?removed&success=6');
		}
		
	} elseif (isset($_REQUEST['edit_user'])){ // View note request
		$userid= $_POST['user_id'];
		$editsql="SELECT * FROM UNotesMAIN.users WHERE id='$userid'";
		$editresult=  mysql_query($editsql) or die(mysql_error());
		$editrws=  mysql_fetch_array($editresult);
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

    <!-- Script to hide/show password fields when editing users-->
    <script type="text/javascript">
				function showPwd() {
					if($('$radioPwdYes').is(":checked"))   
						$(".showPwd").show();
					else
						$(".showPwd").hide();
				}
		</script>
	
	<title>Editing user: <?php echo $editrws[1]; ?> | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">

        <?php if ($acc_type == "admin"){ // show this when user is admin ?>
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
							  Editing User: <i><?php echo $editrws[1]; ?></i>. This is a <b><?php echo $editrws[4]; ?></b> user.</div>
							</a>
						</div>
						<div id="collapse2" class="panel-collapse in">
						  <div class="panel-body">
							  <div class="card-body">
								<form action="admin-edit" method="POST">	
									  <div class="row">
										<div class="col-xl-6 form-group">
											<input type="hidden" name="user_id" value="<?php echo $userid;?>"/>
											<small id="fullnameHelp" class="form-text">Full Name</small>
											<input type="text" class="form-control" name="user_edit_name" value="<?php echo $editrws[1]; ?>">
											<small id="usernameHelp" class="form-text">Username</small>
											<input type="text" class="form-control" name="user_edit_username" value="<?php echo $editrws[11]; ?>">
											<small id="emailHelp" class="form-text">Email address</small>
											<input type="email" class="form-control" name="user_edit_email" value="<?php echo $editrws[7]; ?>">
												<small id="passwordHelp" class="form-text">New Password</small>
												<input type="password" class="form-control" name="user_edit_password" value="" placeholder="Use ONLY when changing password. Do not enter old password.">
												<small id="password2Help" class="form-text">Re-enter Password</small>
												<input type="password" class="form-control" name="user_edit_password2" value="" placeholder="Use ONLY when changing password.">
										</div>
										<div class="col-xl-6 form-group">
											<small id="typeHelp" class="form-text">Account status</small>
											<select class="form-control" name="user_edit_status" required="required">
													<option value="" disabled>If account status is set to 'disabled', the user won't be able to login and will receive a message.</option>
													<option value="ACTIVE" <?php if ($editrws[10]=="ACTIVE"){ echo "selected"; } ?>>Active</option>
													<option value="DISABLED" <?php if ($editrws[10]=="DISABLED"){ echo "selected"; } ?>>Disabled</option>
											</select>
											<small id="typeHelp" class="form-text">Account type</small>
											<select class="form-control" name="user_edit_type" required="required">
													<option value="normal" <?php if ($editrws[4]=="normal"){ echo "selected"; } ?>>Normal User</option>
													<option value="premium" <?php if ($editrws[4]=="premium"){ echo "selected"; } ?>>Premium User</option>
													<?php if ($account_id == "1"){ ?>
													<option value="" disabled></option>
													<option value="" disabled>Watch out who you give this permission to! A normal user could edit confidential information!</option>
													<option value="admin" <?php if ($editrws[4]=="admin"){ echo "selected"; } ?>>Administrator</option>
													<?php } ?>
											</select>
											<small id="addressHelp" class="form-text">Address</small>
											<input type="text" class="form-control" name="user_edit_address" value="<?php echo $editrws[5]; ?>">
											<small id="mobileHelp" class="form-text">Mobile phone number</small>
											<input type="text" class="form-control" name="user_edit_mobile" value="<?php echo $editrws[6]; ?>">
											<small id="dobHelp" class="form-text">Date Of Birth (DOB)</small>
											<input type="date" class="form-control" name="user_edit_dob" value="<?php echo $editrws[3]; ?>">
											<small id="genderHelp" class="form-text">Gender</small>
											<div class="form-check">
											  <input class="form-check-input" type="radio" name="user_edit_gender" id="radioMale" value="M" <?php if ($editrws[2]=="M") { echo "checked"; };?>>
											  <label class="form-check-label" for="radioMale">Male</label>
											</div>
											<div class="form-check">
											  <input class="form-check-input" type="radio" name="user_edit_gender" id="radioFemale" value="F" <?php if ($editrws[2]=="F") { echo "checked"; };?>>
											  <label class="form-check-label" for="radioFemal">Female</label>
											</div>
										</div>
									</div>
									<div class="text-right">
										<a href="admin?all" class="btn btn-secondary">Discard</a>
										<?php if ($userid != "1"){ // don't show delete button when owner ?>
											<a href="#" class="btn btn-danger" role="button" data-toggle="modal" data-target="#deleteuserModal" aria-haspopup="true" aria-expanded="false"><i class="fas fa-trash-alt"></i> Delete user</a>
										<?php } ?>
										<button type="submit" class="btn btn-success" name="user_alter"><i class="fas fa-save"></i> Save user</button>
									</div>
							  </div>
						  </div>
						</div>
					  </div>
				  </div> 
			  </div>
			</div>
		  </div> <!-- /.row -->

		<?php 
		} else { // non-admins can't access this page
			header('location:notes?error=2');
		} 

		?>
      </div><!-- /.container-fluid -->
	  
	  <!-- Delete note Modal-->
		<div class="modal fade" id="deleteuserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle"></i> Are you sure you want to delete this user?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
			  <div class="modal-body">This user will be deleted permanently and you can't recover it in the future.
			  Please check if it's the right one, because it may lead to <b>huge problems</b> if you delete the wrong user!</div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger" name="delete_user"><i class="fas fa-trash-alt"></i> Delete this user!</button>
				</form>
			  </div>
			</div>
		  </div>
		</div>

    <?php include 'afooter.php' ?>
	
<?php	
	} elseif (isset($_REQUEST['user_alter'])){ // Update user request
		$alterid= $_POST['user_id'];
		
		$alter_name=  mysql_real_escape_string($_REQUEST['user_edit_name']);
		$alter_username=  mysql_real_escape_string($_REQUEST['user_edit_username']);
		$alter_email=  mysql_real_escape_string($_REQUEST['user_edit_email']);
		$alter_status=  mysql_real_escape_string($_REQUEST['user_edit_status']);
		$alter_gender=  mysql_real_escape_string($_REQUEST['user_edit_gender']);
		$alter_type=  mysql_real_escape_string($_REQUEST['user_edit_type']);
		$alter_address=  mysql_real_escape_string($_REQUEST['user_edit_address']);
		$alter_mobile=  mysql_real_escape_string($_REQUEST['user_edit_mobile']);
		$alter_dob=  mysql_real_escape_string($_REQUEST['user_edit_dob']);
		
		$alter_pass=  mysql_real_escape_string($_REQUEST['user_edit_password']);
		$alter_pass2=  mysql_real_escape_string($_REQUEST['user_edit_password2']);

		if ($alter_pass == ""){ // which means no new password provided
			if ($alter_type == "premium" OR $alter_type == "admin"){ // account set to premium/admin
				$updatesql="UPDATE UNotesMAIN.users SET name='$alter_name', gender='$alter_gender', dob='$alter_dob', account='$alter_type', address='$alter_address', mobile='$alter_mobile', email='$alter_email', accstatus='$alter_status', username='$alter_username', waspremium='1' WHERE id='$alterid'";
				mysql_query($updatesql) or die(mysql_error());
			} else { // account set to normal
				$updatesql="UPDATE UNotesMAIN.users SET name='$alter_name', gender='$alter_gender', dob='$alter_dob', account='$alter_type', address='$alter_address', mobile='$alter_mobile', email='$alter_email', accstatus='$alter_status', username='$alter_username' WHERE id='$alterid'";
				mysql_query($updatesql) or die(mysql_error());
			}
			header('location:admin?all&success=2');
		} else { // new password provided
			if ($alter_pass == $alter_pass2){ // the two passwords match
				$salt="@3e6jQsK&na*&#3j";
				$alter_password= sha1($_REQUEST['user_edit_password'].$salt); // salting password
				
				if ($alter_type == "premium" OR $alter_type == "admin"){ // account set to premium/admin
					$updatesql="UPDATE UNotesMAIN.users SET name='$alter_name', gender='$alter_gender', dob='$alter_dob', account='$alter_type', address='$alter_address', mobile='$alter_mobile', email='$alter_email', password='$alter_password', accstatus='$alter_status', username='$alter_username', waspremium='1' WHERE id='$alterid'";
					mysql_query($updatesql) or die(mysql_error());
				} else { // account set to normal
					$updatesql="UPDATE UNotesMAIN.users SET name='$alter_name', gender='$alter_gender', dob='$alter_dob', account='$alter_type', address='$alter_address', mobile='$alter_mobile', email='$alter_email', password='$alter_password', accstatus='$alter_status', username='$alter_username' WHERE id='$alterid'";
					mysql_query($updatesql) or die(mysql_error());
				}
				header('location:admin?all&success=2');
			} else { // the two passwords do not match
				header('location:admin?all&error=3');
			}
		}

	} elseif (isset($_REQUEST['new_user_approve'])){ // Approve new user request
		$approve_id = $_POST['approve_id'];

		$app_sql="SELECT * FROM UNotesMAIN.newusers WHERE id=$approve_id";
		$app_result=  mysql_query($app_sql) or die(mysql_error());
		$apprws=  mysql_fetch_array($app_result);

		$app_name=  $apprws[1];
		$app_username= $apprws[2];
		$app_email= $apprws[3];
		$app_gender=  $apprws[4];
		$app_dob=  $apprws[5];
		$app_type=  $apprws[6];
		$app_address=  $apprws[7];
		$app_mobile=  $apprws[8];
		
		// Salting of password for encryption
		$salt="@3e6jQsK&na*&#3j";
		$app_password= sha1($apprws[9].$salt);

		// Insert new user to table 'users'
		if ($app_type == "premium" OR $app_type == "admin"){ // set 'waspremium' to 1 if premium
			$app_sql2="INSERT into UNotesMAIN.users values('','$app_name','$app_gender','$app_dob','$app_type','$app_address','$app_mobile','$app_email','$app_password','','ACTIVE','$app_username','offline','1')";
			mysql_query($app_sql2) or die("Error inserting user to 'users' table (waspremium = 1)");
		} else {
			$app_sql2="INSERT into UNotesMAIN.users values('','$app_name','$app_gender','$app_dob','$app_type','$app_address','$app_mobile','$app_email','$app_password','','ACTIVE','$app_username','offline','0')";
			mysql_query($app_sql2) or die("Error inserting user to 'users' table (waspremium = 0)");
		}

		// Getting userid of the new user and creating two tables: notes.#id# and notebook.#id# 
		$app_sql3="SELECT * FROM UNotesMAIN.users WHERE name='$app_name'";
		$app_result3=mysql_query($app_sql3) or die(mysql_error());
		$apprws3=  mysql_fetch_array($app_result3);
		$appuser_id=$apprws3[0];
		
		$app_sql4="CREATE TABLE UNotesDAT.notes".$appuser_id." (id int(5) AUTO_INCREMENT, user varchar(255), title varchar(255), 
			note longtext, date datetime, lastdate datetime, notebook int(10), PRIMARY KEY (id))";
		mysql_query($app_sql4) or die("Error while creating table 'notes'."); // table notes.#id# created

		$app_sql5="CREATE TABLE UNotesDAT.notebook".$appuser_id." (notebook_id int(10) AUTO_INCREMENT, name varchar(20), color varchar(10), PRIMARY KEY (notebook_id))";
		mysql_query($app_sql5) or die("Error while creating table 'notebook'."); // table notebook.#id# created

		// inserting a dummy note and notebook with earlier info in user's table: notes.#id# and notebook.#id#
		$appdummy_title="Welcome to your first note!";
		$appdummy_content="This is your first note. We also created a new notebook for you called: information and tagged it with a blue color.
We are really happy to see you using UNotes. Thats why we think its important to keep up with future updates.
With UNotes you get your own notes and notebooks and it will always be free! With UNotes Premium you get a more options, like
tags, sharing and more. We are currently depending on our users and every premium subscription will support us. For more
information goto http://unotes.me/premium. Thanks!

You can go ahead and delete this note and/or the notebook if you dont need it anymore.";
		$appdummy_notebook_title="info";
		$appdummy_notebook_color="LIGHTBLUE";
		$new_date= date("Y-m-d H:i:s");
		
		$app_sql6="INSERT INTO UNotesDAt.notes".$appuser_id." values('1','$app_name','$appdummy_title','$appdummy_content','$new_date','$new_date','1')";
		mysql_query($app_sql6) or die("Error while creating dummy note.");
		$app_sql7="INSERT INTO UNotesDAT.notebook".$appuser_id." values('1','$appdummy_notebook_title','$appdummy_notebook_color')";
		mysql_query($app_sql7) or die("Error while creating dummy notebook.");

		$app_sql10="DELETE FROM UNotesMAIN.newusers WHERE `id` = '$approve_id'";
		mysql_query($app_sql10) or die(mysql_error());
		header('location:admin?all&success=5');

	} elseif (isset($_REQUEST['new_user_delete'])){ // Delete new user request
		$approve_id = $_POST['approve_id'];

		$sql_del2="DELETE FROM UNotesMAIN.newusers WHERE `id` = '$approve_id'";
		mysql_query($sql_del2) or die(mysql_error());
		header('location:admin?new&success=4');

	} else {
		header("location:admin?all&error=1");
	}
?>