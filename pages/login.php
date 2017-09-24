<?php
  session_start();
  include "../utils/functions.php";
  $ui = new ui_functions();
  $d1 = "";
  $d2 = "";
  if(isset($_GET['d1'])&&isset($_GET['d2'])){
    $d1 = $_GET['d1'];
    $d2 = $_GET['d2'];
  }
?>
<?php $ui->showHeadHTML("RP Axis - Login"); ?>
<style>

body {
  padding-top: 120px;
  padding-bottom: 40px;
  background-color: #eee;

}
.btn
{
 outline:0;
 border:none;
 border-top:none;
 border-bottom:none;
 border-left:none;
 border-right:none;
 box-shadow:inset 2px -3px rgba(0,0,0,0.15);
}
.btn:focus
{
 outline:0;
 -webkit-outline:0;
 -moz-outline:0;
}
.fullscreen_bg {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background-size: cover;
  background-position: 50% 50%;
  background-image: url('http://cleancanvas.herokuapp.com/img/backgrounds/color-splash.jpg');
  background-repeat:repeat;
}
.form-signin {
  max-width: 280px;
  padding: 15px;
  margin: 0 auto;
    margin-top:50px;
}
.form-signin .form-signin-heading, .form-signin {
  margin-bottom: 10px;
}
.form-signin .form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-top-style: solid;
  border-right-style: solid;
  border-bottom-style: none;
  border-left-style: solid;
  border-color: #000;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-top-style: none;
  border-right-style: solid;
  border-bottom-style: solid;
  border-left-style: solid;
  border-color: rgb(0,0,0);
  border-top:1px solid rgba(0,0,0,0.08);
}
.form-signin-heading {
  color: #fff;
  text-align: center;
  text-shadow: 0 2px 2px rgba(0,0,0,0.5);
}

</style>

<div id="fullscreen_bg" class="fullscreen_bg"/>

<div class="container">

	<form class="form-signin" action="../gateway/auth.php" method="post" >
		<h1 class="form-signin-heading text-muted">Sign In</h1>
		<input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="">
		<input type="password" class="form-control" name="password" placeholder="Password" required="">
		<button class="btn btn-lg btn-primary btn-block" type="submit">
			Sign In
		</button>
	</form>

</div>
