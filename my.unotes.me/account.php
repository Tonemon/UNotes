<?php 
session_start();
        
if(!isset($_SESSION['user_login'])) 
    header('location:index');   
?>
<?php
	include '_inc/dbconn.php';
	
	if (isset($_REQUEST['change_password'])){ // password change request
		include '_inc/dbconn.php';
		$pwd_id = mysql_real_escape_string($_REQUEST['password_id']);
		
		// select current password from users table
		$query="SELECT password FROM UNotesMAIN.users WHERE id='$pwd_id'";
        $result2=  mysql_query($query) or die(mysql_error());
        $rws2=  mysql_fetch_array($result2);
					
		$salt="@3e6jQsK&na*&#3j";
		$old= sha1(mysql_real_escape_string($_REQUEST['old_password']).$salt); // old password
		$new= sha1(mysql_real_escape_string($_REQUEST['new_password']).$salt); // new password
		$again= sha1(mysql_real_escape_string($_REQUEST['again_password']).$salt); // new password again
		
		if ($rws2[0]==$old && $new == $again){ // everything matches
			$sql9="UPDATE UNotesMAIN.users SET password='$new' WHERE id='$pwd_id'";
			mysql_query($sql9) or die(mysql_error()); // set status to offline
			$setoffline="UPDATE UNotesMAIN.users SET status='offline' WHERE id='$pwd_id'";
			mysql_query($setoffline) or die("Could not set your status to offline.");

			session_destroy(); // destroying session to let the user login again using new password
			header('location:index?success=2');
		} elseif ($new != $again){ // two new submitted passwords don't match
			header('location:account?c_password&error=3');
		} else { // the old username/password doesn't match
			header('location:account?c_password&error=2');
		}
	} elseif (isset($_REQUEST['change_username'])){ // username change request
		include '_inc/dbconn.php';
		
		$username_id = mysql_real_escape_string($_REQUEST['username_id']);
		$query="SELECT username FROM UNotesMAIN.users WHERE id='$username_id'";
        $result2=  mysql_query($query) or die(mysql_error());
        $rws2=  mysql_fetch_array($result2);
					
		$old= mysql_real_escape_string($_REQUEST['old_username']); // old username (check for match)
		$new= mysql_real_escape_string($_REQUEST['new_username']); // new username

		$query2="SELECT username FROM UNotesMAIN.users WHERE username='$new'"; // to check if username exists
        $result3=  mysql_query($query2) or die(mysql_error());
        $rws3=  mysql_fetch_array($result3);

        // let user update his username when password matches
        $salt="@3e6jQsK&na*&#3j";
		$pwd_check= sha1(mysql_real_escape_string($_REQUEST['ed_pwd']).$salt); // old password

        $query4="SELECT password FROM UNotesMAIN.users WHERE id='$username_id'";
        $result4=  mysql_query($query4) or die(mysql_error());
        $rws4=  mysql_fetch_array($result4);
		
		if ($rws2[0]==$old && $rws3[0] == "" && $rws4[0] == $pwd_check){ // everything matches, update username
			$sql9="UPDATE UNotesMAIN.users SET username='$new' WHERE id='$username_id'";
			mysql_query($sql9) or die(mysql_error());
			
			session_destroy(); // destroying session to let the user login again using new password
			header('location:index?success=2');
		} elseif ($rws2[0] != $old ){ // old username does not match database
			header('location:account?c_username&error=2');
		} elseif ($rws4[0] != $pwd_check) {
			header('location:account?c_username&error=5');
		} else { // username already exists
			header('location:account?c_username&error=1');
		}
	} elseif (isset($_REQUEST['change_other'])){ // other information change request
		include '_inc/dbconn.php';

		$salt="@3e6jQsK&na*&#3j";
		$pwd_check= sha1(mysql_real_escape_string($_REQUEST['ed_pwd']).$salt); // old password
		
		$edit_id = mysql_real_escape_string($_REQUEST['password_id']);
		$edit_dob = $_POST['ed_dob'];
		$edit_address = $_POST['ed_address'];
		$edit_mobile = $_POST['ed_mobile'];
		$edit_gender = $_POST['ed_gender'];

		$query3="SELECT password FROM UNotesMAIN.users WHERE id='$edit_id'";
        $result3=  mysql_query($query3) or die(mysql_error());
        $rws3=  mysql_fetch_array($result3);
		
		if ($rws3[0] == $pwd_check){ // submitted password matches
			$sql9="UPDATE UNotesMAIN.users SET dob='$edit_dob', address='$edit_address', mobile='$edit_mobile', gender='$edit_gender' WHERE id='$edit_id'";
			mysql_query($sql9) or die(mysql_error());
			header('location:account?success=3');
		} else { // password does not match
			header('location:account?c_other&error=5');
		}
	} elseif (isset($_REQUEST['user_delete'])){
		include '_inc/dbconn.php';
		include 'aheader.php'; // for the information needed

		$duserid= mysql_real_escape_string($_REQUEST['deleteuser_id']); // user id
		$duser_name= $account_name; // user official names
		$dusername= $acc_username; // username
		$duser_waspremium= $waspremium; // if user is/was premium
		$duser_acctype= $acc_type; // account type (normal/premium)
		$duser_mobile= $mobile; // phone number
		$duser_email= $email; // email adress
		$duser_reason= "closed";
		$reason= mysql_real_escape_string($_REQUEST['note_content']); // reason

		// insert into table usersclosed
        $sql5="INSERT into UNotesMAIN.usersclosed values('$duserid','$duser_name','$dusername','$duser_acctype','$duser_mobile','$duser_email','closed','$reason')";
		mysql_query($sql5) or die("Error adding user to 'userclosed' table.");

		// delete user tables: notes.#id# & notebook.#id#
		$sql_delete2="DROP TABLE UNotesDAT.notes$duserid";
        mysql_query($sql_delete2) or die("Error deleting users 'notes' table.");
		$sql_delete3="DROP TABLE UNotesDAT.notebook$duserid";
        mysql_query($sql_delete3) or die("Error deleting users 'notebooks' table.");
        
        // delete user from users table
        $sql_delete1="DELETE FROM UNotesMAIN.users WHERE id='$duserid'";
        mysql_query($sql_delete1) or die("Error deleting user from 'users' table.");

		session_destroy(); // destroying session and display message 'account deleted'
		header('location:index?notice=1');
	} elseif (isset($_REQUEST['submit_question'])){
		include '_inc/dbconn.php';
		
		// getting variables to store in table
		$name=  mysql_real_escape_string($_REQUEST['q_name']);
		$email= mysql_real_escape_string($_REQUEST['q_email']);
		$type=  mysql_real_escape_string($_REQUEST['q_category']);
		$message= mysql_real_escape_string($_REQUEST['q_content']);

		// variables to set on the go
		$status= "TO REVIEW";
		$from= "User";
		$date = date('Y-m-d h:i:s');

		// insert question to table 'customer'
		$sql="INSERT into UNotesMAIN.questions values('','$name','$email','$type','$message','$status','','$from','$date')";
		mysql_query($sql) or die(header('location:account?error=4'));
		header('location:account?success=3');
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
	
	<title>Your Account/Settings | UNotes </title>
  </head>
  <body id="page-top">
    <?php include 'aheader.php' ?>

      <div id="content-wrapper">
        <div class="container-fluid">
		  <div class="row">
		  <?php
				if ($_GET['success'] == "1") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-check"></i> Username successfully changed.</div></div>';
				} elseif ($_GET['success'] == "2") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-check"></i> Password successfully changed.</div></div>';
				} elseif ($_GET['success'] == "3") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-check"></i> Other information successfully changed. </div></div>';
				} elseif ($_GET['success'] == "4") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-check"></i> Question successfully sent. Your question will be reviewed as soon as possible.</div></div>';
				} elseif ($_GET['error'] == "1") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> Username already exists. Please try another one.</div></div>';
				} elseif ($_GET['error'] == "2") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> Old username/password does not match the database. Please try again.</div></div>';
				} elseif ($_GET['error'] == "3") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> The two new passwords do not match. Please try again.</div></div>';
				} elseif ($_GET['error'] == "4") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> Your question could not be submitted. Please try again later.</div></div>';
				} elseif ($_GET['error'] == "5") {
					echo '<div class="col-xl-12 mb-6"><div class="alert alert-warning alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<i class="fas fa-exclamation-triangle"></i> Submitted password does not match the database. Please try again.</div></div>';
				}
			?>
			<div class="col-xl-4 mb-6">
			  <div class="card o-hidden mb-3" id="general">
				<div class="card-header">
				  <i class="fas fa-info-circle"></i>
				  General Information</div>
				<div class="card-body">
					<p>
						<?php
							if ($status == "online"){ // setting colors for account status badges
								$badgecolor = "success";
								$badgetext = "Online";
							}
						?>
						<h2> <i class="fas fa-user-circle fa-lg"></i> <i><?php echo $acc_username; ?></i> (<?php echo $account_name; ?>) <span class='badge badge-<?php echo $badgecolor ?>'><?php echo $badgetext ?></span></h2>
						<span>Your Last login was on <b><?php echo $last_login;?></b>,</span><br>
						<span class="heading">Your account type is <b><?php echo $acc_type;?></b>. Your email address is <b><?php echo $email;?></b>.</span><br><br>
						<span class="heading">Your address is <b><?php echo $address;?></b> and your phone number is <b><?php echo $mobile;?></b>. Your date of birth is <b><?php echo $dob;?></b> and your gender is <b><?php if ($gender == "M"){ echo "male"; } else { echo "female"; } ?></b>.</span>
						
						<?php if ($acc_type == "premium"){ ?>
								<br><br><i class="fas fa-check-circle"></i> <i>Thank you for being a <i class="far fa-gem"></i> <b>premium member</b>!</i>
						<?php } elseif ($acc_type == "admin"){ ?>
								<br><br><i class="fas fa-check-circle"></i> <i>All admins can enjoy <i class="far fa-gem"></i> <b>Unotes Premium</b>!</i>
						<?php } else { ?>
								<br><br><i class="fas fa-info-circle"></i> <a href="#" role="button" data-toggle="modal" data-target="#premiumModal" aria-haspopup="true" aria-expanded="false"><i>Want to enjoy <i class="far fa-gem"></i> <b>UNotes Premium</b></i></a>?
						<?php }	?>
					</p>
				</div>
			  </div>
			</div>
			<?php if ($account_id != "1") { ?>
			<div class="col-xl-4 mb-6">
			  <div class="card o-hidden mb-3" id="general">
				<div class="card-header">
				  <i class="far fa-life-ring"></i>
				  Support Panel</div>
				<div class="card-body">
					<?php
						// the mysql $rws[]; array is already in the header.
						$name= $rws[1];
					?>
					<p>If you got any questions please submit the form below and we will answer it as soon as possible.</p>
					<form action="account.php" method="POST">
						<table>
							<tr>
								<td>First name:</td>
								<td><input type="hidden" name="q_name" value="<?php echo $name ?>" />
								<input type="text" class="form-control" value="<?php echo $name ?>" disabled="disabled" /></td>
							</tr>
							<tr>
								<td>Email address: &nbsp;</td>
								<td><input type="hidden" name="q_email" value="<?php echo $email ?>" />
								<input type="email" class="form-control" value="<?php echo $email ?>" disabled="disabled" /></td>
							</tr>
							<tr>
								<td>Category:</td>
								<td>
									<select name="q_category" class="form-control" required="required" data-error="Select your category.">
										<option value="" disabled selected>Select a category</option>
										<?php if ($acc_type == "admin") { echo '<option value="Personal">Change my personal information</option>'; } else { ?>
										<option value="About">About Us / UNotes Group</option>
										<option value="Personal">Change my personal information</option>
										<option value="Bug">Exploit/Bug Found</option>
										<option value="Job">Job Application</option>
										<option value="Other">Other</option>
										<?php } ?>
									</select>
								</td>
							</tr>	
						</table><br>
						<small class="form-text">Enter more information about your question below.</small>
						<textarea class="form-control" name="q_content" rows="1" placeholder="Please enter your question here" required></textarea><br>
						<button type="submit" class="btn btn-success" name="submit_question"><i class="fas fa-check"></i> Submit my Question</button>
					</form>
				</div>
			  </div>
			</div>
			<?php } if ($account_id == "1") { echo '<div class="col-xl-5 mb-6">';
			} else { echo '<div class="col-xl-4 mb-6">'; } ?>
			  <div class="card o-hidden mb-3" id="transfer">
				<div class="card-header">
				  <i class="fas fa-user-edit"></i>
				  User Account Actions</div>
				<div class="card-body">
					<select class="form-control" data-error="Select your category." onchange="javascript:location.href = this.value;">
						<option value="" disabled selected>Select an action to perform on your account..</option>
						<option value="?c_username">Change my username</option>
						<option value="?c_password">Change my password</option>
						<option value="?c_other">Change other information</option>
						<option value="?danger_area">(DANGER AREA) Delete my account</option>
					</select><br>

					<?php if (isset($_GET['c_username'])) { ?>
					<form action="account" method="POST">
						<small class="form-text">Please enter your old and new username below.</small>
						<table>
							<tr>
								<td>Old username:</td>
								<td><input type="hidden" name="username_id" value="<?php echo $account_id;?>"/>
								<input type="text" class="form-control" name="old_username" required=""/></td>
							</tr>
							<tr>
								<td>New username: &nbsp;</td>
								<td><input type="text" class="form-control" name="new_username" required=""/></td>
							</tr>
						</table><br>
						<small class="form-text">Confirm your current password below to change your personal information.</small>
						<table><tr>
								<td>Password: &nbsp;</td>
								<td><input type="hidden" name="password_id" value="<?php echo $account_id;?>"/><input type="password" class="form-control" name="ed_pwd" required /></td>
						</tr></table><br>
						<button type="submit" class="btn btn-success" name="change_username"><i class="fas fa-check"></i> Change Username</button>
					</form>

					<?php } elseif (isset($_GET['c_password'])) { ?>
					<form action="account" method="POST">
						<small class="form-text">Please enter your old password and two times your new password.</small>
						<table>
							<tr>
								<td>Old password:</td>
								<td><input type="hidden" name="password_id" value="<?php echo $account_id;?>"/>
								<input type="password" class="form-control" name="old_password" required=""/></td>
							</tr>
							<tr>
								<td>New password:</td>
								<td><input type="password" class="form-control" name="new_password" required=""/></td>
							</tr>
							<tr>
								<td>New password again: &nbsp;</td>
								<td><input type="password" class="form-control" name="again_password" required=""/></td>
							</tr>
						</table><br>
						<button type="submit" class="btn btn-success" name="change_password"><i class="fas fa-check"></i> Change Password</button>
					</form>

					<?php } elseif (isset($_GET['c_other'])) { ?>
					<form action="account" method="POST">
						<small class="form-text">Edit other personal information below. Your name and email <b>cannot</b> be changed manually at the moment. Please contact support (using the <i>'Change my personal information'</i> option on the left) to change your account name.</small><br>
						<table>
							<tr>
								<td>Dob:</td>
								<td><input type="date" class="form-control" value="<?php echo $dob ?>" name="ed_dob" required /></td>
							</tr>
							<tr>
								<td>Address:</td>
								<td><input type="text" class="form-control" value="<?php echo $address ?>" name="ed_address" required /></td>
							</tr>
							<tr>
								<td>Phone:</td>
								<td><input type="text" class="form-control" value="<?php echo $mobile ?>" name="ed_mobile" required /></td>
							</tr>
							<tr>
								<td>Gender:</td>
								<td><select class="form-control" name="ed_gender">
										<option value="M" <?php if ($gender == "M") { echo 'selected'; }?> >Male (M)</option>
										<option value="F" <?php if ($gender == "F") { echo 'selected'; }?> >Female (F)</option>
									</select>
								</td>
							</tr>
						</table><br>
						<small class="form-text">Confirm your current password below to change your personal information.</small>
						<table><tr>
								<td>Password: &nbsp;</td>
								<td><input type="hidden" name="password_id" value="<?php echo $account_id;?>"/><input type="password" class="form-control" name="ed_pwd" required /></td>
						</tr></table><br>
						<button type="submit" class="btn btn-success" name="change_other"><i class="fas fa-check"></i> Change Information to above</button>
					</form>

					<?php } elseif (isset($_GET['danger_area'])) { ?>
					<form action="account" method="POST">
						<?php if ($acc_type != "admin" AND $account_id != "1"){ // normal or premium users ?>
						<p>Hi <?php if ($acc_type == "premium"){ echo '<i class="fas fa-gem"></i> <b>Premium user</b>'; } else { echo 'user'; } ?>, we are sad to see you close your UNotes account! Please enter your reason below to inform us why you are leaving your account.<br><br>
							<textarea class="form-control" name="note_content" rows="1" placeholder="Reason why you leave..." required></textarea><br>
							<input type="hidden" name="deleteuser_id" value="<?php echo $account_id;?>"/>
							<input type="checkbox" id="deleteCheck" required> I am sure I want to delete my UNotes account. <br><?php if ($waspremium == "1") { ?>
							<input type="checkbox" id="deleteCheck2" required> I know I will still be charged for this month (ONLY when <i class="fas fa-gem"></i> <b>Premium</b> and  a new month started).<br> <?php } ?><br>
						<a href="#" class="btn btn-danger" id="pagesDropdown" data-toggle="modal" data-target="#deleteMyAccountModal" aria-haspopup="true"><i class="fas fa-exclamation-triangle"></i> Delete my account</a>
						</p>
						<?php } elseif ($account_id == "1") { // if owner asks to delete his account ?>
						<p>Hi Owner, <b>you can't delete your account</b>, because this would have a <b>catastrophical</b> impact on the whole system! Disadvantages would be:<br>
							<ul>
								<li>Nobody would be able to create new accounts manually,</li>
								<li>No new admin accounts could be created,</li>
								<li>Admin information could never be changed.</li>
							</ul>
							And even more problems with maintaining this whole system.
						</p>
						<?php } else { // if admin asks to delete his account ?>
						<p>Hi <b>admin</b>, if you want to stop working at UNotes, please contact someone with a higher position.</p>
					<?php } } else { ?>
						<p>Select one of the actions from the list above to change.</p>
					<?php } ?>
				</div>
			  </div>
			</div>
		  </div> <!-- /.row -->

		  <!-- Sure 2 Delete Modal-->
		<div class="modal fade" id="deleteMyAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-triangle"></i> Are you sure?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">×</span>
				</button>
			  </div>
			 <div class="modal-body">We are sad to see you leave. Do you <b>really</b> want to close your account? You <b>will loose</b> all of your <?php if ($acc_type == "premium") { echo '<u>notes, notebooks and tasks</u>!'; } else { echo '<u>notes and notebooks</u>!'; } ?> These actions are <b>irreversible!</b></div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger" name="user_delete">Yes, I am 100% sure. Bye.</button>
				</form>
			  </div>
			</div>
		  </div>
		</div>

      </div><!-- /.container-fluid -->

    <?php include 'afooter.php' ?>