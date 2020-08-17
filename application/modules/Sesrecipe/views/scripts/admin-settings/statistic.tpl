<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Recipes Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Recipes created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Recipes:" ?><strong></td>
            <td><?php echo $this->totalrecipe; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Recipes:" ?><strong></td>
            <td><?php echo $this->totalapprovedrecipe; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Recipes:" ?><strong></td>
            <td><?php echo $this->totalrecipefeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Recipes:" ?><strong></td>
            <td><?php echo $this->totalrecipesponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Recipe Albums:" ?><strong></td>
            <td><?php echo $this->totalalbums; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Recipe Photos:" ?><strong></td>
            <td><?php echo $this->totalphotos; ?></td>
          </tr>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')):?>
						<tr>
							<td><strong class="bold"><?php echo "Total Recipe Videos:" ?><strong></td>
							<td><?php echo $this->totalvideos; ?></td>
						</tr>
          <?php endif;?>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totalreciperated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Recipes:" ?><strong></td>
            <td><?php echo $this->totalrecipeverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Recipes:" ?><strong></td>
            <td><?php echo $this->totalrecipefavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totalrecipecomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totalrecipeviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totalrecipelikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>