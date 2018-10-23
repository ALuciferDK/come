<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('frontend/user/css/login.css')}}">

	</head>
	<body>
        {{--<div class="middle" style="float: left; height: 35px; margin-top: 5px;margin-left: 20px;">
            <button style="font-weight: 900;height: 35px;" class="cli" value="1">邮箱注册</button>
            <button style="font-weight: 900;height: 35px;" class="cli" value="0">手机号注册</button>
        </div>--}}
            <form  method="post" action="{{asset('user/register')}}">
                @csrf
                <div class="regist">
                    <div class="regist_center">
                        <div class="regist_top">
                            <div class="left fl">会员注册</div>
                            <div class="right fr" style="margin-left: 10px;"><a id="cli" href="javascript:void(0)" target="_self">点击切换注册方式</a></div>
                            <div class="right fr"><a href="{{asset('first/first')}}" target="_self">小米商城</a></div>
                            <div class="clear"></div>
                            <div class="xian center"></div>
                        </div>
                        <div class="regist_main center">
                            <div class="username">用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;
                                <input id="u_name" class="shurukuang" type="text" name="username" placeholder="请输入你的用户名"/>
                                <span id="n_info">请不要输入汉字</span>
                            </div>
                            <div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;
                                <input id="pwd" class="shurukuang" type="password" name="password" placeholder="请输入你的密码"/>
                                <span id="p_info">请输入6位以上字符</span>
                            </div>

                            <div class="username">确认密码:&nbsp;&nbsp;
                                <input id="re_pwd" name="password_confirmation" class="shurukuang" type="password" placeholder="请确认你的密码"/>
                                <span id="re_info">两次密码要输入一致哦</span>
                            </div>
                            <div class="username" id="show">联系方式:&nbsp;&nbsp;
                                <input id="tel" class="shurukuang" type="tel" name="tel" placeholder="请填写正确的手机号"/>
                                <span id="t_info">填写下手机号吧，方便我们联系您！</span>
                            </div>
                            <div class="username" id="hidden" hidden="hidden">联系方式:&nbsp;&nbsp;
                                <input id="email" class="shurukuang" type="email" placeholder="请填写正确的邮箱"/>
                                <span id="e_info">填写下邮箱吧，方便我们联系您！</span>
                            </div>

                            <div class="username">
                                <div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;&nbsp;<input class="yanzhengma" type="text" name="captcha" placeholder="请输入验证码"/></div>
                                <div class="right fl">
                                    <img src="{{captcha_src()}}" style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()" id="captchaImg">
                                    <span id="y_info">请输入验证码</span>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="regist_submit">
                            <input id="sub" class="submit" type="submit" value="立即注册" >
                        </div>
                    </div>
                </div>

            </form>
	</body>
</html>
<script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
<script>

    var flag = false;
    $(document).ready(function(){

        // 	验证邮箱、手机号注册
        $("#u_name").blur(function(){
            var u_name = $(this).val();
            reg = /^[A-Za-z0-9]{5,16}$/;
            if(u_name == '')
            {
                $('#n_info').text('用户名不能为空').css('color','red');$('#u_name').css('border-color','red');
                flag = false;
            }
            else if(reg.test(u_name))
            {
                $('#n_info').text('用户名不能使用汉字').css('color','red');$('#u_name').css('border-color','red');
                flag = false;
            }
            else
            {
                $('#n_info').text('用户名可用').css('color','green');$('#u_name').css('border-color','green');
                flag = true;
            }

        });

        // 	密码验证
        $("#pwd").blur(function(){
            var pwd = $(this).val();
            reg = /^[a-z0-9A-Z]\w{5,13}$/;
            if (reg.test(pwd)) {
                $('#p_info').text('密码通过').css('color','green');$('#pwd').css('border-color','green');
                flag =  true;
            }else{
                $('#p_info').text('密码长度必须5-17位之间').css('color','red');$('#pwd').css('border-color','red');
                flag =  false;
            }
        });

        // 	验证确认密码与密码是否一致
        $("#re_pwd").blur(function(){
            var pwd = $("#pwd").val();
            var re_pwd = $(this).val();
            if(pwd == '')
            {
                $('#re_info').text('密码不可为空').css('color','red');$('#re_pwd').css('border-color','red');
                flag = false;
            }
            else if (re_pwd == pwd) {
                $('#re_info').text('成功').css('color','green');$('#re_pwd').css('border-color','green');
                flag = true;
            }else{
                $('#re_info').text('确认密码与密码不一致').css('color','red');$('#re_pwd').css('border-color','red');
                flag = false;
            }
        });

    });

    //验证手机号码唯一性
    $('#tel').blur(function(){
            var info = $(this).val();
            var regTel = /^1[3578]\d{9}$/;
            if(regTel.test(info))
            {
                $.ajax({
                    url:'userTel',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','tel':info},
                    success:function(msg){
                        if (msg == 2) {
                            alert("号码以存在");
                            $('#t_info').text('此号码以注册').css('color','red');$('#tel').css('border-color','red');
                            flag = false;
                        }
                        else
                        {
                            $('#t_info').text('号码正确').css('color','green');$('#tel').css('border-color','green');
                            flag = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                });
            }
            else
            {
                $('#t_info').text('号码必须是中国号码').css('color','red');$('#tel').css('border-color','red');
                flag = false;
            }
        });

    //验证邮箱唯一性
    $('#email').blur(function(){
        var info = $(this).val();
        var regEmail =/^[A-Za-z0-9]+\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
        if(regEmail.test(info))
        {
            $.ajax({
                url:'userEmail',
                type:'POST',
                data:{'_token':'{{csrf_token()}}','email':info},
                success:function(msg){
                    if (msg == 2) {
                        alert("邮箱以存在");
                        $('#e_info').text('此邮箱以注册').css('color','red');$('#email').css('border-color','red');
                        flag = false;
                    }
                    else
                    {
                        $('#e_info').text('邮箱正确').css('color','green');$('#email').css('border-color','green');
                        flag = true;
                    }
                },
                error:function(msg){
                    alert("服务器繁忙");
                }
            });
        }
        else
        {
            $('#e_info').text('邮箱必须是正确邮箱').css('color','red');$('#email').css('border-color','red');
            flag = false;
        }
    });

    //验证码


    //验证验证码输入是否正确
    $('.yanzhengma').blur(function(){
        var val = $(this).val();
        $.ajax({
            url:'werAdd',
            type:'POST',
            data:{'_token':'{{csrf_token()}}','captcha':val},
            success:function(msg){
                //alert(msg);
                if (msg == 2) {
                    $('yanzhengma').css('border-color','red');$('#y_info').text('验证码错误').css('color','red');
                    $('#captchaImg').trigger("click");
                    flag = false;
                }else if(msg == 3)
                {
                    $('yanzhengma').css('border-color','green');$('#y_info').text('正确').css('color','green');
                    flag = true;
                }
            },
            error:function(msg){
                $('yanzhengma').css('border-color','red');$('#y_info').text('验证码错误').css('color','red');
                flag = false;
            }
        });
    });

    //通过定义的flag判断是否可以点击注册
    $('#sub').click(function(){
       if(flag == false)
       {
           $(this).attr('disabled',true);
       }else
       {
           $(this).remove('disabled');
       }
    })

    var blank = 1;//1是邮箱注册，0是手机号注册。

    //点击修改注册联系方式
    $('#cli').click(function(){
        if(blank == 1)
        {
            $('#show').attr('hidden',true);
            $('#hidden').attr('hidden',false);
            $('#email').attr('name','email');
            $('#tel').attr('name',false);
            blank = 0;
        }
        else
        {
            $('#hidden').attr('hidden',true);
            $('#show').attr('hidden',false);
            $('#tel').attr('name','tel');
            $('#email').attr('name',false);
            blank = 1
        }
    })
</script>
