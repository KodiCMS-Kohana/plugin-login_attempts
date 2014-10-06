<p class="alert alert-dark alert-danger no-margin-b"><?php echo __('Access denied for :period minutes.', array(
	':period' => $period
)); ?></p>

<script type="text/javascript">
$(function() {
	$('button[name="sign-in"]').remove();
})
</script>