<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Edocument/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Documents Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Documents created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Documents:" ?><strong></td>
            <td><?php echo $this->totaldocument; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Documents:" ?><strong></td>
            <td><?php echo $this->totalapproveddocument; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Documents:" ?><strong></td>
            <td><?php echo $this->totaldocumentfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Documents:" ?><strong></td>
            <td><?php echo $this->totaldocumentsponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totaldocumentrated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Documents:" ?><strong></td>
            <td><?php echo $this->totaldocumentverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Documents:" ?><strong></td>
            <td><?php echo $this->totaldocumentfavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totaldocumentcomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totaldocumentviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totaldocumentlikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
