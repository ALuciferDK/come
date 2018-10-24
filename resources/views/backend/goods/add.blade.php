@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content')
    <form action="{{URL::asset('Goods/add')}}" method="post" enctype="multipart/form-data">
        <div class="box box-primay">
            <div class="box-header with-border"><h3>商品添加</h3></div>
            <div class="box-body" style="margin-left: 30%;">
                @csrf
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品名称</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="g_name" id="g_name">
                        <span id="n_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品价格</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="text" name="g_price" id="g_price">
                        <span id="r_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品图片</label>
                    <div class="col-sm-10">
                        <input class="from-control" type="file" name="g_img" id="g_img">
                        <span id="m_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品信息</label>
                    <div class="col-sm-10">
                        <input type="text" class="from-control" name="g_info" id="g_info">
                        <span id="i_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">商品信息</label>
                    <div class="col-sm-10">
                        <select class="from-control" name="type_id" id="type_id">
                            <option value="0">请选择分类</option>
                            @foreach($typeData as $key => $value)
                                <option value="{{$value['type_id']}}">{{$value['type_name']}}</option>
                            @endforeach
                        </select>
                        <span id="t_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">是否上架</label>
                    <div class="col-sm-10">
                        <input type="radio" class="from-control" name="g_state" value="0" id="g_off_state" checked>下架
                        <input type="radio" class="from-control" name="g_state" value="1" id="g_on_state">上架
                        <span id="s_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">是否明星产品</label>
                    <div class="col-sm-10">
                        <input type="radio" class="from-control" name="g_start" value="0" id="g_off_start" checked>不是
                        <input type="radio" class="from-control" name="g_start" value="1" id="g_on_start">是
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