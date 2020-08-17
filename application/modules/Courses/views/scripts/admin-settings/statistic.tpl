<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
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
      <h3><?php echo $this->translate("Courses Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable Statistics for the Courses created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Courses:" ?></strong></td>
            <td><?php echo $this->totalCourse ? $this->totalCourse : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Courses:" ?></strong></td>
            <td><?php echo $this->totalApprovedCourse ? $this->totalApprovedCourse : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Courses:" ?></strong></td>
            <td><?php echo $this->totalFeaturedCourse ? $this->totalFeaturedCourse : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Courses:" ?></strong></td>
            <td><?php echo $this->totalSponsoredCourse ? $this->totalSponsoredCourse : 0; ?></td>
          </tr>
					<tr>
            <td><strong class="bold"><?php echo "Total Verified Courses:" ?></strong></td>
            <td><?php echo $this->totalVerifiedCourse ? $this->totalVerifiedCourse : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Courses:" ?></strong></td>
            <td><?php echo $this->totalVerifiedCourse ? $this->totalVerifiedCourse : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Courses:" ?></strong></td>
            <td><?php echo $this->totalFavouriteCourse ? $this->totalFavouriteCourse : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalCourseComment ? $this->totalCourseComment : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalCourseView ? $this->totalCourseView : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalCourseLike ? $this->totalCourseLike : 0; ?></td>
          </tr> 
					<tr>
            <td><strong class="bold"><?php echo "Total Lectures:" ?></strong></td>
            <td><?php echo $this->totalCourseLecture ? $this->totalCourseLecture : 0; ?></td>
          </tr>
					<tr>
            <td><strong class="bold"><?php echo "Total Courses Reviews:" ?></strong></td>
            <td><?php echo $this->totalcoursereviews ? $this->totalcoursereviews : 0; ?></td>
          </tr>
					<tr>
            <td><strong class="bold"><?php echo "Total Wishlists:" ?></strong></td>
            <td><?php echo $this->totalCourseWishlist ? $this->totalCourseWishlist : 0; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </form>
</div>
