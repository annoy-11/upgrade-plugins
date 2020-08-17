<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershipcard
 * @package    Sesmembershipcard
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: print.tpl  2019-02-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmembershipcard/externals/styles/style.css'); ?>
<link href="<?php $this->layout()->staticBaseUrl ?>application/modules/Sesmembershipcard/externals/styles/style.css" rel="stylesheet" media="print" type="text/css" />
<div class="sesmembershipcard_print_container">
	<?php echo $this->content()->renderWidget('sesmembershipcard.card', array('id' => $this->id)); ?>
	<div class="tip" style="margin-top:20px;float:none;"><span style="float:none;"><strong>Important:</strong> If background is not coming while printing it then Select background option in the setting.</span></div>
</div>
<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
	window.print();
	window.close();
});
</script>
