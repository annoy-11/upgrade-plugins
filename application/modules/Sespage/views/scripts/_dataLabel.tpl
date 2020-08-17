<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->featuredLabelActive) && $page->featured):?>
<span class="sespage_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->sponsoredLabelActive) && $page->sponsored):?>
<span class="sespage_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
<?php endif;?>
<?php if(isset($this->hotLabelActive) && $page->hot):?>
<span class="sespage_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
<?php endif;?>