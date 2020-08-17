<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-compliment.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php echo $this->form->render($this) ?>

<script type="application/javascript">
$('submit').addEvent('click',function(){
	deleteparentcompliment();
});
	window.deleteparentcompliment = deleteparentcompliment = function(){
	 if(parent.document.getElementById("sesmember_compliment_<?php echo $this->compliment_id; ?>"))
 		parent.sesJqueryObject("#sesmember_compliment_<?php echo $this->compliment_id; ?>").remove() ;
	}
</script>