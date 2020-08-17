<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _addToCart.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php
$memberAllowed = Engine_Api::_()->sesproduct()->memberAllowedToBuy($this->item);
$sellerAllowed = Engine_Api::_()->sesproduct()->memberAllowedToSell($this->item);

if($memberAllowed && $sellerAllowed){
  $productLink = Engine_Api::_()->sesproduct()->productPurchaseable($this->item);
if(!empty($productLink['status'])){ ?>
<a href="<?php echo $productLink['href']; ?>" data-action="<?php echo $this->item->product_id; ?>" class="add-cart<?php echo $productLink['class']; ?>" title="<?php echo $this->translate('Add to Cart'); ?>">
    <?php if(!empty($this->icon)){ ?>
        <i class="fa fa-shopping-cart"></i>
    <?php }else{ ?>
        <?php echo $this->translate("Add to Cart"); ?>
    <?php } ?>
</a>
<?php }
}
?>
