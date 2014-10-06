<div class="panel-body no-padding-t">
	<div class="form-group form-inline">
		<div class="input-group">
			<input type="text" class="form-control" name="login[captcha]" value="" style="vertical-align: top; height: 42px;" size="6">
			<div class="input-group-addon no-padding">
				<img src="/captcha" style="cursor: pointer" onclick="this.src=&quot;/captcha?ssid=&quot; + Math.floor((Math.random() * 100) + 1)">
			</div>
		</div>
	</div>
</div>