<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _mysigngrid.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (isset($signitem['epetition_id'])) {

  $categoryItem = Engine_Api::_()->getItem('epetition_category', $item['category_id']);
  ?>
    <ul class="epetition_listing_mysign sesbasic_clearfix clear" style="min-height:50px;">
        <li class="epetition_petition_list_item sesbasic_clearfix clear">
            <article class="sesbasic_clearfix sesbasic_bg">
                <div class="epetition_item_thumb epetition_listing_thumb" style="height:200px;width:461px;">
                    <a href="<?php echo $item->getHref(); ?>"
                       data-url="epetition" class="epetition_thumb_img">
                        <span style="background-image:url(<?php echo $item->getPhotoUrl('thumb.normal'); ?>);"></span>
                    </a>
                </div>
                <div class="epetition_item_info">
                    <ul>
                  <?php if ($petitiontitle_setting && !empty($item->getHref()) && !empty($item->getTitle())){ ?>
                    <div class="epetition_item_title">
                        <a title="<?php echo $item->getTitle(); ?>"
                           href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>
                    </div>
                      <?php } ?>
                      <?php if ($category_setting && !empty($categoryItem)) { ?>
                          <li><b>Category : </b><a
                                      href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
                          </li>
                      <?php } ?>
                      <?php if ($signaturelocation_setting) { ?>
                          <li><b>Location : </b><?php echo $signitem['location']; ?></li>
                      <?php } ?>
                      <?php if ($statement_setting) { ?>
                          <li><b>Support Statement : </b><?php echo $signitem['support_statement']; ?></li>
                      <?php } ?>
                      <?php if ($reason_setting) { ?>
                          <li><b>Support Reason : </b><?php echo $signitem['support_reason']; ?></li>
                      <?php } ?>
                      <?php if ($submissiondate_setting) { ?>
                          <li><b>Submission Date : </b><?php echo $signitem['creation_date']; ?></li>
                      <?php } ?>
                    </ul>
                </div>
            </article>
        </li>
    </ul>
<?php }  ?>