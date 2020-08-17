<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: statistic.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Petitions Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Petitions created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Petitions:" ?><strong></td>
            <td><?php echo $this->totalpetition; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Petitions:" ?><strong></td>
            <td><?php echo $this->totalapprovedpetition; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Petitions:" ?><strong></td>
            <td><?php echo $this->totalpetitionfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Petitions:" ?><strong></td>
            <td><?php echo $this->totalpetitionsponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Close Petition:" ?><strong></td>
            <td><?php echo $this->totalclose; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Victory Petition:" ?><strong></td>
            <td><?php echo $this->totalvictory; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Petitions:" ?><strong></td>
            <td><?php echo $this->totalpetitionverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Petitions:" ?><strong></td>
            <td><?php echo $this->totalpetitionfavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totalpetitioncomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totalpetitionviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totalpetitionlikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
