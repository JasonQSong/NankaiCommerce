<?php if (!defined('THINK_PATH')) exit();?><script type="text/javascript" language="javascript">
<?php if($UploadException == ''): ?>parent.HiddenUploadImage_callback(true,"<?php echo ($ImagePath); ?>");
<?php else: ?>
	parent.HiddenUploadImage_callback(false,<?php echo ($UploadException); ?>);<?php endif; ?>
</script>