<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Seslisting/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Listings Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Listings created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Listings:" ?><strong></td>
            <td><?php echo $this->totallisting; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Listings:" ?><strong></td>
            <td><?php echo $this->totalapprovedlisting; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Listings:" ?><strong></td>
            <td><?php echo $this->totallistingfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Listings:" ?><strong></td>
            <td><?php echo $this->totallistingsponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Listing Albums:" ?><strong></td>
            <td><?php echo $this->totalalbums; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Listing Photos:" ?><strong></td>
            <td><?php echo $this->totalphotos; ?></td>
          </tr>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')):?>
						<tr>
							<td><strong class="bold"><?php echo "Total Listing Videos:" ?><strong></td>
							<td><?php echo $this->totalvideos; ?></td>
						</tr>
          <?php endif;?>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totallistingrated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Listings:" ?><strong></td>
            <td><?php echo $this->totallistingverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Listings:" ?><strong></td>
            <td><?php echo $this->totallistingfavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totallistingcomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totallistingviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totallistinglikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
