<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: fields.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
  /* Include the common user-end field switching javascript */
  echo $this->partial('_jsSwitch.tpl', 'fields', array(
    //'topLevelId' => (int) @$this->topLevelId,
    //'topLevelValue' => (int) @$this->topLevelValue
  ));
?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sesblog', array('blog' => $this->blog));	
?>
	<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	<div class="sescrowdfunding_dashboard_form">
		<?php echo $this->form->render() ?>  
	</div>
<?php if(!$this->is_ajax) { ?>
	</div>
<?php } ?>

