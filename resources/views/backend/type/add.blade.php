@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content_header')
    <h1>商品管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/backend/home"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">分类管理</font></font>
            </a>
            <>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">分类添加</font></font>
        </li>
    </ol>
@stop
@section('content')
    <form action="{{URL::asset('Type/add')}}" method="post" enctype="multipart/form-data">
        <div class="box box-primay">
            <div class="box-header with-border"><h3>分类添加</h3></div>
            <div class="box-body" style="margin-left: 30%;">
                @csrf
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">分类名称</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="type_name" id="type_name">
                        <span id="n_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">分类url</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="type_url" id="type_url">
                        <span id="u_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品图片</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="file" name="type_image" id="type_image" required="required">
                        <span id="i_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">父级分类</label>
                    <div class="col-sm-10">
                        <select class="from-control" name="p_id" id="p_id">
                            <option value="0">不选默认一级分类</option>
                            @foreach($typeData as $key => $value)
                                <option value="{{$value['type_id']}}">{{$value['type_name']}}</option>
                            @endforeach
                        </select>
                        <span id="p_info"></span>
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
        var checkImg = '';
        var checkUrl = '';
        var checkParent='';

        $('#type_name').blur(function () {
            var name = $(this).val();
            var preg = /^[\u4e00-\u9fa5]{1,10}$/;
            if(name == '')
            {
                $('#n_info').text('分类名称不能为空').css('color','red');$('#type_name').css('border-color','red');
                checkName = false;
            }
            else if(preg.test(name))
            {
                $('#n_info').text('通过').css('color','green');$('#type_name').css('border-color','green');
                $.ajax({
                    url:'typeName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','type_name':name},
                    success:function(msg){
                        if (msg == 2) {
                            $('#n_info').text('分类已存在').css('color','red');$('#type_name').css('border-color','red');
                            checkName = false;
                        }else{
                            $('#n_info').text('通过').css('color','green');$('#type_name').css('border-color','green');
                            checkName = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                });
                checkName = true;
            }
            else
            {
                $('#n_info').text('分类名称是2-10个汉字').css('color','red');$('#type_name').css('border-color','red');
                checkName = false;
            }
        });

        $("#type_url").blur(function(){
            var url = $(this).val();
            regular = /^[A-Za-z]{2,20}\/[A-Za-z]{2,20}$/;
            if (url == '') {
                $('#u_info').text('URL不能为空').css('color','red');$('#type_url').css('border-color','red');
                checkUrl = false;
            }else if (regular.test(url)) {
                $('#u_info').text("URL验证成功").css('color','green');$('#type_url').css('border-color','green');
                $.ajax({
                    url:'typeUrl',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','type_url':url},
                    success:function(msg){
                        if (msg == 2) {
                            $('#u_info').text('URL已存在').css('color','red');$('#type_url').css('border-color','red');
                            checkUrl = false;
                        }else{
                            checkUrl = true;
                        }
                    },
                    error:function(msg){
                        alert("服务器繁忙");
                    }
                })
            }else{
                $("#u_info").text("URL必须可用").css('color','red');$('#type_url').css('border-color','red');
                checkUrl = false;
            }
        });

        $('#type_image').change(function () {
            var img = $(this).val();
            if(img == '')
            {
                $('#i_info').text('图片不能为空').css('color','red');$('#type_image').css('border-color','red');
                checkImg = false;
            }
            else
            {
                $('#i_info').text('图片通过').css('color','green');$('#type_image').css('border-color','green');
                checkImg = true;
            }
        });
        $('#p_id').change(function () {

                $('#p_info').text('类型选择通过').css('color','green');$('#p_id').css('border-color','green');
                checkParent = true;
        });

        $('#reset').click(function () {
            checkName = false;
            checkUrl = false;
            checkImg = false;

            $('#n_info').text('分类名称不能为空').css('color','red');$('#type_name').css('border-color','red');
            $('#u_info').text('URL不能为空').css('color','red');$('#type_url').css('border-color','red');
            $('#i_info').text('图片不能为空').css('color','red');$('#type_image').css('border-color','red');
            $('#p_info').text('类型选择通过').css('color','green');$('#p_id').css('border-color','green');
        });

        $('#btn').click(function(){
            if(checkName == false  || checkImg == false || checkUrl == false)
            {
                return false;
            }else
            {
                $('form').submit();
            }
        });

    </script>
@stop