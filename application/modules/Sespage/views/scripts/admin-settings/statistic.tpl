<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistics.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Pages Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Pages created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Pages:" ?></strong></td>
            <td><?php echo $this->totalpage ? $this->totalpage : 0; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Pages:" ?></strong></td>
            <td><?php echo $this->totalapprovedpage ? $this->totalapprovedpage : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Pages:" ?></strong></td>
            <td><?php echo $this->totalpagefeatured ? $this->totalpagefeatured : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Pages:" ?></strong></td>
            <td><?php echo $this->totalPagesponsored ? $this->totalPagesponsored : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Hot Pages:" ?></strong></td>
            <td><?php echo $this->totalPagehot ? $this->totalPagehot : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Pages:" ?></strong></td>
            <td><?php echo $this->totalpageverified ? $this->totalpageverified : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Pages:" ?></strong></td>
            <td><?php echo $this->totalpagefavourite ? $this->totalpagefavourite : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?></strong></td>
            <td><?php echo $this->totalpagecomments ? $this->totalpagecomments : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?></strong></td>
            <td><?php echo $this->totalpageviews ? $this->totalpageviews : 0; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?></strong></td>
            <td><?php echo $this->totalpagelikes ? $this->totalpagelikes : 0; ?></td>
          </tr> 
          <tr>
            <td><strong class="bold"><?php echo "Total Followers:" ?></strong></td>
            <td><?php echo $this->totalpagefollowers ? $this->totalpagefollowers : 0; ?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </form>
</div>