<?php
  session_start();
  $session_id = session_id();
  //echo 'session id : '.$session_id;
  require_once 'config/connect.php';
  require_once 'config/core.php';
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $auth = new Auth();

  $find_member = $auth->find_member($session_id,$pdo);
  if($find_member !== 0){
    $member_auth_id = $find_member['member_id'];
    $_SESSION['auth_id'] = $member_auth_id;
    header('Location: main.php?alert=Auth_success');
  }

  if(!empty($_POST)){

    $name = $_POST['name'];

    $valid = true;
    if (empty($name)){
      header('Location: index.php?alert=enter_name');
      $valid = false;
    }

    if ($valid){
      $create_member = $auth->create_member($name,$session_id,$pdo);
      $_SESSION['auth_id'] = $create_member;
      header('Location: main.php?alert=Auth_success');
    }

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
    <!-- Bootstrap -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <!-- Bootstarp social -->
    <link rel="stylesheet" href="node_modules/bootstrap-social/bootstrap-social.css">
    <!-- myApp -->
    <link rel="stylesheet" href="dist/css/myApp.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <body>
      <div class="container" id="auth">
        <div class="row">
          <div class="col-md-12 text-center">
            <h1 class="text-center">Chat With Ajax & Jquery</h1>
            <form class="form-inline" action="" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="name" autocomplete="off" placeholder="Enter name">
              </div>

              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Enjoy</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
        	<div class="col-md-2 col-md-offset-5 text-center">
        		<div class="github">
        			<a href="https://github.com/abcprintf/Chat-with-ajax-jquery" target="_blank" class="btn btn-block btn-social btn-github"><span class="fa fa-github"></span> View on GitHub</a>
        		</div>
        	</div>
        </div>
     </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  </body>
</html>
<?php Database::disconnect();?>
