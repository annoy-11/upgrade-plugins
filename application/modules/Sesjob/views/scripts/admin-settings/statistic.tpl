<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Jobs Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Jobs created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Jobs:" ?><strong></td>
            <td><?php echo $this->totaljob; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Jobs:" ?><strong></td>
            <td><?php echo $this->totalapprovedjob; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Jobs:" ?><strong></td>
            <td><?php echo $this->totaljobfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Jobs:" ?><strong></td>
            <td><?php echo $this->totaljobsponsored; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Jobs:" ?><strong></td>
            <td><?php echo $this->totaljobverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Jobs:" ?><strong></td>
            <td><?php echo $this->totaljobfavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totaljobcomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totaljobviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totaljoblikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
