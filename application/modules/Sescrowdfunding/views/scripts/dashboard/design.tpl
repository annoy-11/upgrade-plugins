<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sescrowdfunding', array(
	'crowdfunding' => $this->crowdfunding,
      ));	
?>
  <div class="sescrowdfunding_dashboard_content sesbm sesbasic_clearfix">
<?php }?>
  <div class="sescrowdfunding_dashboard_form sescrowdfunding_dashboard_designs_form"><?php echo $this->form->render() ?></div>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
