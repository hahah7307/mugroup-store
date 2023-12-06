
{include file="public/header" /}

<style>
    .layui-body {left: 220px!important;}
    .layui-form-label {width: 100px!important;}
    .layui-form-item .layui-inline {margin-right: 0!important;}
    .layui-form-label {width: 160px!important;}
    .invisible {visibility: hidden}
    .w90 {width: 90px!important;}
    .deliver_num {width: 100px!important;}
    .layui-table {width: 50%; display: inline}
</style>
<div class="layui-body">
<div class="right">
    <a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
    <div class="title">库存预算</div>
    <div class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">查询日期</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input datetime w300" name="query_date" value="{$query_date}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">产品名称<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="product_name" value="{$info.product_name}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">产品SKU<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="product_sku" value="{$info.product_sku}">
                </div>
            </div>
        </div>
        {if condition="$id eq 0"}
        <div class="layui-form-item" id="sale-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">销量预估<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="month[]" placeholder="月份">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="sale[]" placeholder="销量">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="saleAdd">添加</button>
        </div>
        {else /}
        <?php $i = 0; ?>
        {foreach name="$info.sale_data" item="sale_data"}
        {if condition="$i eq 0"}
        <div class="layui-form-item" id="sale-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">销量预估<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="month[]" placeholder="月份" value="{$key}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="sale[]" placeholder="销量" value="{$sale_data}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="saleAdd">添加</button>
        </div>
        {else /}
        <div class="layui-form-item" id="sale-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label"></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="month[{$i}]" placeholder="月份" value="{$key}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="sale[{$i}]" placeholder="销量" value="{$sale_data}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button>
        </div>
        {/if}
        <?php $i++; ?>
        {/foreach}
        {/if}
        <div class="title" id="america-west">美国西部</div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">基础库存<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="w_basic_store" value="{$info.post_data.w_info.basic_store}">
                </div>
            </div>
        </div>
        {if condition="$id eq 0"}
        <div class="layui-form-item" id="w-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">发货详情<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="w_deliver_date[]" placeholder="日期">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="w_deliver_num[]" placeholder="发货量">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="wDeliverAdd">添加</button>
        </div>
        {else /}
        <?php $j = 0; ?>
        {foreach name="$info.post_data.w_info.deliver" item="deliver" key="jk"}
        {if condition="$j eq 0"}
        <div class="layui-form-item" id="w-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">发货详情<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="w_deliver_date[]" placeholder="日期" value="{$jk}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="w_deliver_num[]" placeholder="发货量" value="{$deliver}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="wDeliverAdd">添加</button>
        </div>
        {else /}
        <div class="layui-form-item" id="w-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label"></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="w_deliver_date[{$j}]" placeholder="日期" value="{$jk}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="w_deliver_num[{$j}]" placeholder="发货量" value="{$deliver}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button>
        </div>
        {/if}
        <?php $j++; ?>
        {/foreach}
        {/if}
        <div class="title" id="america-east">美国东部</div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">基础库存<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="e_basic_store" value="{$info.post_data.e_info.basic_store}">
                </div>
            </div>
        </div>
        {if condition="$id eq 0"}
        <div class="layui-form-item" id="e-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">发货详情<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="e_deliver_date[]" placeholder="日期">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="e_deliver_num[]" placeholder="发货量">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="eDeliverAdd">添加</button>
        </div>
        {else /}
        <?php $k = 0; ?>
        {foreach name="$info.post_data.e_info.deliver" item="deliver" key="kk"}
        {if condition="$k eq 0"}
        <div class="layui-form-item" id="e-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">发货详情<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="e_deliver_date[]" placeholder="日期" value="{$kk}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="e_deliver_num[]" placeholder="发货量" value="{$deliver}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm btn-lc" lay-submit lay-filter="eDeliverAdd">添加</button>
        </div>
        {else /}
        <div class="layui-form-item" id="e-deliver-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label"></label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input datetime" name="e_deliver_date[{$k}]" placeholder="日期" value="{$kk}">
                </div>
            </div>
            <div class="layui-inline layui-col-md1">
                <div class="layui-input-inline deliver_num">
                    <input type="text" class="layui-input w90" name="e_deliver_num[{$k}]" placeholder="发货量" value="{$deliver}">
                </div>
            </div>
            <button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button>
        </div>
        {/if}
        <?php $k++; ?>
        {/foreach}
        {/if}
        <div class="layui-form-item tl" id="btn-submit">
            <div class="layui-input-block">
                <button class="layui-btn w200 button" lay-submit lay-filter="formCoding">提交</button>
                <a href="{:url('add')}" class="layui-btn layui-btn-normal w200">重置</a>
            </div>
        </div>
    </div>
    {if condition="$id neq 0"}
    <div class="title">预算结果</div>
    <table class="layui-table">
        <colgroup>
            <col width="25%">
            <col width="25%">
        </colgroup>
        <thead>
        <tr>
            <th colspan="2" class="tc">美国西部</th>
        </tr>
        </thead>
        <tbody>
        {foreach name="$info.store_data.w" item="w_store"}
        <tr>
            <td class="tc">{:date('Y-m-d', strtotime($key))}</td>
            <td class="tc">{$w_store}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    <table class="layui-table">
        <colgroup>
            <col width="25%">
            <col width="25%">
        </colgroup>
        <thead>
        <tr>
            <th colspan="2" class="tc">美国西部</th>
        </tr>
        </thead>
        <tbody>
        {foreach name="$info.store_data.e" item="e_store"}
        <tr>
            <td class="tc">{:date('Y-m-d', strtotime($key))}</td>
            <td class="tc">{$e_store}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    {/if}
</div>
</div>
<script>
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');

    layui.use(['form', 'jquery', 'laydate'], function() {
        let $ = layui.jquery,
            form = layui.form,
            laydate = layui.laydate;

        function timeAdd(){
            lay('.datetime').each(function() {
                laydate.render({
                    elem : this,
                    trigger : 'click'
                });
            });
        }

        timeAdd();

        // 添加属性
        let saleIndex = {$info.sale_data|count} ? {$info.sale_data|count} - 1 : 0;
        form.on('submit(saleAdd)', function(data) {
            saleIndex ++;
            var new_attr =
                '<div class="layui-form-item" id="sale-item"><div class="layui-inline layui-col-md3"><label class="layui-form-label"></label><div class="layui-input-inline"><input type="text" class="layui-input" name="month[' + saleIndex + ']" placeholder="月份"></div></div><div class="layui-inline layui-col-md1"><div class="layui-input-inline deliver_num"><input type="text" class="layui-input w90" name="sale[' + saleIndex + ']" placeholder="销量"></div></div><button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button></div>';
            $("#america-west").before(new_attr);
            form.render();
            timeAdd();
            return false;
        });

        let wDeliverIndex = {$info.post_data.w_info.deliver|count} ? {$info.post_data.w_info.deliver|count} - 1 : 0;
        form.on('submit(wDeliverAdd)', function(data) {
            wDeliverIndex ++;
            var new_attr = '<div class="layui-form-item"><div class="layui-inline layui-col-md3"><label class="layui-form-label"></label><div class="layui-input-inline"><input type="text" class="layui-input datetime" name="w_deliver_date[' + wDeliverIndex + ']" placeholder="日期"></div></div><div class="layui-inline layui-col-md1"><div class="layui-input-inline deliver_num"><input type="text" class="layui-input w90" name="w_deliver_num[' + wDeliverIndex + ']" placeholder="发货量"></div></div><button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button></div></div>';
            $("#america-east").before(new_attr);
            form.render();
            timeAdd();
            return false;
        });

        let eDeliverIndex = {$info.post_data.e_info.deliver|count} ? {$info.post_data.e_info.deliver|count} - 1 : 0;
        form.on('submit(eDeliverAdd)', function(data) {
            eDeliverIndex ++;
            var new_attr = '<div class="layui-form-item"><div class="layui-inline layui-col-md3"><label class="layui-form-label"></label><div class="layui-input-inline"><input type="text" class="layui-input datetime" name="e_deliver_date[' + eDeliverIndex + ']" placeholder="日期"></div></div><div class="layui-inline layui-col-md1"><div class="layui-input-inline deliver_num"><input type="text" class="layui-input w90" name="e_deliver_num[' + eDeliverIndex + ']" placeholder="发货量"></div></div><button class="layui-btn layui-btn-sm layui-btn-danger btn-lc" lay-submit lay-filter="attrDel">删除</button></div></div>';
            $("#btn-submit").before(new_attr);
            form.render();
            timeAdd();
            return false;
        });

        // 删除属性
        form.on('submit(attrDel)', function(data) {
            $(this).parent().remove();
        });

        // 提交
        form.on('submit(formCoding)', function(data) {
            var text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            $.ajax({
                type:'POST',url:"{:url('add')}",data:data.field,dataType:'json',
                success:function(data){
                    if(data.code === 1){
                        layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
                            // location.href = "{:url('add', ['id' => " + data.id + "])}";
                            location.href = "/Manage/Store/add/id/" + data.id + ".html";
                        });
                    }else{
                        layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                            layer.closeAll();
                            $('button').attr('disabled',false);
                            button.text(text);
                        });
                    }
                }
            });
            return false;
        });
    });
</script>

{include file="public/footer" /}
