<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>会员登录</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('admin/user/css/login.css')}}">

	</head>
	<body>
		<!-- login -->
		<div class="top center">
			<div class="logo center">
				<a href="{{asset('first/first')}}" target="_blank"><img src="/admin/image/mistore_logo.png" alt="图片加载中"></a>
			</div>
		</div>
		<form  method="post" action="{{asset('user/login')}}" class="form center">
            @csrf
		<div class="login">
			<div class="login_center">
				<div class="login_top">
					<div class="left fl">会员登录</div>
					<div class="right fr">您还不是我们的会员？<a href="{{asset('user/register')}}" target="_self">立即注册</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="login_main center">
					<div class="username">登录账号:&nbsp;<input class="shurukuang" type="text" name="username" placeholder="请输入您的注册邮箱或手机号"/></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入您的对应密码"/></div>
					<div class="username">
						{{--<div class="left fl">验证码:&nbsp;<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码"/></div>
						<div class="right fl"><img src="/admin/image/yanzhengma.jpg"></div>
						<div class="clear"></div>--}}
					</div>
				</div>
				<div class="login_submit">
					<input class="submit" type="submit" value="立即登录" >
				</div>
				
			</div>
		</div>
		</form>
		<footer>
			<div class="copyright">简体 | 繁体 | English | 常见问题</div>
			<div class="copyright">小米公司版权所有-京ICP备10046444-<img src="./image/ghs.png" alt="">京公网安备11010802020134号-京ICP证110507号</div>

		</footer>
	</body>
</html>