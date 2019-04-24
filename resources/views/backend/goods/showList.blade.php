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
                    <font style="vertical-align: inherit;">商品管理</font></font>
            </a>
            <>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">商品展示</font></font>
        </li>
    </ol>
@stop
@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">管理员列表</font></font></h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mailbox-controls">
            <button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            <button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
        </div>
        <table class="table table-hover table-striped">
            <tr align="center">
                <td></td>
                <td>商品名称</td>
                <td>商品价格</td>
                <td>商品图片</td>
                <td>商品分类</td>
                <td>是否上架</td>
                <td>是否明星产品</td>
                <td>操作</td>
            </tr>
            @foreach ($goodsData as $key => $value)
                <tr align="center">
                    <td><input type="checkbox" name=""></td>
                    <td>{{$value->g_name}}</td>
                    <td>{{$value->g_price}}</td>
                    <td><img src="/img/{{$value->g_img}}" alt="图片正在加载" width="30px" height="30px"></td>
                    <td>{{$value->type_name}}</td>
                    <td>
                        @if($value->is_sale == 1)
                            <span class="label label-success"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">已上架</font></font></span>
                        @else
                            <span class="label label-danger"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">未上架</font></font>
                    </span>
                        @endif
                    </td>
                    <td>
                        @if($value->g_start == 1)
                            <span class="label label-success">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">是</font>
                                </font>
                            </span>
                        @else
                            <span class="label label-danger">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">否</font>
                                </font>
                            </span>
                        @endif
                    </td>
                    <td>
                        @if(!Session::get('button'))
                            <td><a href="#" class="label label-danger">不可操作</a></td>
                        @else
                            @foreach(Session::get('button') as $but => $b_value)
                                @if($b_value['url'] == 'Admin/del')
                                    <a href="/admin/del?id={{$value->g_id}}" class="label label-success">删除</a>
                                @elseif($b_value['url'] == 'Admin/upd')
                                    <a href="/Admin/upd?id={{$value->g_id}}" class="label label-warning">修改</a>
                                @else

                                @endif
                            @endforeach
                            @endif
                    </td>

                </tr>
            @endforeach
            {{ $goodsData->links() }}
        </table>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
    <script>

    </script>
@stop
