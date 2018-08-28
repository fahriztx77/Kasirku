<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter X Laravel!</title>
	<script type="text/javascript" src="http://www.trevi.zo/panel_assets/js/core/libraries/jquery.min.js"></script>
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	<data style="display: none;">
		<string name="app_name">CodeIgniter X Laravel</string>
		<string name="app_version">{{ CI_VERSION }}</string>
	</data>
</head>
<body>

<div id="container">
	<h1>Selamat Datang, di <appname></appname>!</h1>
	<div id="body">
		<p>Halaman yang anda lihat adalah hasil dari View Laravel Blade.</p>

		<p>Jika anda ingin edit halaman ini, anda bisa masuk ke:</p>
		<code>application/views/website/welcome.blade.php</code>

		<p>Fungsi halaman ini dapat anda temukan di: <appname></appname></p>
		<code>application/controllers/Welcome.php</code>
	</div>
	<p class="footer">Best Regrads, <strong>Xeon Team</strong>.{!! (ENVIRONMENT === 'development') ?  ' Use CodeIgniter Version <strong><appversion></appversion></strong>' : '' !!}</p>
</div>

<script type="text/javascript">
	$("appname").html(get('string','app_name'));
	$("appversion").html(get('string','app_version'));

	function get(tag,name){
		if(tag=="string"){
			return $(tag+"[name="+name+"]").text();
		}
	}
</script>
</body>
</html>