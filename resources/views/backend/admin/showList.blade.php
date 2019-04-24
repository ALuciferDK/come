@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content_header')
    <h1>管理员管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/backend/home"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">管理员管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">管理员列表</font></font>
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
                <td>管理员名称</td>
                <td>管理员邮箱</td>
                <td>管理员手机</td>
                <td>添加人</td>
                <td>超级管理员</td>
                <td>是否冻结</td>
                <td>最后登录时间</td>
                <td>操作</td>
            </tr>
            @foreach ($adminData as $key => $value)
                <tr align="center">
                    <td><input type="checkbox" name=""></td>
                    <td>{{$value->a_name}}</td>
                    <td>{{$value->a_email}}</td>
                    <td>{{$value->a_mobile?:'此管理员手机号码未知'}}</td>
                    <td>{{$value->create_name}}</td>
                    <td>
                        @if($value->a_is_super == 1)
                            <span class="label label-danger"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">超级管理员</font></font></span>
                        @else
                            <span class="label label-success"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">普通管理员</font></font>
                    </span>
                        @endif
                    </td>
                    <td>
                        @if($value->a_is_freeze == 1)
                            <span class="label label-success"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">可使用</font></font></span>
                        @else
                            <span class="label label-danger"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">冻结</font></font>
                    </span>
                        @endif
                    </td>
                    <td>{{$value->a_login_time}}</td>
                    @if($value->a_is_super == 1)
                        <td><a href="#" class="label label-danger">不可操作</a></td>
                    @else
                        @if(!Session::get('button'))
                            <td><a href="#" class="label label-danger">不可操作</a></td>
                        @else
                            @foreach(Session::get('button') as $but => $b_value)
                                <td>
                                    @if($b_value['url'] == 'Admin/del')
                                        <a href="/admin/del?id={{$value->a_id}}" class="label label-success">删除</a>
                                    @elseif($b_value['url'] == 'Admin/upd')
                                        <a href="/Admin/upd?id={{$value->a_id}}" class="label label-warning">修改</a>
                                    @else

                                    @endif
                                </td>
                            @endforeach
                        @endif
                    @endif
                </tr>
            @endforeach
            {{ $adminData->links() }}
        </table>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
    <script>

    </script>
@stop
