@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>角色管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/backend/home"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">角色管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">角色添加</font></font>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色添加</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="add" method="post">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">角色名称</font></font></label>
                    <input type="text" class="form-control" name="rolename"  placeholder="Rolename" id="rolename">
                    <span id="rolename_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">分配菜单权限</font></font></label>
                    <div class="checkbox" style="margin-left:20px;">
                        @foreach($menuData as $key => $value)
                            <div style="margin-left:3rem;">
                                <input type="checkbox" class="from-control" name="menus[]" value="{{$value['menu_id']}}">
                                {{$value['menu_name']}}
                            </div>
                            <div style="margin:1rem 0 1rem 0;margin-left:4rem;">
                                @foreach($value['son'] as $key => $item)
                                    <label style="">
                                        <input type="checkbox" class="from-control" name="menus[]" value="{{$item['menu_id']}}">
                                        {{$item['menu_name']}}
                                    </label>
                                @endforeach
                            </div>

                        @endforeach
                        <span id="role_info"></span>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button class="btn btn-primary" id="reset"  type="reset">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">重置</font></font>
                </button>
                <button type="submit" class="btn btn-primary" id="submit">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提交</font></font>
                </button>
            </div>
        </form>
    </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>

        //   用户信息验证
        $(document).ready(function(){

            var checkRolename = '';

            //  用户名验证
            $("#rolename").blur(function(){
                var rolename = $(this).val();
                regular = /^[\u4E00-\u9FA5A-Za-z]{2,20}$/;
                if (rolename == '') {
                    $('#rolename_info').text('角色名不能为空').css('color','red');$('#rolename').css('border-color','red');
                    checkRolename = false;
                }else if (regular.test(rolename)) {
                    $('#rolename_info').text("角色名验证成功").css('color','green');$('#rolename').css('border-color','green');
                    $.ajax({
                        url:'roleName',
                        type:'POST',
                        data:{'_token':'{{csrf_token()}}','rolename':rolename},
                        success:function(msg){
                            if (msg == 2) {
                                $('#rolename_info').text('角色名已存在').css('color','red');$('#rolename').css('border-color','red');
                                checkRolename = false;
                            }else{
                                checkRolename = true;
                            }
                        },
                        error:function(msg){
                            alert("服务器繁忙");
                        }
                    })
                }else{
                    $("#rolename_info").text("角色名必须由汉字、字母组成").css('color','red');$('#rolename').css('border-color','red');
                    checkRolename = false;
                }
            });

            //  复选框验证
            $("input[type='checkbox']").click(function(){

            });

            // 表单提交
            $('#submit').click(function(){
                if(checkRolename){
                    $('form').submit();
                }else{
                    return false;
                }
            });

        });

    </script>
    @yield('js')
    <!-- script> console.log('Hi!'); </script> -->
@stop