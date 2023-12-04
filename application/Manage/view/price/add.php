
{include file="public/header" /}

<style>
    .layui-body {left: 220px!important;}
    .layui-form-label {width: 100px!important;}
    .layui-form-item .layui-inline {margin-right: 0!important;}
    .layui-form-label {width: 160px!important;}
</style>
<div class="layui-body">
<div class="right">
    <a href="{:session('manage.back_url')}" class="layui-btn layui-btn-danger layui-btn-sm fr"><i class="layui-icon">&#xe603;</i>返回上一页</a>
    <div class="title">核价模板</div>
    <div class="layui-form">
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装长(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="length" id="length" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('length')}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装宽(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="width" id="width" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('width')}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">包装高(cm)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="height" id="height" onkeyup="value=value.replace(/^\D*(\d*(?:\.\d{0,2})?).*$/g, '$1')" value="{:input('height')}">
                </div>
            </div>
            <div class="red layui-text" id="red-warn" style="line-height:36px"></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">毛重(kg)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="gross_weight" value="{:input('gross_weight')}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">采购成本(¥)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="cost" value="{:input('cost')}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">最低市场售价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="min_price" value="{:input('min_price')}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">目标定价($)<span class="red">*</span></label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="target_pricing" value="{:input('target_pricing')}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">头程价格标准(元/CBM)</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="flp_standard" value="{:input('flp_standard', 500)}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">关税率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="tariff_rate" value="{:input('tariff_rate', 0.25)}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">汇率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="exchange_rate" value="{:input('exchange_rate', 6.95)}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">派送方式</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="delivery" value="{:input('delivery', 'FBM')}">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">广告费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="ad_rate" value="{:input('ad_rate', 0.1)}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">退货率</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="return_rate" value="{:input('return_rate', 0.05)}">
                </div>
            </div>
            <div class="layui-inline layui-col-md3">
                <label class="layui-form-label">平台费占比</label>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" class="layui-input w300" name="platform_rate" value="{:input('platform_rate', 0.15)}">
                </div>
            </div>
        </div>
        <div class="layui-form-item tr">
            <div class="layui-input-block">
                <button class="layui-btn w100 button" lay-submit lay-filter="formCoding">提交</button>
                <a href="{:url('add')}" class="layui-btn layui-btn-normal w100">重置</a>
                <button class="layui-btn layui-btn-normal w100" lay-submit lay-filter="formSave">保存</button>
                <a id="export" href="" class="layui-btn layui-btn-normal w100">导出</a>
            </div>
        </div>
    </div>
</div>

{if condition="($show_reason == 1)"}
<div class="right">
    <div class="title"><b class="black">一号仓</b></div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积(m³)</label>
                <div class="layui-text-inline">{$volume}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">毛重(lbs)</label>
                <div class="layui-text-inline">{$gross_weight_lbs}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积重(lbs)</label>
                <div class="layui-text-inline">{$volume_lbs}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装箱数</label>
                <div class="layui-text-inline">1</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装柜数</label>
                <div class="layui-text-inline">{$loading_qty}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">FOB成本($)</label>
                <div class="layui-text-inline">{$fob}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本($)</label>
                <div class="layui-text-inline">{$initial_cost}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税($)</label>
                <div class="layui-text-inline">{$tariff}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">4个月仓储费($)</label>
                <div class="layui-text-inline">{$liang_storage_charge}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">尾程($)</b></label>
                <div class="layui-text-inline" id="liang_tail_end"><b class="black">{$liang_tail_end}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本占比</label>
                <div class="layui-text-inline">{$initial_cost_rate|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税占比</label>
                <div class="layui-text-inline">{$tariff_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">仓储费占比</label>
                <div class="layui-text-inline">{$liang_storage_charge_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">尾程占比</label>
                <div class="layui-text-inline">{$liang_tail_end_proportion|decimal2percentage}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">广告费($)</label>
                <div class="layui-text-inline">{$advertising_expenses}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">退货费($)</label>
                <div class="layui-text-inline">{$return_fee}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">平台费($)</label>
                <div class="layui-text-inline">{$platform_fees}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">零利润售价($)</b></label>
                <div class="layui-text-inline"><b class="black">{$liang_no_profit_price}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$liang_min_selling_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$liang_min_selling_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label w200"><b class="black">目标定价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$liang_target_pricing_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$liang_target_pricing_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
    </div>

    <div class="title"><b class="black">二号仓</b></div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积(m³)</label>
                <div class="layui-text-inline">{$volume}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">毛重(lbs)</label>
                <div class="layui-text-inline">{$gross_weight_lbs}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">体积重(lbs)</label>
                <div class="layui-text-inline">{$volume_lbs}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装箱数</label>
                <div class="layui-text-inline">1</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">装柜数</label>
                <div class="layui-text-inline">{$loading_qty}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">FOB成本($)</label>
                <div class="layui-text-inline">{$fob}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本($)</label>
                <div class="layui-text-inline">{$initial_cost}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税($)</label>
                <div class="layui-text-inline">{$tariff}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">4个月仓储费($)</label>
                <div class="layui-text-inline">{$loctek_storage_charge}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">尾程($)</b></label>
                <div class="layui-text-inline" id="loctek_tail_end"><b class="black">{$loctek_tail_end}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">头程成本占比</label>
                <div class="layui-text-inline">{$initial_cost_rate|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">关税占比</label>
                <div class="layui-text-inline">{$tariff_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">仓储费占比</label>
                <div class="layui-text-inline">{$loctek_storage_charge_proportion|decimal2percentage}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">尾程占比</label>
                <div class="layui-text-inline">{$loctek_tail_end_proportion|decimal2percentage}</div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">广告费($)</label>
                <div class="layui-text-inline">{$advertising_expenses}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">退货费($)</label>
                <div class="layui-text-inline">{$return_fee}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label">平台费($)</label>
                <div class="layui-text-inline">{$platform_fees}</div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">零利润售价($)</b></label>
                <div class="layui-text-inline"><b class="black">{$loctek_no_profit_price}</b></div>
            </div>
        </div>
    </div>
    <div class="layui-row">
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$loctek_min_selling_profit}</b></b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">最低售价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$loctek_min_selling_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润($)</b></label>
                <div class="layui-text-inline"><b class="black">{$loctek_target_pricing_profit}</b></div>
            </div>
        </div>
        <div class="layui-col-md3">
            <div class="layui-form-item">
                <label class="layui-form-label"><b class="black">目标定价利润率</b></label>
                <div class="layui-text-inline"><b class="black">{$loctek_target_pricing_profit_rate|decimal2percentage}</b></div>
            </div>
        </div>
    </div>
</div>
{/if}
</div>
<script>
    layui.config({
        base: '/static/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');

    layui.use(['form', 'jquery'], function() {
        let $ = layui.jquery,
            form = layui.form;

        const urlParams = JSON.stringify({$jsonData});
        let excelUrl = "{:url('excel')}" + "?data=" + urlParams;
        $("#export").attr("href", excelUrl);

        let length = $("#length").val(),
            width = $("#width").val(),
            height = $("#height").val();
        $(function(){
            $("#length").on("input",function(e){
                length = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Price/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        $(function(){
            $("#width").on("input",function(e){
                width = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Price/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        $(function(){
            $("#height").on("input",function(e){
                height = e.delegateTarget.value;
                $.ajax({
                    type: 'POST',
                    url: "{:url('Price/ajaxLengthRule')}",
                    data: {
                        length: length,
                        width: width,
                        height: height
                    },
                    success: function(res) {
                        if(res.code === 2){
                            $("#red-warn").html(res.info);
                        } else {
                            $("#red-warn").html('');
                        }
                    }
                });
            });
        });

        //
        $("#liang_tail_end").click(function(){
            layer.alert("{$liang_tail_end_count}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        //
        $("#loctek_tail_end").click(function(){
            layer.alert("{$loctek_tail_end_count}",{
                title: "费用详情",
                icon: 7,
                area: ['500px', '180px'],
                btn: ['关闭'],
                btnAlign: 'c'
            });
        });

        // 提交
        form.on('submit(formCoding)', function(data) {
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            let arr = [];
            $.each(data.field, function(index,value){
                console.log("jQuery-each方法遍历数组：",index,value);
                arr.push(index + "=" + value);
            })
            let urlData;
            urlData = arr.join("&");
            location.href = "{:url('add')}?" + urlData;
        });

        // 保存
        form.on('submit(formSave)', function(data) {
            data.field.data = '{$jsonData}';
            let text = $(this).text(),
                button = $(this);
            $('button').attr('disabled',true);
            button.text('请稍候...');
            axios.post("{:url('save')}", data.field)
                .then(function (response) {
                    var res = response.data;
                    if (res.code === 1) {
                        layer.alert(res.msg,{icon:1,closeBtn:0,title:false,btnAlign:'c',},function(){
                            location.reload();
                        });
                    } else {
                        layer.alert(res.msg,{icon:2,closeBtn:0,title:false,btnAlign:'c'},function(){
                            layer.closeAll();
                            $('button').attr('disabled',false);
                            button.text(text);
                        });
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            return false;
        });
    });
</script>

{include file="public/footer" /}
