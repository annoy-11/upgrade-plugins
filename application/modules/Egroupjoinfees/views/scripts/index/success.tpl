<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: success.tpl  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Egroupjoinfees/externals/styles/styles.css'); ?>

<div class="layout_middle">
	<div class="generic_layout_container layout_core_content">
  	<div class="sesgroup_fees_process_complete_page sesbasic_bxs">
    	<div class="sesgroup_fees_process_complete">
      	<?php if(empty($this->error)){ ?>
        	<i><img src="application/modules/Sesgroup/externals/images/success.png" alt="" /></i>
          <span class="_text"><?php echo $this->translate("Your order has been successfully completed."); ?></span>
        <?php }else{ ?>
        	<i><img src="application/modules/Egroupjoinfees/externals/images/fail.png" alt="" /></i>
          <span class="_text _error"><?php echo $this->error; ?></span>
        <?php } ?>
      </div>
      <div class="sesgroup_fees_process_complete_btn sesbasic_bxs sesbasic_clearfix">
        <a href="<?php echo $this->url(array('action'=>'view'), 'egroupjoinfees_user_order', true); ?>" class="sesbasic_link_btn floatL"><?php echo $this->translate("Go To My Order"); ?></a>
        <a href="<?php echo $this->url(array('action' => 'create', 'group_id' => $this->group->group_id),'sesgroup_join_group','true');?>" class="sesbasic_link_btn floatL"><?php echo $this->translate("Submit Entry"); ?></a>
      </div>
		</div>
  </div>
	</div>
