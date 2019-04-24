<?php
        $email=$_SESSION['user_email'];

        include '_inc/dbconn.php';
        $sql="SELECT * FROM UNotesMAIN.users WHERE email='$email'";
        $result=  mysql_query($sql) or die(mysql_error());
        $rws=  mysql_fetch_array($result);
                
				// logged in account id & users name and surname
        $account_id= $rws[0];
        $account_name= $rws[1];
				$acc_username=$rws[11];
        $last_login= $rws[9];
        $acc_status=$rws[10];
        $status=$rws[12];
        $waspremium=$rws[13];
                
        $address=$rws[5];
        $acc_type=$rws[4];
                
        $gender=$rws[2];
        $mobile=$rws[6];
        $email=$rws[7];
        $dob=$rws[3];
                
        $_SESSION['user_id']=$account_id;
        $_SESSION['username']=$acc_username;
        $_SESSION['name']=$account_name;
				
				// checking for corrupted sessions
				if ($email == ""){ // often happends when user is deleted and still logged in or corrupted session
					session_destroy();
					header('location:index?notice=1');
				} elseif ($rws[10] == "DISABLED"){ // logs users out when they are disabled and still logged in
          $date=date('Y-m-d h:i:s');
          $exitsql="UPDATE UNotesMAIN.users SET lastlogin='$date' WHERE id='$account_id'"; // last login
          mysql_query($exitsql) or die("Could not set your lastlogin time.");
          $exitsql2="UPDATE UNotesMAIN.users SET status='offline' WHERE id='$account_id'"; // set user status to offline
          mysql_query($exitsql2) or die("Could not set your status to offline.");

					session_destroy();
					header('location:index?error=3');
				} elseif ($status == "offline"){ // cookies cleared, but no official logout
          session_destroy();
          header('location:index?error=2');
        }
?>
<div id="wrapper">
      <!-- Sidebar -->
    <ul class="sidebar navbar-nav toggled">
  	    <li class="nav-item">
            <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="modal" data-target="#newnoteModal" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-plus-circle fa-lg"></i>
              <span>New note</span>
            </a>
        </li>
  		  <li class="nav-item">
          <a class="nav-link" href="notes">
            <i class="fas fa-sticky-note fa-lg"></i><span>Notes</span>
          </a>
        </li>
        <?php if ($acc_type == "normal") { ?>
  		  <li class="nav-item">
          <a class="nav-link" href="notebooks">
            <i class="fas fa-folder-open fa-lg"></i><span>Notebooks</span>
          </a>
        </li>
        <?php } elseif ($acc_type == "admin"){ ?>
          <li class="nav-item">
          <a class="nav-link" href="notebooks">
            <i class="fas fa-folder-open fa-lg"></i><span>Notebooks</span>
          </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="support?new">
             <i class="fas fa-fw fa-life-ring fa-lg"></i><span>Support Panel</span>
            </a>
          </li>
          <li class="nav-item mb-5">
            <a class="nav-link" href="admin?new">
             <i class="fas fa-fw fa-wrench fa-lg"></i><span>Admin</span>
            </a>
          </li>
        <?php } else { ?>
          <li class="nav-item mb-5">
            <a class="nav-link" href="notebooks">
              <i class="fas fa-folder-open fa-lg"></i><span>Notebooks</span>
            </a>
          </li>
        <?php } if ($acc_type == "normal"){ ?>					 
		    <li class="nav-item mb-5">
          <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="modal" data-target="#premiumModal" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-gem"></i><span>Premium!</span>
          </a>
        </li>
      <?php } ?>
		    <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-lg"></i> <span><?php echo $_SESSION['username']?></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Welcome user <b><?php echo $_SESSION['name']?></b>!</h6>
			      <!-- devider could go here <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="users"><i class="fas fa-fw fa-users"></i> All Users</a>
			      <?php if ($acc_type == "admin"){ ?>
              <a class="dropdown-item" href="support?new"><i class="fas fa-fw fa-life-ring"></i> Support Panel</a>
			        <a class="dropdown-item" href="admin?new"><i class="fas fa-fw fa-wrench"></i> Admin Panel</a>
			      <?php } elseif ($acc_type == "normal"){ ?>
              <a class="dropdown-item" href="#" role="button" data-toggle="modal" data-target="#premiumModal" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-gem"></i> UNotes Premium</a>
            <?php } ?>
              <a class="dropdown-item" href="account"><i class="fas fa-fw fa-cogs"></i> Settings</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
			         <i class="fas fa-fw fa-sign-out-alt"></i> Logout
              </a>
          </div>
        </li>
		    <li class="nav-item">
          <a class="nav-link" href="#" id="pagesDropdown" role="button" data-toggle="modal" data-target="#logoutModal" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-sign-out-alt fa-lg"></i>
            <span>Logout</span>
          </a>
        </li>
    </ul>