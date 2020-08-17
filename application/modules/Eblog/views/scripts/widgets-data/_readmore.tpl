<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $item = $this->item;
  $allParams = $this->allParams;
?>
<?php if(in_array('readmore', $allParams['show_criteria'])):?>
  <div class="eblog_list_readmore"><a class="eblog_animation" href="<?php echo $item->getHref();?>"><?php echo $this->translate('More');?></a></div>
<?php endif;?>
