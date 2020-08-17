<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: _mysignlist.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(isset($signitem['epetition_id'])){
  $categoryItem = Engine_Api::_()->getItem('epetition_category', $item['category_id']);    ?>
    <li class="epetition_petition_grid_item_mysign sesbasic_bxs" style="width:307px;">
        <article class="sesbasic_bg">
            <div class="epetition_item_thumb epetition_listing_thumb" style="height:200px;">
                <a href="<?php echo $item->getHref();  ?>"
                   data-url="epetition" class="epetition_thumb_img">
                    <span style="background-image:url(<?php echo $item->getPhotoUrl('thumb.normal'); ?>);"></span>
                </a>
            </div>
            <div class="epetition_item_info">
              <?php if($petitiontitle_setting){  ?>
                  <div class="epetition_item_title">
                      <a title="<?php echo $item->getTitle();  ?>" href="<?php echo $item->getHref();?>"><?php echo $item->getTitle();  ?></a>
                  </div>
              <?php } ?>
                <ul>
                  <?php if ($category_setting && !empty($categoryItem)) { ?>
                      <li><b><?php  echo $this->translate("Category"); ?> : </b><a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a></li>
                  <?php } ?>
                  <?php if($signaturelocation_setting){  ?>
                      <li><b><?php  echo $this->translate("Location"); ?> : </b><?php echo $signitem['location'];  ?></li>
                  <?php } ?>
                  <?php if($statement_setting){  ?>
                      <li><b><?php  echo $this->translate("Support Statement"); ?> : </b><?php echo $signitem['support_statement'];  ?></li>
                  <?php } ?>
                  <?php if($reason_setting){  ?>
                      <li><b><?php  echo $this->translate("Support Reason"); ?> : </b><?php echo $signitem['support_reason'];  ?></li>
                  <?php } ?>
                  <?php if($submissiondate_setting){  ?>
                      <li><b><?php  echo $this->translate("Submission Date"); ?> : </b><?php echo $signitem['creation_date'];  ?></li>
                  <?php  } ?>
                </ul>

                <div class="epetition_item_des"></div>
            </div>
        </article>
    </li>
<?php }  ?>