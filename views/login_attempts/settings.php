<div class="widget-header">
	<h3><?php echo __('General settings'); ?></h3>
</div>

<div class="widget-content">
	<div class="control-group">
		<label class="control-label"><?php echo __('Period of blocking (min.)'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[period]', $plugin->get('period'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label"><?php echo __('Limit of user attempts'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[max_attempts]', $plugin->get('max_attempts'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label"><?php echo __('Limit of user attempts for showing captcha'); ?></label>
		<div class="controls">
			<?php echo Form::input('setting[max_attempts_for_captcha]', $plugin->get('max_attempts_for_captcha'), array(
				'class' => 'input-mini'
			)); ?>
		</div>
	</div>
</div>

<div class="widget-header">
	<h3><?php echo __('IP settings'); ?></h3>
</div>
<div class="widget-content">
	<div class="control-group">
		<label class="control-label"><?php echo __('Blocked IP'); ?></label>
		<div class="controls">
			<?php echo Form::select('setting[blocked_ip][]', $plugin->allowed_ip_list(), $plugin->blocked_ip_list(), array(
				'multiple' => TRUE, 
				'class' => 'input-block-level'
				)); 
			?>
		</div>
	</div>
</div>
