<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: contact-information.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax) { 
  echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array('crowdfunding' => $this->crowdfunding,      )); 
?>
	<div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
  <div class="sescrowdfunding_dashboard_form">
    <?php echo $this->form->render() ?>
  </div>
<?php if(!$this->is_ajax){ ?>
    </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>