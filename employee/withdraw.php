<?php
session_start();
ob_start();
include '../conn.php';
include '../email.php';
include 'library.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["status"]="Please login your account here";
    $_SESSION["code"]="warning";
    header("location: ../index.php");
    exit;
}
if (isset($_POST['transfer'])){
  $name=$_POST['name'];
  $acc=$_POST['acc'];
  $email=$_POST['email'];
  $title=$_POST['title'];
  $blnc=$_POST['blnc'];
  $newbnc=$_POST['amount'];
  $bnc1=$blnc-$newbnc;
  if($newbnc<$blnc || $blnc>500){
  $query="UPDATE accounts_info set balance='$bnc1' where account='$acc'";
  $rs1=mysqli_query($con,$query);
  if($rs1){
    date_default_timezone_set('Asia/Karachi');
    $regisdate=date("Y-m-d");
    $tms = date("h:i:s");
    $tms1 = date("Y-m-d h:i:s");
    mysqli_query($con,"INSERT INTO account_history(account,sender,s_name,reciever,r_name,dt,tm,type,amount) VALUES('$acc','$acc','$name','null','null','$regisdate','$tms','Withdraw','$newbnc')");
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
      $msg="Hello dear ".$name."! You have withdraw balance from your SKY BANK account  on ".$tms1.". Amount ".$newbnc.".00NGN withdraw successfully. Your remaining account balance is ".$bnc1.".00NGN. Thank you for joining SKY BANK service.";
     email_send($email,"Amount withdraw successfully",$msg);
    }
    $_SESSION["title"]="Done";
    $_SESSION["status"]="Amount withdraw successfully";
    $_SESSION["code"]="success";
    header("location: withdraw.php");
    die();

  }else{
    $_SESSION["title"]="Error";
    $_SESSION["status"]="Amount not withdraw";
    $_SESSION["code"]="error";
    header("location: withdraw.php");
    exit;

  }
}else{
  $_SESSION["title"]="Error";
    $_SESSION["status"]="Current Balance is low";
    $_SESSION["code"]="error";
    header("location: withdraw.php");
    exit;

}


  }
  ob_end_flush();
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
                   <li class="active">
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
                    <li>
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
                <p style="margin-left: -15px; font-size: 17px; font-weight: bold;">Amount Deposit Board</p>
            </div>
            </div>
            <div class="row clearfix">
              </div>
              <hr style="height:1px;border-width:0; width: 100%; margin-bottom:  -5px; margin-top: 20px; color:red;background-color:gray;">
                    <br>
                   <p style="text-align: left; font-weight: bold;">Search Board</p>
                <div class="box-body">
                    <form id="form" method = "post" enctype="multipart/form-data">
                    <div class="row">
                        <div  class="col-sm-8">
                             <input type="text" class="form-control" name="sender" placeholder="Enter account number" id="snd" required>
                        </div>
                        <div  class="col-sm-4">
                        <input type="submit"  class="btn btn-primary form-control" style=" font-size: 17px; width: 120px; border-radius: 5px;" name="filter" id="sbtn" value="Search">
                       </div>
                    </div>
                </form>
                <hr style="height:1px;border-width:0; width: 100%; margin-bottom:  -5px; margin-top: 20px; color:red;background-color:gray;">
                <br>
                <?php
                if (isset($_POST['filter'])){
                  $sender=$_POST['sender'];
                  $sql="SELECT c.* , p.* FROM accounts_info c,accountsholder p WHERE c.account=p.account and p.account='$sender'";
                  $result = mysqli_query($con,$sql);
                  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                  $nm = (mysqli_query($con,$sql));
                  if(mysqli_num_rows($nm)>0){
                        ?>
                        <p style="text-align: left; font-weight: bold;">Information Board</p>
                      <form id="form2" method = "post" enctype="multipart/form-data">
                    <div class="row">
                        <div  class="col-sm-6">
                            <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Account Title</p>
                             <input type="text" class="form-control" name="title" value="<?php echo $row['account_title'];?>"  readonly>
                        </div>
                        <div  class="col-sm-6">
                            <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Account Holder Name</p>
                            <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>"  readonly>
                            <input type="hidden" class="form-control" name="email" value="<?php echo $row['email'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div  class="col-sm-6">
                            <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Account Number</p>
                             <input type="text" class="form-control" name="acc" value="<?php echo $row['account'];?>"readonly>
                        </div>
                        <div  class="col-sm-6">
                            <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Current Balance</p>
                            <input type="text" class="form-control" name="blnc" value="<?php echo $row['balance'].".00 NGN";?>"  readonly>
                        </div>
                    </div>
                    <hr style="height:1px;border-width:0; width: 100%; margin-bottom:  -5px; margin-top: 20px; color:red;background-color:gray;">
                    <br>
                   <p style="text-align: left; font-weight: bold;">Action Board</p>
                   <div class="row">
                        <div  class="col-sm-5">
                            <p for="exampleInputEmail1" style="margin-bottom: 1px; margin-top: 8px;">Withdraw Amount</p>
                            <input type="number" class="form-control" name="amount" id="am" min="500" placeholder="Enter withdraw amount" required>
                        </div>
                        <div  class="col-sm-2">
                        <input type="submit"  class="btn btn-primary form-control" style="margin-top: 28px; font-size: 17px; width: 120px; border-radius: 5px;" name="transfer" id="trans" value="Withdraw" onclick="var vl = document.getElementById('am').value; var e=this;var s=document.getElementById('sbtn');setTimeout(function(){if(vl>=500){e.disabled=true;s.disabled=true;}},0); return true;">
                       </div>
                    </div>
                    </form>
                    <?php
                  }else{
                    //sender
                    $_SESSION["title"]="Error";
                    $_SESSION["status"]="User account not found";
                    $_SESSION["code"]="error";
                  }
                }
                ?>
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
