<?php
  session_start();
  $session_id = session_id();
  require_once 'config/connect.php';
  require_once 'config/core.php';
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $auth = new Auth();

  if (isset($_SESSION["auth_id"])){
    $member_id = $_SESSION["auth_id"];
  }else{
    header('Location: index.php?alert=auth_fail');
  }

  $alert = null;
  if(!empty($_GET)){
    $alert = $_GET['alert'];
  }
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Chat With Ajax&Jquery</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="node_modules/font-awesome/css/font-awesome.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="node_modules/sweetalert/dist/sweetalert.css">
    <script src="node_modules/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Bootstrap -->
    <link href="node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Twemoji-Picker -->
    <link href="node_modules/Twemoji-Picker-master/css/twemoji-picker.css" rel="stylesheet">
    <!-- myApp -->
    <link rel="stylesheet" href="dist/css/myApp.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <body>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center">Chat With Ajax & Jquery</h1>
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">
                <i class="fa fa-commenting-o" aria-hidden="true"></i> Chat |
                <?php echo 'IP: '.$auth->getIP();?>
                </h3>
              </div>
              <div class="panel-body" id="chat">
                <ul class="chat">
                  <div id="messages"></div>
                </ul>
              </div>
              <div class="panel-footer">
                <div class="input-group">
                    <!--<input type="text" id="enterchat" class="form-control input-sm" data-emojiable="true" placeholder="Type your message here..." />-->
                     <textarea id="enterchat" class="form-control twemoji-picker"></textarea>
                    <span class="input-group-btn">
                    <button id="sendbtn" class="btn btn-warning btn-sm" onclick="sendajax()"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div> <!-- /container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Begin Twemoji-Picker JavaScript -->
    <script src="node_modules/Twemoji-Picker-master/js/twemoji-picker.js"></script>
    <!-- myApp -->
    <script src="dist/js/myApp.js"></script>
    <script>
    setInterval(function(){
      updateChat();
      $('#chat').scrollTop($('#chat')[0].scrollHeight);
    },400);

    function sendajax () {
      var text_messages = $('textarea#enterchat').val();
      $.ajax({
            url: 'process.php',
            type: 'POST',
            data: 'chat=' + text_messages,
            success: function(data) {
              console.log(data + ' <-- #output');
            }
        });
    }
  <?php if($alert == 'Auth_success'){ ?>
    swal({
      title: "Auth Success!",
      text: "Welcome to Chat With Ajax&Jquery.",
      type: "success",
      timer: 2000,
      showConfirmButton: false
    });
  <?php } ?>
    </script>
  </body>
</html>
<?php Database::disconnect();?>
