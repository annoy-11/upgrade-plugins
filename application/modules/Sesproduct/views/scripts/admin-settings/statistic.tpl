<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Products Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Products created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Products:" ?><strong></td>
            <td><?php echo $this->totalproduct; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Products:" ?><strong></td>
            <td><?php echo $this->totalapprovedproduct; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Products:" ?><strong></td>
            <td><?php echo $this->totalproductfeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Products:" ?><strong></td>
            <td><?php echo $this->totalproductsponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Product Albums:" ?><strong></td>
            <td><?php echo $this->totalalbums; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Product Photos:" ?><strong></td>
            <td><?php echo $this->totalphotos; ?></td>
          </tr>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')):?>
						<tr>
							<td><strong class="bold"><?php echo "Total Product Videos:" ?><strong></td>
							<td><?php echo $this->totalvideos; ?></td>
						</tr>
          <?php endif;?>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totalproductrated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Products:" ?><strong></td>
            <td><?php echo $this->totalproductverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Products:" ?><strong></td>
            <td><?php echo $this->totalproductfavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totalproductcomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totalproductviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totalproductlikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>
