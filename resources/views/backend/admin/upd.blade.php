@extends('adminlte::page')
@section('title', '小米商城后台管理')
@section('content')
    <form action="{{URL::asset('Admin/Admin/upd')}}" method="post">
        @csrf
        <div class="box box-primay">
                <div class="form-group" style="height: 45px;">
                    <label class="col-sm-2 control-label" for="a_name">管理员角色</label>
                    <div class="col-sm-10">
                        @foreach($roleData as $key => $item)
                            <input type="checkbox" class="from-control" name="role[]" value="{{$item['role_id']}}">{{$item['role_name']}}
                        @endforeach
                        <span id="r_info"></span>
                    </div>
                </div>
                <div class="form-group" style="height: 45px;">
                    <div class="col-sm-10">
                            <input type="hidden" class="from-control" name="a_id" value="{{$a_id}}">
                        <span id="r_info"></span>
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