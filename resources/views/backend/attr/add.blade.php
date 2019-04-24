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
                    <font style="vertical-align: inherit;">属性管理</font></font>
            </a>
            <>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">属性添加</font></font>
        </li>
    </ol>
@stop
@section('content')
    <form action="{{URL::asset('Attr/add')}}" method="post" enctype="multipart/form-data">
        <div class="box box-primay">
            <div class="box-header with-border"><h3>属性添加</h3></div>
            <div class="box-body" style="margin-left: 30%;">
                @csrf
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">属性名称</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="attr_name" id="attr_name">
                        <span id="a_info"></span>
                    </div>
                </div>
            <div class="box-footer">
                <div style="margin-left: 20%">
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

        $('#attr_name').blur(function () {
            var name = $(this).val();
            var preg = /^[\u4e00-\u9fa5]{1,10}$/;
            if(name == '')
            {
                $('#a_info').text('属性名称不能为空').css('color','red');$('#attr_name').css('border-color','red');
                checkName = false;
            }
            else if(preg.test(name))
            {
                $('#a_info').text('通过').css('color','green');$('#attr_name').css('border-color','green');
                $.ajax({
                    url:'attrName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','attr_name':name},
                    success:function(msg){
                        if (msg == 2) {
                            $('#a_info').text('属性已存在').css('color','red');$('#attr_name').css('border-color','red');
                            checkName = false;
                        }else{
                            $('#a_info').text('通过').css('color','green');$('#attr_name').css('border-color','green');
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
                $('#a_info').text('属性名称是2-10个汉字').css('color','red');$('#attr_name').css('border-color','red');
                checkName = false;
            }
        });

        $('#reset').click(function () {
            checkName = false;
        });

        $('#btn').click(function(){
            if(checkName == false )
            {
                return false;
            }else
            {
                $('form').submit();
            }
        });

    </script>
@stop