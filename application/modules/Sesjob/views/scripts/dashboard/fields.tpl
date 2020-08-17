<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: fields.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
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
  echo $this->partial('dashboard/left-bar.tpl', 'sesjob', array('job' => $this->job));	
?>
	<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	<div class="sesbasic_dashboard_form">
		<?php echo $this->form->render() ?>  
	</div>
<?php if(!$this->is_ajax) { ?>
	</div>
<?php } ?>

