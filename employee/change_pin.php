<?php
session_start();
include '../conn.php';
include '../email.php';
include 'library.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["status"]="Please login your account here";
    $_SESSION["code"]="warning";
    header("location: ../index.php");
    exit;
}
if (isset($_POST['chng'])){
  $oldpass=$_POST['oldpass'];
  $newpass=$_POST['newpass'];
  $confirm=$_POST['confirm'];
  $expass=$_SESSION['pass'];
  if ($expass==$oldpass) {
    if ($newpass==$confirm) {
      $id=$_SESSION['id'];
     $query="UPDATE users set password='$newpass' where id='$id'";
     $rs1=mysqli_query($con,$query);
    if($rs1){
      unset($_SESSION['pass']);
    date_default_timezone_set('Asia/Karachi');
    $tms1 = date("Y-m-d h:i:s");
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
      $nm=$_SESSION['name'];
      $email=$_SESSION['email'];
      $msg="Hello dear ".$nm."! Your SKY BANK account  password is change successfully on ".$tms1.". Thank you for joining SKY BANK service.";
     email_send($email,"Password change successfully",$msg);
    }
    $_SESSION['pass']=$newpass;
    $_SESSION["title"]="Done";
    $_SESSION["status"]="Password changed";
    $_SESSION["code"]="success";
    header("location: change_pin.php");
    exit;
     }else{
       $_SESSION["title"]="Error";
       $_SESSION["status"]="Password not Change";
       $_SESSION["code"]="error";
       header("location: change_pin.php");
       exit;
      }
    }else{
      $_SESSION["title"]="Error";
    $_SESSION["status"]="Confirm password not matched";
    $_SESSION["code"]="error";
    header("location: change_pin.php");
    exit;
   }
  }else{
     $_SESSION["title"]="Error";
    $_SESSION["status"]="Old password not matched";
    $_SESSION["code"]="error";
    header("location: change_pin.php");
    exit;
  }
  }
?>
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        .footer-basic {
  padding:40px 0;
  background-color:brown;
  color:white;
}

.footer-basic ul {
  padding:0;
  list-style:none;
  text-align:center;
  font-size:18px;
  line-height:1.6;
  margin-bottom:0;
}

.footer-basic li {
  padding:0 10px;
}

.footer-basic ul a {
  color:inherit;
  text-decoration:none;
  opacity:0.8;
}

.footer-basic ul a:hover {
  opacity:1;
}

.footer-basic .social {
  text-align:center;
  padding-bottom:25px;
}

.footer-basic .social > a {
  font-size:24px;
  width:40px;
  height:40px;
  line-height:40px;
  display:inline-block;
  text-align:center;
  border-radius:50%;
  border:1px solid #ccc;
  margin:0 8px;
  color:inherit;
  opacity:0.75;
}

.footer-basic .social > a:hover {
  opacity:0.9;
}

.footer-basic .copyright {
  text-align:center;
  font-size:16px;
  color:#aaa;
  margin-bottom:-25px;
}
html {
  scroll-behavior: smooth;
}
#profileDisplay { display: block; height: 150px; width: 150px; margin: 0px auto; border-radius: 50%; }
    </style>
</head>

<body class="theme-red">
    <div class="overlay"></div>
<nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="../dashboard.php" style="font-size: 18px;">SKY BANK LIMITED</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                <li class="pull-right" ><a href="logout.php"><i class="fa fa-fw fa-sign-out fa-lg"></i> LogOut</a></li>
                   <li class="pull-right"><a href="#bot"><i class="fa fa-fw fa-envelope fa-lg"></i> Contact</a></li>
                    <!-- #END# Tasks -->
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['img']) .'" width="50" height="50" alt="User"/>' ?>
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['name'];?></div>
                    <div class="email"><?php echo $_SESSION['email'];?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">more_vert</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="user_profile.php"><i class="material-icons">person</i>Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="change_pin.php"><i class="material-icons">lock</i>Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="../dashboard.php">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                   <?php 
                   if($_SESSION['type']=="Admin" || $_SESSION["type"]=="Default"){
                   ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>Manage Employees</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="new_emp.php">Add Employee</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Block Account</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Employees List</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Delete Employee</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Search Employee</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Activate Account</a>
                            </li>
                            <li>
                                <a href="emp_list.php">Update Employee</a>
                            </li> 
                        </ul>
                    </li>
                   <?php 
               }
                    ?>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">group</i>
                            <span>Manage Accounts</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="newaccount.php">New Account</a>
                            </li>
                            <li>
                                <a href="search.php">Accounts List</a>
                            </li>
                        </ul>
                    </li>
                   <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">manage_accounts</i>
                            <span>Account Operations</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                    <a href="transfer.php">transaction</a>
                                </li>
                                <li>
                                    <a href="deposit.php">Deposit Balance</a>
                                </li>
                                <li>
                                    <a href="withdraw.php">Withdraw Balance</a>
                                </li>   
                            </ul>
                    </li>
                  
                  <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">person_add</i>
                            <span>Account Queries</span>
                        </a>
                        <ul class="ml-menu">
                                
                                <li>
                                    <a href="history.php?id=">transaction History</a>
                                </li>
                                <li>
                                    <a href="check_balance.php">Check Current Balance</a>
                                </li>
                                <li>
                                    <a href="history.php?id=">Deposit Balance History</a>
                                </li>
                                <li>
                                    <a href="history.php?id=">Withdraw Balance History</a>
                                </li>
                            </ul>
                    </li>
                    <li>
                        <a href="bank_balance.php">
                            <i class="material-icons">account_balance</i>
                            <span>Bank Balance</span>
                        </a>
                    </li>
                    <li>
                        <a href="ai_assistant.php">
                            <i class="material-icons">smart_toy</i>
                            <span>AI Assistant</span>
                        </a>
                    </li>
                   <li>
                        <a href="user_profile.php">
                            <i class="material-icons">person</i>
                            <span>Account Profile</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="change_pin.php">
                            <i class="material-icons">lock</i>
                            <span>Change Passowrd</span>
                        </a>
                    </li>
    
                </ul>
            </div>
        </aside>
    </section>
    <section class="content" id="top">
       <div class="container-fluid">
            <div class="block-header">
                <div  class="col-sm-8">
                <p style="margin-left: -15px; font-size: 17px; font-weight: bold;">Change Password</p>
            </div>
            </div>
            <div class="row clearfix">
              </div>
              <hr style="height:1px;border-width:0; width: 100%; margin-bottom:  -5px; margin-top: 20px; color:red;background-color:gray;">
                    <br>
                   <br><br>
                <div class="box-body">
                    <form id="form" method = "post" enctype="multipart/form-data">
                    <div class="row">
                        <div  class="col-sm-offset-3 col-sm-6">
                          <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Old Password</p>
                             <input type="password" class="form-control" name="oldpass" placeholder="Enter old password" id="snd1" required>
                        </div>
                      </div>
                      <div class="row">
                        <div  class="col-sm-offset-3 col-sm-6">
                          <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">New Password</p>
                             <input type="password" class="form-control" name="newpass" placeholder="Enter new password" id="snd2" required>
                        </div>
                      </div>
                      <div class="row">
                        <div  class="col-sm-offset-3 col-sm-6">
                          <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Confirm Password</p>
                             <input type="password" class="form-control" name="confirm" placeholder="Enter confirm new password" id="snd3" required>
                        </div>
                      </div>
                        <br><br>
                        <div class="row">
                          <center>
                        <div  class="col-sm-offset-3 col-sm-6">
                        <input type="submit"  class="btn btn-primary form-control" style=" font-size: 17px; width: 170px; border-radius: 5px;" name="chng" id="sbtn1" value="Change Password">
                       </div>
                     </center>
                     </div>
                </form>
                </div>
            </div>
            <br><br><br><br>
            <div class="row clearfix" id="not">
    <div class="footer-basic" id="bot">
        <footer>
            <center><h4 style="margin-top: -15px;">Contact Us</h4></center>
            <div class="social"><a href="https://www.instagram.com/"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-skype"></i></a><a href="https://twitter.com/"><i class="icon ion-social-twitter"></i></a><a href="https://web.facebook.com/"><i class="icon ion-social-facebook"></i></a></div>
          <hr style="height:1px;border-width:0; margin-top: -10px; color:gray;background-color:gray">
            <ul class="list-inline">
                <li class="list-inline-item"><a href="../dashboard.php">Home</a></li>
                <li class="list-inline-item"><a href="about.php?type=Services">Services</a></li>
                <li class="list-inline-item"><a href="about.php?type=About">About</a></li>
                <li class="list-inline-item"><a href="about.php?type=Privacy">Privacy Notice</a></li>
            </ul>
            <hr style="height:1px;border-width:0; color:gray;background-color:gray">
            <p class="copyright" style="margin-top: 0px;">SKY BANK LIMITED © 2025</p>
        </footer>
    </div>
</div>
    </section>
    <?php
if(isset($_SESSION['status']) && $_SESSION['status']!=''){
?>
<script type="text/javascript">
  Swal.fire({
  position: 'top-center',
  icon: '<?php echo $_SESSION['code']?>',
  title: '<?php echo $_SESSION['status']?>',
  showConfirmButton: false,
  timer: 4000
});
</script>
<?php
 unset($_SESSION['status']);
}
?>

</body>

</html>
