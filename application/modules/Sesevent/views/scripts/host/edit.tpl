<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php echo $this->form->render($this); ?>

<script>
sesJqueryObject(document).on('submit','#edit-host',function(e){
	var hostnamevalue = document.getElementById('host_name').value;
	var letters = /^[A-Za-z]+$/;
	if(!hostnamevalue.match(letters)){
		 document.getElementById('msg').style.display = "block";
     return false;
	}
	document.getElementById('msg').style.display = "none";
	return true;
});
</script>