<section class="ynq-footer">
	<div width="1200px">
		<div class="ynq-footer-menu">
			{foreach name="navigation" item="navi" key="k"}
			{if condition="$k neq 0"}<span>|</span>{/if}<a href="{$navi.nav_url}">{$navi.nav_name}</a>
			{/foreach}
		</div>
		<p>地址：{$website.address}</p>
		<p>联系电话：{$website.telephone}&nbsp;&nbsp;&nbsp;&nbsp;传真：{$website.fax}</p>
		<p>{$website.copyrights}<a href="https://beian.miit.gov.cn/">{$website.icp}</a>       <a href="http://www.shimaotong.net" target="_blank">Powered by Shimaotong.net</a></p>
	</div>
		<a href="javascript:;" class="ynq-gotop" radius="3"><i class="fa fa-angle-double-up"></i><span>TOP</span></a>
		<a href="javascript:;" class="ynq-gotop2" radius="3"><i class="fa fa-angle-double-up"></i><span>TOP</span></a>
</section>
</body>
</html>
<script type="text/javascript">
	var _maq = _maq || [];
	_maq.push(['_setAccount', 'Ningbo Suntek']);
	(function() {
	var ma = document.createElement('script'); ma.type = 'text/javascript'; ma.async = true;
	ma.src = '/static/home/js/analytics.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ma, s);
	})();
</script>
