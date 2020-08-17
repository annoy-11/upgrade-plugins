<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class="sesbasic_view_stats_popup">
  <h3><?php echo $this->translate("View Details"); ?> </h3>
  <table>
    <tr>
      <?php if($this->item->photo_id && Engine_Api::_()->storage()->get($this->item->photo_id, '')): ?>
      <?php $img_path = Engine_Api::_()->storage()->get($this->item->photo_id, '')->getPhotoUrl();
      $path = $img_path; 
      ?>
      <?php else: ?>
      <?php $path = $this->baseUrl() . '/application/modules/Courses/externals/images/nophoto_course_thumb_icon.png'; ?>
      <?php endif; ?>
      <td colspan="2"><a href="<?php echo $this->item->getHref(); ?>" target="_blank"><img src="<?php echo $path; ?>" style="height:75px; width:75px;"/></a></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Title') ?>:</td>
      <td><?php if(!is_null($this->item->title) && $this->item->title != '') {?>
        <a href="<?php echo $this->item->getHref(); ?>" target="_blank"><?php echo  $this->item->title ; ?></a>
        <?php
        } else { 
        echo "-";
        } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Owner') ?>:</td>
      <td><?php echo  $this->item->getOwner(); ?></td>
    </tr>
    <?php if($this->item->category_id != '' && intval($this->item->category_id) && !is_null($this->item->category_id)):
            $categoryItem = Engine_Api::_()->getItem('courses_category', $this->item->category_id);
     ?>
    <?php if($this->item->getType() == 'courses_classroom'): ?>
      <tr>
        <td><?php echo $this->translate('Number of courses') ?>:</td>
        <td><?php echo  $this->item->course_count; ?></td>
      </tr>
    <?php else: ?>
       <tr>
        <td><?php echo $this->translate('Lectures Count') ?>:</td>
        <td><?php echo  $this->item->lecture_count; ?></td>
      </tr>
    <?php endif; ?>
    <tr>
      <td><?php echo $this->translate('Category') ?>:</td>
      <td><a href="<?php echo $categoryItem->getHref(); ?>" target="_blank"><?php echo  $categoryItem->getTitle(); ?></a></td>
    </tr>
    <?php  endif; ?>
    <tr>
      <td><?php echo $this->translate('Featured') ?>:</td>
      <td><?php  if($this->item->featured == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Sponsored') ?>:</td>
      <td><?php  if($this->item->sponsored == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
     <tr>
      <td><?php echo $this->translate('Hot') ?>:</td>
      <td><?php  if($this->item->hot == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Verified') ?>:</td>
      <td><?php  if($this->item->verified == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <?php if($this->item->getType() == 'courses_classroom'): ?>
        <?php if(strtotime($this->item->enddate) < strtotime(date('Y-m-d')) && $this->item->offtheday == 1){ 
                    Engine_Api::_()->getDbTable('courses_classroom', 'courses')->update(array(
                        'offtheday' => 0,
                        'startdate' =>'',
                        'enddate' =>'',
                      ), array(
                        "classroom_id = ?" => $this->item->classroom_id,
                      ));
                      $itemofftheday = 0;
               }else
                $itemofftheday = $this->item->offtheday; ?>
    <?php else: ?>
         <?php if(strtotime($this->item->enddate) < strtotime(date('Y-m-d')) && $this->item->offtheday == 1){ 
              Engine_Api::_()->getDbTable('courses', 'courses')->update(array(
                  'offtheday' => 0,
                  'startdate' =>'',
                  'enddate' =>'',
                ), array(
                  "courses_id = ?" => $this->item->courses_id,
                ));
                $itemofftheday = 0;
          }else
            $itemofftheday = $this->item->offtheday; ?>
    <?php endif; ?>
    <tr>
      <td><?php echo $this->translate('Of the Day') ?>:</td>
      <td><?php  if($itemofftheday == 1){ ?>
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
        <img src="<?php echo $baseURL . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Comments') ?>:</td>
      <td><?php echo $this->item->comment_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Likes') ?>:</td>
      <td><?php echo $this->item->like_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Views') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->view_count) ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Date') ?>:</td>
      <td><?php echo $this->item->creation_date; ;?></td>
    </tr>
  </table>
  <br />
  <button onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("Close") ?>
  </button>
</div>
