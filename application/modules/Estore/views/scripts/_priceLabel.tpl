<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _priceLabel.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!empty($store->price) && $store->price != '') { ?>
  <div class="estore_pricelabel">
	<?php if($store->price_type == '1'){
		echo $this->translate('Price'); 
	}else{
		echo $this->translate('Starting Price'); 
	}?>
    <span class="price_val"><i class="fa fa-usd"></i><?php echo $store->price; ?></span>
  </div>
<?php } ?>
