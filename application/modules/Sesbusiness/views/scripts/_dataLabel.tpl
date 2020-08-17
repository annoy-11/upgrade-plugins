<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->featuredLabelActive) && $business->featured):?>
<span class="sesbusiness_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->sponsoredLabelActive) && $business->sponsored):?>
<span class="sesbusiness_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->hotLabelActive) && $business->hot):?>
<span class="sesbusiness_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
