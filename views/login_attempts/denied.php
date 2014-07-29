<p class="text-error"><?php echo __('Access denied for :period minutes.', array(
	':period' => $period
)); ?></p>

<script type="text/javascript">
$(function() {
	$('button[name="sign-in"]').remove();
})
</script>