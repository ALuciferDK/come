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
                    <font style="vertical-align: inherit;">权限管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">权限列表</font></font>
        </li>
    </ol>
@stop
@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop
@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">权限列表</font></font></h3>
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
            <tr>
                <td>权限名称</td>
                <td>操作</td>
            </tr>

            @foreach ($menuData as $key => $value)
                <tr>
                    <td>{{$value['menu_name']}}</td>
                    <td>
                        @if(!Session::get('button'))
                            <td><a href="#" class="label label-danger">不可操作</a></td>
                        @else
                            @foreach(Session::get('button') as $but => $b_value)
                                @if($b_value['url'] == 'Power/del')
                                    <a href="/Power/del?m_id={{$value['menu_id']}}" class="label label-success">删除</a>
                                @elseif($b_value['url'] == 'Power/upd')
                                    <a href="/Power/upd?m_id={{$value['menu_id']}}" class="label label-warning">修改</a>
                                @else

                                @endif
                            @endforeach
                        @endif
                    </td>

                    @foreach($value['son'] as $k => $item)
                        <tr>
                            <td>|--{{$item['menu_name']}}</td>
                            <td>
                                @if(!Session::get('button'))
                                    <td><a href="#" class="label label-danger">不可操作</a></td>
                                @else
                                    @foreach(Session::get('button') as $but => $b_value)
                                        @if($b_value['url'] == 'Power/del')
                                            <a href="Menu/del?m_id={{$item['menu_id']}}" class="label label-success">删除</a>
                                        @elseif($b_value['url'] == 'Power/upd')
                                            <a href="Menu/upd?m_id={{$item['menu_id']}}" class="label label-warning">修改</a>
                                        @else

                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{URL::asset('js/jquery-1.7.2.min.js')}}"></script>
    <script>

    </script>
@stop
