<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create-content.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sestour/views/scripts/dismiss_message.tpl';?>
<div class="sestour_search_reasult">
	<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestour', 'controller' => 'manage', 'action' => 'manage-widgets','id'=>$this->tour_id, 'page_id' => $this->page_id), $this->translate("Back to Manage Tour Tips") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>