<?php
session_start();
include '../conn.php';
include 'library.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION["status"]="Please login your account here";
    $_SESSION["code"]="warning";
    header("location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AI Assistant</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/materialize.css">
    <link rel="stylesheet" href="../css/themes/theme-blue.css">
    <link rel="stylesheet" href="../css/native-toast.css">
    <link rel="stylesheet" href="../css/sweet.css">
    <link rel="stylesheet" href="../plugins/node-waves/waves.css">
    <link rel="stylesheet" href="../plugins/animate-css/animate.css">
    <style type="text/css">
        .chat-container {
            max-width: 500px;
            margin: 40px auto 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            height: 500px;
        }
        .chat-header {
            padding: 16px;
            background: #F44336;
            color: #fff;
            border-radius: 10px 10px 0 0;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            background: #f4f7fa;
            display: flex;
            flex-direction: column;
        }
        .chat-message {
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
        }
        .chat-message.user {
            align-items: flex-end;
        }
        .chat-message.bot {
            align-items: flex-start;
        }
        .chat-bubble {
            max-width: 75%;
            padding: 10px 16px;
            border-radius: 18px;
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 4px;
        }
        .chat-message.user .chat-bubble {
            background: brown;
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .chat-message.bot .chat-bubble {
            background: #e0e0e0;
            color: #222;
            border-bottom-left-radius: 4px;
        }
        .chat-input-area {
            display: flex;
            padding: 12px;
            border-top: 1px solid #eee;
            background: #fafbfc;
            border-radius: 0 0 10px 10px;
        }
        .chat-input {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 16px;
            outline: none;
        }
        .chat-send-btn {
            background: #F44336;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 8px 24px;
            margin-left: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .chat-send-btn:hover {
            background: brown;
        }
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
    </style>
</head>
<body class="theme-red">
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
            </ul>
        </div>
    </div>
</nav>
<section>
    <aside id="leftsidebar" class="sidebar">
        <div class="user-info">
            <div class="image">
                <?php echo isset($_SESSION['img']) ? '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['img']) .'" width="50" height="50" alt="User"/>' : '<img src="../images/user.png" width="50" height="50" alt="User"/>'; ?>
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo isset($_SESSION['name']) ? $_SESSION['name'] : 'User';?></div>
                <div class="email"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'user@email.com';?></div>
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
                <li class="active">
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
        <div class="chat-container">
            <div class="chat-header">AI Assistant</div>
            <div class="chat-messages" id="chatMessages"></div>
            <form class="chat-input-area" id="chatForm" autocomplete="off" onsubmit="return false;">
                <input type="text" class="chat-input" id="chatInput" placeholder="Type your message..." autocomplete="off" />
                <button type="submit" class="chat-send-btn">Send</button>
            </form>
        </div>
    </div>
    <br>
    <div class="row clearfix" id="not">
        <div class="footer-basic" id="bot">
            <footer>
                <center><h4 style="margin-top: -15px;">Contact Us</h4></center>
                <div class="social"><a href="https://www.instagram.com/"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-skype"></i></a><a href="https://twitter.com/"><i class="icon ion-social-twitter"></i></a><a href="https://web.facebook.com/"><i class="icon ion-social-facebook"></i></a></div>
                <hr style="height:1px;border-width:0; margin-top: -10px; color:gray;background-color:gray">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="dashboard.php">Home</a></li>
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
<script>
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');

    function appendMessage(sender, text) {
        const msgDiv = document.createElement('div');
        msgDiv.className = 'chat-message ' + sender;
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.textContent = text;
        msgDiv.appendChild(bubble);
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatForm.addEventListener('submit', function() {
        const userMsg = chatInput.value.trim();
        if (userMsg === '') return;
        appendMessage('user', userMsg);
        chatInput.value = '';
        setTimeout(function() {
            appendMessage('bot', 'Currently in development. I will  be able to handle your requests soon.');
        }, 500);
    });
</script>
</body>
</html> 