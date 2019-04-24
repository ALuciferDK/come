@extends('adminlte::page')

@section('title', '小米商城后台管理')

@section('content_header')
    <h1>商品管理</h1>
    <ol class="breadcrumb">
        <li>
            <a href="/home/index"><i class="fa fa-dashboard"></i>
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">后台管理</font></font>
            </a>
        </li>
        <li>
            <a href="#"><font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">商品管理</font></font>
            </a>
        </li>
        <li class="active">
            <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">商品添加</font></font>
        </li>
    </ol>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品添加</font></font></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form action="add" method="post" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品名称</font></font></label>
                    <input type="text" class="form-control" name="g_name" id="g_name" placeholder="GoodsName">
                    <span id="goodsname_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品分类</font></font></label>
                    <select name="type_id" id="type_id"  class="form-control" onchange="typeAttr()">
                        <option value="0">请选择分类</option>
                        @foreach($typeData as $key => $value)
                            <option value="{{$value['type_id']}}"><?php echo $value['html'].$value['type_name']?></option>
                            @foreach($value['son'] as $key => $item)
                                <option value="{{$item['type_id']}}"><?php echo $item['html'].$item['type_name']?></option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group attr" hidden >
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品属性</font></font></label>
                    <select class="form-control select2 select2-hidden-accessible" id="attr" name="attrs[]" multiple="" data-placeholder="请选择属性" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="attrValue()"></select>
                </div>

                <div class="form-group value" hidden>
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品属性值</font></font></label>
                    <div class="checkbox" id="attr_value" style="margin-left:4rem;">
                        <span id="attr_info"></span>
                    </div>
                </div>

                <div class="form-group diker" hidden id="diker">
                        <button type="button" onclick="Diker()">生成货品</button>
                </div>

                <div class="form-group goodssku" hidden>
                    <div class="box-header">
                        <h3 class="box-title">货品清单</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr id="tr">
                                <th>组合类型</th>
                                <th>货品编号</th>
                                <th>库存</th>
                                <th>价格</th>
                                <th>操作</th>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品描述</font></font></label>
                    <div id="editor">
                        <p>欢迎使用富文本编辑器</p>
                    </div>
                    <textarea id="g_info" style="width:100%; height:200px;" name="g_info" hidden></textarea>
                    <span id="i_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品库存</font></font></label>
                    <input type="text" class="form-control" name="g_inventory" id="g_inventory"  placeholder="Inventory">
                    <span id="inventory_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品价格</font></font></label>
                    <input type="text" class="form-control" name="g_price" id="g_price"  placeholder="GoodsPrice">
                    <span id="price_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">促销价格</font></font></label>
                    <input type="text" class="form-control" name="promotion_price" id="promotion_price"  placeholder="PromotionPrice">
                    <span id="promotion_info"></span>
                </div>

                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否新品</font></font></label>
                    <p style="margin-left:2rem;">
                        <input type="radio" name="is_new" id="is_new" value="1">新品
                        <input type="radio" name="is_new" id="is_new" value="0">旧品
                    </p>
                    <span id="new_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">是否上架</font></font></label>
                    <p style="margin-left:2rem;">
                        <input type="radio" name="is_sale" id="is_sale" value="1">上架
                        <input type="radio" name="is_sale" id="is_sale" value="0">下架
                    </p>
                    <span id="sale_info"></span>
                </div>
                <div class="form-group">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">商品图片</font></font></label>
                    <input type="file" name="g_img" id="g_img">
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button class="btn btn-primary" id="reset"  type="reset">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">重置</font></font>
                </button>
                <button type="submit" class="btn btn-primary" id="submit">
                    <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">提交</font></font>
                </button>
            </div>
        </form>
    </div>
    <!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/wangEditor.min.js')}}/"></script>
    <script>

        //   用户信息验证
        $(document).ready(function(){

            var checkGoodsName = '';
            var checkDesc = '';
            var checkAttr = '';
            var checkPrice = '';
            var checkPromotion = '';
            var checkInventory = '';

            /*
            * 商品名称验证
            * */
            $("#g_name").blur(function(){
                var goods_name = $(this).val();
                regular = /^[\u4E00-\u9FA5A-Za-z0-9]{2,20}$/;
                if (goods_name == '') {
                    $('#goodsname_info').text('商品名称不能为空').css('color','red');$('#g_name').css('border-color','red');
                    checkGoodsName = false;
                }else if (regular.test(goods_name)) {
                    $('#goodsname_info').text('商品名称验证成功').css('color','green');$('#g_name').css('border-color','green');
                    $.ajax({
                        url:'goodsName',
                        data:{'_token':'{{csrf_token()}}','g_name':goods_name},
                        type:'POST',
                        success:function(msg){
                            if (msg == 2) {
                                $('#goodsname_info').text('商品名已存在').css('color','red');$('#g_name').css('border-color','red');
                                checkGoodsName = false;
                            }else{
                                $('#goodsname_info').text('商品名称验证成功').css('green','red');$('#g_name').css('border-color','green');
                                checkGoodsName = true;
                            }
                        },
                        error:function(msg){
                            alert("服务器繁忙");
                        }
                    })
                }else{
                    $("#goodsname_info").text("商品名必须由汉字、字母组成").css('color','red');$('#g_name').css('border-color','red');
                    checkGoodsName = false;
                }
            });


            //  富文本编译器
            var Editor = window.wangEditor;
            var editor = new Editor('#editor');
            var goodsDesc = $('#g_info');
            editor.customConfig.onchange = function (html) {
                goodsDesc.val(html);                            // 监控变化，同步更新到 textarea
            };
            editor.customConfig.showLinkImg = false;            // 隐藏“网络图片”tab
            editor.customConfig.uploadImgShowBase64 = true;     // 使用 base64 保存图片
            editor.customConfig.uploadImgMaxLength = 5;         // 限制一次最多上传 5 张图片
            editor.create();
            goodsDesc.val(editor.txt.html());                   // 初始化 textarea 的值

            //  下拉框多选
            $('.select2').select2();

            //  商品库存验证
            $("#g_inventory").blur(function(){
                var goods_inventory = $(this).val();
                if (goods_inventory == '') {
                    $('#inventory_info').text('商品库存不能为空').css('color','red');$("#g_inventory").css('border-color','red');
                    checkInventory = false;
                }else{
                    $('#inventory_info').text('商品库存验证成功').css('color','green');$("#g_inventory").css('border-color','green');
                    checkInventory = true;
                }
            });

            // 商品属性值验证
            $("input[type='checkbox']").click(function(){
                var test = $("input[name='values[]']:checked");
                if (test.length == 0) {
                    $('#attr_info').text('请选择属性值').css('color','red');$("input[type='checkbox']").css('border-color','red');
                    checkAttr = false;
                }else{
                    $('#attr_info').text('属性值已选').css('color','green');$("input[type='checkbox']").css('border-color','green');
                    checkAttr = true;
                }
            });

            //  商品价格验证
            $("#g_price").blur(function(){
                var goods_price = $(this).val();
                if (goods_price == '') {
                    $('#price_info').text('商品价格不能为空').css('color','red');$("#g_price").css('border-color','red');
                    checkPrice = false;
                }else{
                    $('#price_info').text('商品价格验证成功').css('color','green');$("#g_price").css('border-color','green');
                    checkPrice = true;
                }
            });

            //  促销价格验证
            $("#promotion_price").blur(function(){
                var promotion_price = $(this).val();
                if (promotion_price == '') {
                    $('#promotion_info').text('促销价格不能为空').css('color','red');$("#promotion_price").css('border-color','red');
                    checkPromotion = false;
                }else{
                    $('#promotion_info').text('促销价格验证成功').css('color','green');$("#promotion_price").css('border-color','green');
                    checkPromotion = true;
                }
            });

            // 表单提交
            $('#submit').click(function(){
                if(checkGoodsName && checkPrice && checkPromotion && checkInventory){
                    $('form').submit();
                }else{
                    return false;
                }
            });


            /*$("#type_id").blur(function(){

            })*/

        });
        //  根据分类查询属性
        function typeAttr()
        {
            var type_id = $("#type_id").val();    //  获取到分类的ID
            $.ajax({
                url:'goodsType',
                data:{'_token':'{{csrf_token()}}','type_id':type_id},
                type:'POST',
                dataType:'json',
                success:function(msg){
                    if(msg == 3)
                    {
                        $('.attr').hide();
                    }
                    else
                    {
                        $('.attr').show();
                        var option_html = '';
                        for (var i in msg) {
                            option_html += '<option value="'+ msg[i].attr_id+'">'+ msg[i].attr_name+'</option>';
                        }
                        $("#attr").html(option_html);
                    }

                }
            })
        }

        //  根据属性查询属性值
        function attrValue()
        {
            var attr_id = $("#attr").val();
            $.ajax({
                url:'goodsValue',
                data:{'_token':'{{csrf_token()}}','attr_id':attr_id},
                type:'POST',
                dataType:'json',
                success:function(msg){
                    if(msg == 3)
                    {
                        $('.value').hide();
                    }
                    else
                    {
                        $(".value").show();
                        var input_checkbox = '';
                        for (var i in msg) {
                            input_checkbox += '<input type="checkbox" class="from-control" name="values[]" value="'+ msg[i].value_id+'" id="cb_all" onclick="checkButton()">'+ msg[i].value_name+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                        $("#attr_value").html(input_checkbox);
                    }

                }
            })
        }
        function checkButton() {
            var chk_value =[];
            $('input[name="values[]"]:checked').each(function(){
                chk_value.push($(this).val());
            });
            if(chk_value =='' )
            {
                $(".diker").hide();
                $(".goodssku").hide();
            }
            else
            {
                $(".diker").show();
            }

        }

        function Diker() {
            $(".goodssku").show();
            var chk_value =[];
            $('input[name="values[]"]:checked').each(function(){
                chk_value.push($(this).val());
            });
            $.ajax({
                url:'getValue',
                data:{'_token':'{{csrf_token()}}','value_id':chk_value},
                type:'POST',
                dataType:'json',
                success:function(msg){
                    if(msg == 2){
                        $(".diker").hide();
                    }else{

                        var skuName = '';
                        for(var i in msg){
                            skuName += "<tr><td><input name='sku_name[]' type='text' readonly  value='" + msg[i].value_name + "'>" +
                                "<input name='sku_attr[]' type='hidden' readonly  value='" + msg[i].value_id + "'></td>" +
                                "<td><input name='sku_number[]' type='text' readonly  value='" + 'AYF' + new Date().getTime() + Math.floor(Math.random()*10) + "'></td>" +
                                "<td><input name='sku_inventory[]' type='text' value='9999'></td>" +
                                "<td><input name='sku_price[]' value='0' type='text'></td>" +
                                "<td><a href='/Goods/skuDelete?goods_id=val->goods_id' class='label label-danger'>删除</a></td>" +
                                "</tr>";
                        }
                        $(".table  tr:not(:first)").remove();
                        $("#tr").after(skuName);;
                    }
                }
            })

        }


    </script>
    @yield('js')
    <!-- script> console.log('Hi!'); </script> -->
@stop