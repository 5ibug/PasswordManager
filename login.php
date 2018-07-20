<?php
	require_once 'Config.php';
	session_start();
	$user=new User();
	$log = new log();
?>
<!DOCTYPE html>
<html>
<head>
<title>用户登录 - 小可爱的密码管理</title>
<link href="css/style.css" rel='stylesheet' type='text/css' />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="5ibug 密码管理 吾爱bug"./>
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
</script>
<script src="js/jquery.min.js"></script>
</head>
<body>
	<?php
		if ($user->Auth($mysql)){ //验证是否登陆过
			header("Location: index.php"); 
			exit();
		}
		if(isset($_POST['user']) && isset($_POST['password'])){
			if ($user->UserLogin($mysql,$_POST['user'],$_POST['password'],USER_SALT)){
				echo '登陆成功'."<br>";
				$log->WriteLog($mysql,$user->username,'user login');
				header("Location: index.php"); 
				exit();
			}else{
				$log->WriteLog($mysql,$_POST['user'],'Try login');
				?>
				<script>$(function(){ 
					$('.toast.toast--yellow.add-margin').show();
				}); 
				</script>
				<?php
			}
		}
	?>
		<div class="app-location">
			<h2>Welcome to 5Ibug</h2>
			<div class="line"><span></span></div>
			<div class="location"><img src="images/location.png" class="img-responsive" alt="" /></div>
			<form action="#" method="post">
				<input name="user" type="text" class="text" value="User name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User name';}" >
				<input name="password" type="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
				<div class="submit"><input type="submit" onclick="myFunction()" value="Sign in" ></div>
				<div class="clear"></div>
				<div class="new">
					<!--<h3><a href="#">Forgot password ?</a></h3>-->
					<h4><a href="register.php">New here ? Sign Up</a></h4>
					<div class="clear"></div>
				</div>
			</form>
		</div>
		
		<div class="toast__container">
				<div class="toast__cell">

				
				<div class="toast toast--green" style="display:none;">
				<div class="toast__icon">
					<svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
				<g><g><path d="M504.502,75.496c-9.997-9.998-26.205-9.998-36.204,0L161.594,382.203L43.702,264.311c-9.997-9.998-26.205-9.997-36.204,0    c-9.998,9.997-9.998,26.205,0,36.203l135.994,135.992c9.994,9.997,26.214,9.99,36.204,0L504.502,111.7    C514.5,101.703,514.499,85.494,504.502,75.496z"></path>
					</g></g>
					</svg>
				</div>
				<div class="toast__content">
					<p class="toast__type">成功</p>
					<p class="toast__message">登陆成功!!!!</p>
				</div>
				<div class="toast__close">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
				<path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
				</svg>
				</div>
				</div>


				<div class="toast toast--blue add-margin" style="display:none;">
				<div class="toast__icon">
				<svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
				<g>
					<g id="info">
						<g>
							<path  d="M10,16c1.105,0,2,0.895,2,2v8c0,1.105-0.895,2-2,2H8v4h16v-4h-1.992c-1.102,0-2-0.895-2-2L20,12H8     v4H10z"></path>
							<circle  cx="16" cy="4" r="4"></circle>
						</g>
					</g>
				</g>

					</svg>
				</div>
				<div class="toast__content">
					<p class="toast__type">提示</p>
					<p class="toast__message">未知错误。</p>
				</div>
				<div class="toast__close">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
				<path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
				</svg>
				</div>
				</div>



				<div class="toast toast--yellow add-margin" style="display:none;">
				<div class="toast__icon">
				<svg version="1.1" class="toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 301.691 301.691" style="enable-background:new 0 0 301.691 301.691;" xml:space="preserve">
				<g>
					<polygon points="119.151,0 129.6,218.406 172.06,218.406 182.54,0  "></polygon>
					<rect x="130.563" y="261.168" width="40.525" height="40.523"></rect>
				</g>
					</svg>
				</div>
				<div class="toast__content">
					<p class="toast__type">警告</p>
					<p class="toast__message" >	账号或密码错误!!!!</p>
				</div>
				<div class="toast__close">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
				<path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
				</svg>
				</div>
				</div>


				</div>
				</div>


		<script>
			jQuery(document).ready(function(){
			jQuery('.toast__close').click(function(e){
				e.preventDefault();
				var parent = $(this).parent('.toast');
				parent.fadeOut("slow", function() { $(this).remove(); } );
			});
			});
		</script>
</body>
</html>