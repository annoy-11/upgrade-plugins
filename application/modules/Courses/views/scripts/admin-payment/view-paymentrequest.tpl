<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: view-paymentrequest.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class="sesbasic_view_stats_popup">
  <h3>Statics of this entry </h3>
  <table>
    <tr>
      <?php $course = Engine_Api::_()->getItem('courses', $this->item->course_id); ?>
      <td><?php echo $this->translate('Course Title') ?>:</td>
      <td><?php if(!is_null($course->title) && $course->title != '') { ?>
       <a href="<?php echo $course->getHref(); ?>" target="_blank"><?php echo $course->getTitle(); ?></a>
       <?php
        } else { 
        echo "-";
        } ?>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Owner Name') ?>:</td>
      <td><?php echo $this->item->getOwner() ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Requested Amount') ?>:</td>
      <td><?php echo $this->item->currency_symbol.' '.$this->item->requested_amount ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Release Amount') ?>:</td>
      <td><?php echo $this->item->currency_symbol.' '.$this->item->release_amount ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('User Message') ?>:</td>
      <td><?php echo $this->item->user_message ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Admin Message') ?>:</td>
      <td><?php echo $this->item->admin_message ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('State') ?>:</td>
      <td><?php echo $this->item->state ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Gateway Type') ?>:</td>
      <td><?php echo $this->item->gateway_type ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Currency') ?>:</td>
      <td><?php echo $this->item->currency_symbol ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Creation Date') ?>:</td>
      <td><?php echo $this->item->creation_date; ;?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Release Date') ?>:</td>
      <td><?php echo $this->item->release_date; ;?></td>
    </tr>
  </table>
  <br />
  <button onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("Close") ?>
  </button>
</div>
