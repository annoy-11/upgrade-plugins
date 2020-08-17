<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->featuredLabelActive) && $group->featured):?>
<span class="sesgroup_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->sponsoredLabelActive) && $group->sponsored):?>
<span class="sesgroup_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->hotLabelActive) && $group->hot):?>
<span class="sesgroup_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
<?php endif;?>