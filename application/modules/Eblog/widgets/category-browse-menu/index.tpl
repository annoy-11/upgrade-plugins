<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?> 
<?php foreach($this->categories as $key => $item) { ?>
  <?php $item = Engine_Api::_()->getItem('eblog_category', $key); ?>
  <a href="<?php echo $item->getHref(); ?>"><?php echo $item->category_name; ?></a>
<?php } ?>
