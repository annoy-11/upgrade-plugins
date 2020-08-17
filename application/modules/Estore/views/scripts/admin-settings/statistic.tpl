<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Stores Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Stores created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Stores:" ?></strong></td>
            <td><?php echo $this->totalstore ? $this->totalstore : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Stores:" ?></strong></td>
            <td><?php echo $this->totalapprovedstore ? $this->totalapprovedstore : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Stores:" ?></strong></td>
            <td><?php echo $this->totalstorefeatured ? $this->totalstorefeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Stores:" ?></strong></td>
            <td><?php echo $this->totalstoresponsored ? $this->totalstoresponsored : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Stores:" ?></strong></td>
            <td><?php echo $this->totalstorehot ? $this->totalstorehot : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Stores:" ?></strong></td>
            <td><?php echo $this->totalstoreverified ? $this->totalstoreverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Stores:" ?></strong></td>
            <td><?php echo $this->totalstorefavourite ? $this->totalstorefavourite : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalstorecomments ? $this->totalstorecomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalstoreviews ? $this->totalstoreviews : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalstorelikes ? $this->totalstorelikes : 0; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Followers:" ?></strong></td>
            <td><?php echo $this->totalstorefollowers ? $this->totalstorefollowers : 0; ?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </form>
</div>
