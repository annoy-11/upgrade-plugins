<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->featuredLabelActive) && $store->featured):?>
<span class="estore_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></span>
<?php endif;?>
<?php if(isset($this->sponsoredLabelActive) && $store->sponsored):?>
<span class="estore_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><?php echo $this->translate('Sponsored');?></span>
<?php endif;?>
<?php if(isset($this->hotLabelActive) && $store->hot):?>
<span class="estore_label_hot" title="<?php echo $this->translate('Hot');?>"><?php echo $this->translate('Hot');?></span>
<?php endif;?>
