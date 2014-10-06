<div class="panel-heading">
	<h3><?php echo __('General settings'); ?></h3>
</div>

<div class="panel-body">
	<div class="form-group">
		<label class="control-label col-md-3"><?php echo __('Period of blocking (min.)'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[period]', $plugin->get('period'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-md-3"><?php echo __('Limit of user attempts'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[max_attempts]', $plugin->get('max_attempts'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="control-label col-md-3"><?php echo __('Limit of user attempts for showing captcha'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[max_attempts_for_captcha]', $plugin->get('max_attempts_for_captcha'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>
</div>

<div class="panel-heading">
	<h3><?php echo __('IP settings'); ?></h3>
</div>
<div class="panel-body">
	<div class="form-group">
		<label class="control-label col-md-3"><?php echo __('Blocked IP'); ?></label>
		<div class="controls">
			<?php echo Form::select('setting[blocked_ip][]', $plugin->allowed_ip_list(), $plugin->blocked_ip_list(), array(
				'multiple' => TRUE, 
				'class' => 'input-block-level'
				)); 
			?>
		</div>
	</div>
</div>
