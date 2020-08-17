<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/dismiss_message.tpl';?>

<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Articles Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Articles created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Articles:" ?><strong></td>
            <td><?php echo $this->totalarticle; ?></td>
          </tr>
           <tr>
            <td><strong class="bold"><?php echo "Total Approved Articles:" ?><strong></td>
            <td><?php echo $this->totalapprovedarticle; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Articles:" ?><strong></td>
            <td><?php echo $this->totalarticlefeatured; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Articles:" ?><strong></td>
            <td><?php echo $this->totalarticlesponsored; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Article Albums:" ?><strong></td>
            <td><?php echo $this->totalalbums; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Article Photos:" ?><strong></td>
            <td><?php echo $this->totalphotos; ?></td>
          </tr>
          <?php if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')):?>
						<tr>
							<td><strong class="bold"><?php echo "Total Article Videos:" ?><strong></td>
							<td><?php echo $this->totalvideos; ?></td>
						</tr>
          <?php endif;?>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $this->totalarticlerated; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Articles:" ?><strong></td>
            <td><?php echo $this->totalarticleverified; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Articles:" ?><strong></td>
            <td><?php echo $this->totalarticlefavourite; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $this->totalarticlecomments; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $this->totalarticleviews; ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $this->totalarticlelikes; ?></td>
          </tr>        
        </tbody>
      </table>
    </div>
  </form>
</div>