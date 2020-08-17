<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="sesbasic_breadcrumb">
    <a href="<?php echo $this->url(array('action' => 'browse'), 'ecoupon_general'); ?>"><?php echo $this->translate("Browse Coupon"); ?></a>&nbsp;&raquo;
    <a href="javascript:void(0)"><?php echo $this->subject->getTitle();?></a>
</div>
