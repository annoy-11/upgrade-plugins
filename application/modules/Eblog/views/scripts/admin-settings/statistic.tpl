<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: statistic.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/dismiss_message.tpl';?>
<?php 
  $table = Engine_Api::_()->getDbTable('blogs', 'eblog');
  $albumTable = Engine_Api::_()->getDbTable('albums', 'eblog');
  $photoTable = Engine_Api::_()->getDbTable('photos', 'eblog'); 
?>
<div class='settings'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Blogs Statistics") ?> </h3>
      <p class="description">
        <?php echo $this->translate("Below are some valuable statistics for the Blogs created on this site:"); ?>
      </p>
      <table class='admin_table' style="width: 50%;">
        <tbody>
          <tr>
            <td><strong class="bold"><?php echo "Total Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Approved Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'is_approved')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Featured Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'featured')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Sponsored Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'sponsored')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Reviews:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'rating'));; ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Verified Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'verified')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Favourite Blogs:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'favourite_count')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Comments:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'comment_count')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Views:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'view_count')); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Likes:" ?><strong></td>
            <td><?php echo $table->getItemCount(array('columnName' => 'like_count')); ?></td>
          </tr>  
          <tr>
            <td><strong class="bold"><?php echo "Total Blog Albums:" ?><strong></td>
            <td><?php echo $albumTable->getItemCount(); ?></td>
          </tr>
          <tr>
            <td><strong class="bold"><?php echo "Total Blog Photos:" ?><strong></td>
            <td><?php echo $photoTable->countPhotos(); ?></td>
          </tr>
          <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')):?>
						<tr>
							<td><strong class="bold"><?php echo "Total Blog Videos:" ?><strong></td>
							<td><?php echo Engine_Api::_()->eblog()->getVideoTotalCount(); ?></td>
						</tr>
          <?php endif;?>      
        </tbody>
      </table>
    </div>
  </form>
</div>
