<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="estore_view_status">
  <?php if($this->subject->status):?>
    <span class="_open"><?php echo $this->translate('Open');?></span>
  <?php else:?>
    <span class="_close"><?php echo $this->translate('Çlosed');?></span>
  <?php endif;?>
</div>
  

