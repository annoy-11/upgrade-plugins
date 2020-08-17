<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Businesses Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Businesses created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusiness ? $this->totalbusiness : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Businesses:" ?></strong></td>
            <td><?php echo $this->totalapprovedbusiness ? $this->totalapprovedbusiness : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusinessfeatured ? $this->totalbusinessfeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusinessesponsored ? $this->totalbusinessesponsored : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusinesshot ? $this->totalbusinesshot : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusinessverified ? $this->totalbusinessverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Businesses:" ?></strong></td>
            <td><?php echo $this->totalbusinessfavourite ? $this->totalbusinessfavourite : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalbusinesscomments ? $this->totalbusinesscomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalbusinessviews ? $this->totalbusinessviews : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalbusinesslikes ? $this->totalbusinesslikes : 0; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Followers:" ?></strong></td>
            <td><?php echo $this->totalbusinessfollowers ? $this->totalbusinessfollowers : 0; ?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </form>
</div>
