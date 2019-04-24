@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>商品分类管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">属性管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">属性列表</font></font>
        </li>
    </ol>
@stop

@section('css')
    <link rel="stylesheet" href="{{URL::asset('bootstrap/css/bootstrap.css')}}">
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">属性列表</font></font></h3>
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
            <a href="{{asset('type/insert')}}" class="label label-primary">添加分类</a>
        </div>
        <table class="table table-hover table-striped">
            <tr align="left">
                <td>分类ID</td>
                <td>属性名称</td>
                <td>操作</td>
            </tr>
            @foreach ($attrData as $key => $value)
                <tr align="left">
                    <td>{{$value->attr_id}}</td>
                    <td>{{$value->attr_name}}</td>
                    <td>
                        @if(!Session::get('button'))
                            <td><a href="#" class="label label-danger">不可操作</a></td>
                        @else
                            @foreach(Session::get('button') as $but => $b_value)
                                @if($b_value['url'] == 'Attr/del')
                                    <a href="/Attr/del?id={{$value->attr_id}}" class="label label-success">删除</a>
                                @elseif($b_value['url'] == 'Type/upd')
                                    <a href="/Attr/upd?id={{$value->attr_id}}" class="label label-warning">修改</a>
                                @else

                                @endif
                            @endforeach
                        @endif
                    </td>

                </tr>
            @endforeach
        </table>
        {{$attrData->links()}}
    </div>
@stop

