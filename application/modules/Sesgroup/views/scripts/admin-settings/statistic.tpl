<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Groups Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Groups created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Groups:" ?></strong></td>
            <td><?php echo $this->totalgroup ? $this->totalgroup : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Groups:" ?></strong></td>
            <td><?php echo $this->totalapprovedgroup ? $this->totalapprovedgroup : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Groups:" ?></strong></td>
            <td><?php echo $this->totalgroupfeatured ? $this->totalgroupfeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Groups:" ?></strong></td>
            <td><?php echo $this->totalgroupsponsored ? $this->totalgroupsponsored : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Groups:" ?></strong></td>
            <td><?php echo $this->totalgrouphot ? $this->totalgrouphot : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Groups:" ?></strong></td>
            <td><?php echo $this->totalgroupverified ? $this->totalgroupverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Groups:" ?></strong></td>
            <td><?php echo $this->totalgroupfavourite ? $this->totalgroupfavourite : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalgroupcomments ? $this->totalgroupcomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalgroupviews ? $this->totalgroupviews : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalgrouplikes ? $this->totalgrouplikes : 0; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Followers:" ?></strong></td>
            <td><?php echo $this->totalgroupfollowers ? $this->totalgroupfollowers : 0; ?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </form>
</div>