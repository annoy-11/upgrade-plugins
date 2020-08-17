<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
    $navigation = $this->navigation;
    if($this->popupdesign == 1){ 
      include('popup/popup1.tpl');
    }
?>
<?php if($this->popupdesign == 2){ 
      include('popup/popup2.tpl');
      }
?>
<?php if($this->popupdesign == 3){ 
      include('popup/popup3.tpl');
      }
?>
<?php if($this->popupdesign == 4){ 
      include('popup/popup4.tpl');
      }
?>
<?php if($this->popupdesign == 5){ 
      include('popup/popup5.tpl');
      }
?>
<?php if($this->popupdesign == 6){ 
      include('popup/popup6.tpl');
      }
?>
<?php if($this->popupdesign == 7){ 
      include('popup/popup7.tpl');
      }
?>
<?php if($this->popupdesign == 8){ 
      include('popup/popup8.tpl');
      }
?>
<?php if($this->popupdesign == 9){ 
      include('popup/popup9.tpl');
      }
?>
<?php if($this->popupdesign == 10){ 
      include('popup/popup10.tpl');
      }
?>
