<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		{if condition="$info neq null"}
		<title>{if condition="$info.seo_title"}{$info.seo_title}{else/}宁波鄞州区五金工具国际商会{/if}</title>
		<meta name="keywords" content="{$info.seo_keyword}"/>
		<mate name="description" content="{$info.seo_description}"/>
		{else/}
		<title>{if condition="$info.seo_title"}{$website.seo_title}{else/}宁波鄞州区五金工具国际商会{/if}</title>
		<meta name="keywords" content="{$website.seo_keyword}"/>
		<mate name="description" content="{$website.seo_description}"/>
		{/if}
		<link rel="stylesheet" href="/static/home/css/css.css">
		<script src="/static/home/js/jquery.min.js" type="text/javascript"></script>
		<script src="/static/home/js/layui/layui.js" type="text/javascript"></script>
		<script src="/static/home/js/ft-carousel.min.js" type="text/javascript"></script>
		<script src="/static/home/js/main.js" type="text/javascript"></script>
	</head>
	<body>
<!--新样式-->
<section class="ynq-header" pc>
	<div width="1200px">
		<div class="ynq-header-tools" flex="">
			<a href="{:jump('Member/page')}">入会申请</a>
			<!-- |<div class="ynq-search-btn">
				<a href="javascript:;"><i class="fa fa-search"></i></a>
				<div class="ynq-header-search">
					<form action="">
						<input type="text" name="keyword" placeholder="请输入关键字">
						<button><i class="fa fa-search"></i></button>
					</form>
				</div>
			</div> -->
		</div>
	</div>
	
	<div width="1200px" flex="">
		<div class="ynq-headerlogo"><a href="/"><img src="{$website.logo|imageurl_to_path}" alt=""></a></div>
		<div class="ynq-header-menu">
			<ul flex="" class="ynq-header-menunav">
				{foreach name="navigation" item="navi"}
				<li><a href="{$navi.nav_url}">{$navi.nav_name}</a>
					{if condition="$navi.dropdown eq 1"}
					<ul class="ynq-headerSmnav">
						{foreach name="$navi.child" item="nav"}
						<li><a href="{$nav.nav_url}">{$nav.nav_name}</a></li>
						{/foreach}
					</ul>
					{/if}
				</li>
				{/foreach}
			</ul>
		</div>
    </div>
</section>

<section class="ynq-mob-header" flex="" mob>
	<div class="ynq-moblie-logo"><img src="{$website.logo|imageurl_to_path}" alt=""></div>
	<div class="ynq-mob-menu" flex="">
		<div class="ynq-mob-search"><a href="javascript:;"><i class="fa fa-search"></i></a>
		<div class="ynq-mob-searchform">
			<form action="">
				<input type="text" name="keyword" placeholder="请输入关键字">
				<button><i class="fa fa-search"></i></button>
			</form>
		</div>
		</div>
		<div class="ynq-mob-nav"><a href="javascript:;"><i class="fa fa-bars"></i></a>
		 <ul class="ynq-mob-navlist">
			{foreach name="navigation" item="navi"}
			<li><a href="{$navi.nav_url}">{$navi.nav_name}</a>
				{if condition="$navi.dropdown eq 1"}
				<ul class="ynq-mob-smnav">
					{foreach name="$navi.child" item="nav"}
					<li><a href="{$nav.nav_url}">{$nav.nav_name}</a></li>
					{/foreach}
				</ul>
				{/if}
			</li>
			{/foreach}
		 </ul>
		</div>
	</div>
</section>