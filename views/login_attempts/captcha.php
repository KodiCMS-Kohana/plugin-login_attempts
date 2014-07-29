<div class="control-group">
	<div class="input-append">
		<input type="text" class="input-small input-title" name="login[captcha]" value="" style="vertical-align: top; height: 30px;">
		<img src="/captcha" style="cursor: pointer" onclick="this.src=&quot;/captcha?ssid=&quot; + Math.floor((Math.random() * 100) + 1)">
	</div>
</div>

