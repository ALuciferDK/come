@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content')
    <form action="{{URL::asset('Admin/add')}}" method="post">
        <div class="box box-primay">
            <div class="box-header with-border"><h3>管理员添加</h3></div>
            <div class="box-body" style="margin-left: 30%;">
                @csrf
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">管理员名称</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="a_name" id="a_name">
                        <span id="n_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">管理员邮箱</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="email" name="a_email" id="e_name">
                        <span id="e_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">管理员密码</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="password" name="a_password" id="p_name">
                        <span id="p_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">管理员角色</label>
                    <div class="col-sm-10">
                        @foreach($data as $key => $item)
                            <input type="checkbox" class="from-control" name="role[]" value="{{$item['role_id']}}">{{$item['role_name']}}
                        @endforeach
                            <span id="r_info"></span>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div style="margin-left: 40%">
                    <button class="btn btn-primary" id="reset"  type="reset">
                        <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">重置</font></font>
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn" >
                        <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提交</font></font>
                    </button>
                </div>
            </div>
        </div>
    </form>

    @stop
@section('js')
<script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
<script>
        var checkName = '';
        var checkPassword = '';
        var checkEmail = '';
        var checkPower = '';

        $('#a_name').blur(function () {
            var name = $(this).val();
            if(name == '')
            {
                $('#n_info').text('管理员名称不能为空').css('color','red');$('#a_name').css('border-color','red');
                checkName = false;
            }
            else
            {
                $('#n_info').text('通过').css('color','green');$('#a_name').css('border-color','green');
                checkName = true;
            }
        });
        $('#e_name').blur(function () {
            var name = $(this).val();
            if(name == '')
            {
                $('#e_info').text('邮箱不能为空').css('color','red');$('#e_name').css('border-color','red')
                checkEmail = false;
            }
            else
            {
                $('#e_info').text('通过').css('color','green');$('#e_name').css('border-color','green');
                checkEmail = true;
            }
        });
        $('#p_name').blur(function () {
            var name = $(this).val();
            if(name == '')
            {
                $('#p_info').text('密码不能为空').css('color','red');$('#p_name').css('border-color','red')
                checkPassword = false;
            }
            else
            {
                $('#p_info').text('通过').css('color','green');$('#p_name').css('border-color','green');
                checkPassword = true;
            }
        });
        // 多选框验证
        $("input[type='checkbox']").click(function(){
            var test = $("input[name='role[]']:checked");
            if (test.length == 0) {
                $('#r_info').text('请选择角色').css('color','red');
                checkPower = false;
            }else{
                $('#r_info').text('通过').css('color','green');
                checkPower = true;
            }
        });
        $('#reset').click(function () {
            checkName = false;
            checkPassword = false;
            checkEmail = false;
            checkPower = false;
            $('#p_info').text('密码不能为空').css('color','red');$('#p_name').css('border-color','red')
            $('#n_info').text('管理员名称不能为空').css('color','red');$('#a_name').css('border-color','red');
            $('#r_info').text('请选择角色').css('color','red');$("input[type='checkbox']").css('border-color','red');
            $('#e_info').text('邮箱不能为空').css('color','red');$('#e_name').css('border-color','red')
        });

        $('#btn').click(function(){
            if(checkEmail == false || checkName == false || checkPassword == false || checkPower == false)
            {
                return false;
            }else
            {
                $('form').submit();
            }
        });

</script>
    @stop