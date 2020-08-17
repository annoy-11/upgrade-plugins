<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: statistic.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Classrooms Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable Statistics for the Classrooms created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroom ? $this->totalclassroom : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Classrooms:" ?></strong></td>
            <td><?php echo $this->totalapprovedclass ? $this->totalapprovedclass : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomfeatured ? $this->totalclassroomfeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomsponsored ? $this->totalclassroomsponsored : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomhot ? $this->totalclassroomhot : 0; ?></td>
          </tr>
					<tr>
            <td><strong class="bold"><?php echo "Total Sub Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomsub ? $this->totalclassroomsub : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomverified ? $this->totalclassroomverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Classrooms:" ?></strong></td>
            <td><?php echo $this->totalclassroomfeatured ? $this->totalclassroomfeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalclassroomcomments ? $this->totalclassroomcomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalclassroomview ? $this->totalclassroomview : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalclassroomlike ? $this->totalclassroomlike : 0; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Followers:" ?></strong></td>
            <td><?php echo $this->totalclassroomfollewers ? $this->totalclassroomfollewers : 0; ?></td>
          </tr> 
					<tr>
            <td><strong class="bold"><?php echo "Total Courses:" ?></strong></td>
            <td><?php echo $this->totalclassroomcourses ? $this->totalclassroomcourses : 0; ?></td>
          </tr>
					<tr>
            <td><strong class="bold"><?php echo "Total Classrooms Reviews:" ?></strong></td>
            <td><?php echo $this->totalclassroomreviews ? $this->totalclassroomreviews : 0; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>
