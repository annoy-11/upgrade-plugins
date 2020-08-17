<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _stock.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<div class="sesproduct_availability<?php if(empty($lightStock)) { ?> sesbasic_text_light<?php } ?>">
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.purchasenote', 1)) {  ?>
    <?php if(Engine_Api::_()->sesproduct()->outOfStock($item)){  ?>
    <span class="in_stock">
        <i class="fa fa-circle"></i>&nbsp;<?php echo $this->translate("In Stock"); ?>&nbsp;
    </span>
    <?php }else{ ?>
     <span class="out_stock">
         <i class="fa fa-circle"></i>&nbsp;<?php echo $this->translate("Out of Stock"); ?>&nbsp;
     </span>
     <?php } ?>
<?php } ?>
</div>
