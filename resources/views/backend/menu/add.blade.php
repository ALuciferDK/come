@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>权限管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/backend/home"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">权限管理</font></font>
            </a>
            <>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">权限添加</font></font>
        </li>
    </ol>
@stop

@section('content_header')
    <h1>权限管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">权限管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">权限添加</font></font>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限添加</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{URL::asset('Power/add')}}" method="post">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">菜单名称</font></font></label>
                    <input type="text" class="form-control" name="menu_name"  id="menuname">
                    <span id="menu_name_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">菜单路径</font></font></label>
                    <input type="text" class="form-control" name="url"  id="url">
                    <span id="url_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">选择父级菜单</font></font></label>
                    <div class="checkbox" style="margin-left:20px;">
                        <select name="p_id" id="">
                            <option value="0">请选择父级菜单</option>
                            @foreach($menuData as $key => $value)
                                <div style="margin-left:3rem;">
                                    <option value="{{$value['menu_id']}}">{{$value['html']}}{{$value['menu_name']}}</option>
                                </div>
                                <div style="margin:1rem 0 1rem 0;margin-left:4rem;">
                                    @foreach($value['son'] as $key => $item)
                                        <label style="">
                                            <option value="{{$item['menu_id']}}">{{$item['html']}}{{$item['menu_name']}}</option>
                                        </label>
                                    @endforeach
                                </div>

                            @endforeach
                            <span id="role_info"></span>
                        </select>
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

            var checkMenuname = '';

            //  用户名验证
            $("#menuname").blur(function(){
                var menuname = $(this).val();
                regular = /^[\u4E00-\u9FA5]{2,20}$/;
                if (menuname == '') {
                    $('#menu_name_info').text('菜单不能为空').css('color','red');$('#menuname').css('border-color','red');
                    checkMenuname = false;
                }else if (regular.test(menuname)) {
                    $('#menu_name_info').text("菜单验证成功").css('color','green');$('#menuname').css('border-color','green');
                    $.ajax({
                        url:'menuName',
                        type:'POST',
                        data:{'_token':'{{csrf_token()}}','menuname':menuname},
                        success:function(msg){
                            if (msg == 2) {
                                $('#menu_name_info').text('菜单已存在').css('color','red');$('#menuname').css('border-color','red');
                                checkMenuname = false;
                            }else{
                                checkMenuname = true;
                            }
                        },
                        error:function(msg){
                            alert("服务器繁忙");
                        }
                    })
                }else{
                    $("#menu_name_info").text("菜单必须由汉字").css('color','red');$('#menuname').css('border-color','red');
                    checkMenuname = false;
                }
            });
            $("#url").blur(function(){
                var url = $(this).val();
                regular = /^[A-Za-z]{2,20}\/[A-Za-z]{2,20}$/;
                if (url == '') {
                    $('#url_info').text('URL不能为空').css('color','red');$('#url').css('border-color','red');
                    checkMenuname = false;
                }else if (regular.test(url)) {
                    $('#url_info').text("URL验证成功").css('color','green');$('#url').css('border-color','green');
                    $.ajax({
                        url:'menuUrl',
                        type:'POST',
                        data:{'_token':'{{csrf_token()}}','url':url},
                        success:function(msg){
                            if (msg == 2) {
                                $('#url_info').text('URL已存在').css('color','red');$('#url').css('border-color','red');
                                checkMenuname = false;
                            }else{
                                checkMenuname = true;
                            }
                        },
                        error:function(msg){
                            alert("服务器繁忙");
                        }
                    })
                }else{
                    $("#url_info").text("URL必须可用").css('color','red');$('#url').css('border-color','red');
                    checkMenuname = false;
                }
            });
            //  复选框
            // 表单提交
            $('#submit').click(function(){
                if(checkMenuname){
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