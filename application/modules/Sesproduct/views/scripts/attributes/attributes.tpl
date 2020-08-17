<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: attributes.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array(
	'product' => $this->product,
      ));	
?>

	<div class="estore_dashboard_content sesbm sesbasic_clearfix" style="min-height: 500px;">
<?php } ?>
   <div class="sesbasic_dashboard_form">
       <div class="clear sesbasic-form-cont">
           <h3><?php echo $this->translate('Product Attributions'); ?></h3>
           <p>
               <?php echo $this->translate('Below, you can create product attributes for your product.'); ?>
           </p>
           <br />
           <div class="admin_fields_options_addquestion">
               <a href="javascript:void(0);" onclick="void(0);" class="sesbasic_button"><i class="fa fa-plus"></i><?php echo $this->translate('Add Attributes'); ?></a>
           </div>
           <br />
           <ul class="admin_fields clear">
               <?php foreach ($this->secondLevelMaps as $map): ?>
               <?php echo $this->adminFieldMeta($map) ?>
               <?php endforeach; ?>
           </ul>
       </div>
       <?php echo $this->render('_attributesJS.tpl'); ?>
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
