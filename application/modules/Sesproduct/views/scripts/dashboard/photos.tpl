<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: photos.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(!$this->is_ajax){ 
echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array(
	'product' => $this->product,
      ));	
?>
	<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php } ?>
    	<div class="estore_dashboard_form">
      <div class="sesproduct_seo_add_product">
    		<?php echo $this->content()->renderWidget('sesproduct.profile-photos',array('widget_id'=>'876')); ?>
      </div>
    
<?php if(!$this->is_ajax){ ?>
  </div>
</div>
</div>
</div>
<?php  } ?>
<?php if($this->is_ajax) die; ?>
