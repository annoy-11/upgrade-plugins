<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Courses
 * @package    Courses
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
<div class="courses_profile_earnings sesbasic_bxs sesbasic_clearfix">
  <div class="courses_profile_earnings_inner">
  <?php $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency(); ?>
     <ul>
        <li><?php echo $this->translate('Daily:'); ?><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->dailty->total_amount,$defaultCurrency); ?></span></li>
        <li><?php echo  $this->translate('Weekly:'); ?><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->weekly->total_amount,$defaultCurrency); ?></span></li>
        <li><?php echo  $this->translate('Monthly:'); ?><span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->monthly->total_amount,$defaultCurrency); ?></span></li>
        <li><?php echo  $this->translate('Yearly:'); ?> <span><?php echo Engine_Api::_()->courses()->getCurrencyPrice($this->yearly->total_amount,$defaultCurrency); ?></span></li>
     </ul>
  </div>
</div>
