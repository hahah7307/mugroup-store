
{include file="public/header" /}

<!-- 主体内容 -->
<div class="layui-body" id="LAY_app_body">
    <div class="right">
        <div class="title">核价列表</div>
        <form class="layui-form search-form" method="get">
            <div class="layui-inline w80">
                <select name="sort">
                    <option value="asc" {if condition="$sort eq 'asc'"}selected{/if}>正序</option>
                    <option value="desc" {if condition="$sort eq 'desc'"}selected{/if}>倒序</option>
                </select>
            </div>
            <div class="layui-inline w150">
                <select name="cid">
                    <option value="0">请选择分类</option>
                    {foreach name="category" item="cate"}
                    <option value="{$cate.id}" {if condition="$cid eq $cate['id']"}selected{/if}>{$cate.name}</option>
                    {/foreach}
                </select>
            </div>
            <div class="layui-inline w200">
                <input type="text" class="layui-input" name="keyword" value="{$keyword}" placeholder="搜索标题">
            </div>
            <div class="layui-inline">
                <button class="layui-btn" lay-submit lay-filter="Search"><i class="layui-icon">&#xe615;</i> 查询</button>
            </div>
            <div class="layui-inline">
                <a class="layui-btn layui-btn-normal" href="{:url('index')}"><i class="layui-icon">&#xe621;</i> 重置</a>
            </div>
        </form>

        <div class="layui-form">
            <a class="layui-btn" href="{:url('add')}">添加</a>
            <button class="layui-btn layui-btn-normal" lay-submit lay-filter="Sort">排序</button>
            <table class="layui-table">
                <colgroup>
                    <col width="50">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <col width="150">
                </colgroup>
                <thead>
                <tr>
                    <th class="tc">
                        <input type="checkbox" lay-skin="primary" id="YanNanQiu_checkall" lay-filter="YanNanQiu_checkall">
                    </th>
                    <th class="tc">长</th>
                    <th class="tc">宽</th>
                    <th class="tc">高</th>
                    <th class="tc">毛重</th>
                    <th class="tc">采购成本</th>
                    <th class="tc">最低市场价</th>
                    <th class="tc">目标定价</th>
                    <th class="tc">操作</th>
                </tr>
                </thead>
                <tbody>
                {foreach name="list" item="v"}
                <tr>
                    <td class="tc">
                        <div class="YanNanQiu_Checkbox">
                            <input type="checkbox" name="id[]" lay-skin="primary" lay-filter="imgbox" class="YanNanQiu_imgId" value="{$v.id}">
                        </div>
                    </td>
                    <td class="tc">{$v.length}</td>
                    <td class="tc">{$v.width}</td>
                    <td class="tc">{$v.height}</td>
                    <td class="tc">{$v.gross_weight}</td>
                    <td class="tc">{$v.cost}</td>
                    <td class="tc">{$v.min_price}</td>
                    <td class="tc">{$v.target_pricing}</td>
                    <td class="tc">
                        <a href="{:url('info', ['id' => $v.id])}" class="layui-btn layui-btn-sm">详情</a>
                        <button data-id="{$v.id}" class="layui-btn layui-btn-sm layui-btn-danger ml0" lay-submit lay-filter="Detele">删除</button>
                    </td>
                </tr>
                {/foreach}
                </tbody>
            </table>
            {$list->render()}
        </div>

    </div>
</div>
<script>
    layui.use(['form', 'jquery'], function(){
        var $ = layui.jquery,
            form = layui.form;

        // 排序
        form.on('submit(Sort)', function(data){
            var text = $(this).text(), button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            $.ajax({
                type:'POST',url:"{:url('sort')}",data:data.field,dataType:'json',
                success:function(data){
                    if(data.code == 1){
                        layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
                            location.reload();
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

        // 状态
        form.on('switch(formLock)', function(data){
            $('button').attr('disabled',true);
            $.ajax({
                type:'POST',url:"{:url('status')}",data:{id:data.value,type:'look'},dataType:'json',
                success:function(data){
                    if(data.code == 0){
                        layer.alert(data.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                            location.reload();
                        });
                    }
                }
            });
        });

        // 删除
        form.on('submit(Detele)', function(data){
            var text = $(this).text(),
                button = $(this),
                id = $(this).data('id');
            layer.confirm('确定删除吗？',{icon:3,closeBtn:0,title:false,btnAlign:'c'},function(){
                $('button').attr('disabled',true);
                button.text('请稍候...');
                $.ajax({
                    type:'POST',url:"{:url('delete')}",data:{id:id},dataType:'json',
                    success:function(data){
                        if(data.code == 1){
                            layer.alert(data.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c'},function(){
                                location.reload();
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
            });
        });
    });
</script>

{include file="public/footer" /}
