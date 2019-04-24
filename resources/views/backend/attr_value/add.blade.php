@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>属性管理</h1>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性添加</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="{{URL::asset('AttrValue/add')}}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性名称</font></font></label>
                    <select class="from-control" name="attr_id" id="attr_id">
                        @foreach($attrData as $key => $value)
                            <option value="{{$value->attr_id}}">{{$value->attr_name}}</option>
                        @endforeach
                    </select>
                    <span id="a_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性值名称</font></font></label>
                    <input type="text" class="form-control" name="value_name"  placeholder="Attrname" id="value_name">
                    <span id="v_info"></span>
                </div>
            </div>
            <!-- /.box-body -->

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
        </form>
    </div>
@stop
@section('css')
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <!-- script> console.log('Hi!'); </script> -->
    <script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
    <script>
        var checkName = '';
        $('#value_name').blur(function () {
            var name = $(this).val();
            var preg = /^[\u4e00-\u9fa5]{1,10}$/;
            if(name == '')
            {
                $('#v_info').text('属性值名称不能为空').css('color','red');$('#value_name').css('border-color','red');
                checkName = false;
            }
            else if(preg.test(name))
            {
                $('#v_info').text('通过').css('color','green');$('#value_name').css('border-color','green');
                $.ajax({
                    url:'attrValueName',
                    type:'POST',
                    data:{'_token':'{{csrf_token()}}','value_name':name},
                    success:function(msg){
                        if (msg == 2) {
                            $('#v_info').text('属性值已存在').css('color','red');$('#value_name').css('border-color','red');
                            checkName = false;
                        }else{
                            $('#v_info').text('通过').css('color','green');$('#value_name').css('border-color','green');
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
                $('#v_info').text('属性值名称是2-10个汉字').css('color','red');$('#value_name').css('border-color','red');
                checkName = false;
            }
        });
        $('#reset').click(function () {
            checkName = false;
            $('#v_info').text('属性值名称不能为空').css('color','red');$('#value_name').css('border-color','red');
        });

        $('#btn').click(function(){
            if(checkName == false)
            {
                return false;
            }else
            {
                $('form').submit();
            }
        });
    </script>

@stop