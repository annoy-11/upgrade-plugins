<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _addToCompare.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enablecomparision',1)) { ?>
<label>
    <?php $existsCompare = Engine_Api::_()->sesproduct()->checkAddToCompare($item);
    $compareData = Engine_Api::_()->sesproduct()->compareData($item); ?>
    <input type="checkbox" class="sesproduct_compare_change sesproduct_compare_product_<?php echo $item->getIdentity(); ?>" name="compare" <?php echo $existsCompare ? 'checked' : ''; ?> value="1" data-attr='<?php echo $compareData; ?>' />
    <span><?php echo $this->translate("Add To Compare"); ?></span>
    <span class="checkmark"></span>
</label>
<?php } ?>