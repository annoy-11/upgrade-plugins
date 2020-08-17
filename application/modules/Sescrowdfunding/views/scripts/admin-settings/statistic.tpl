<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Crowdfunding Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Crowdfunding created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Crowdfunding:" ?><strong></td>
            <td><?php echo $this->totalcrowdfunding; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Crowdfunding:" ?><strong></td>
            <td><?php echo $this->totalcrowdfundingfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Crowdfunding Albums:" ?><strong></td>
            <td><?php echo $this->totalalbums; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Crowdfunding Photos:" ?><strong></td>
            <td><?php echo $this->totalphotos; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totalcrowdfundingrated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totalcrowdfundingcomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totalcrowdfundingviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totalcrowdfundinglikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
