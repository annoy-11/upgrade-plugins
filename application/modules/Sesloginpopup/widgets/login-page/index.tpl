<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->page == 1){ ?>
 <?php include APPLICATION_PATH .  '/application/modules/Sesloginpopup/views/scripts/page1.tpl'; ?>
<?php }else if($this->page == 2){ ?>
 <?php include APPLICATION_PATH .  '/application/modules/Sesloginpopup/views/scripts/page2.tpl'; ?>
<?php }else if($this->page == 3){ ?>
 <?php include APPLICATION_PATH .  '/application/modules/Sesloginpopup/views/scripts/page3.tpl'; ?>
<?php }else{ ?>
 <?php include APPLICATION_PATH .  '/application/modules/Sesloginpopup/views/scripts/page4.tpl'; ?>
 <?php } ?>