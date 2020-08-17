<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbasic_view_stats_popup">
  <h3><?php echo $this->item->title.' '.ucfirst($this->type)."'s";  ?> statistics</h3>
  <table>
  	<tr>
    
    <td colspan="2"><img src="<?php echo $this->item->getPhotoUrl(); ?>" style="height:75px; width:75px;"/></td>
   
    </tr>
  	<tr>
      <td><?php echo $this->translate('Title') ?>:</td>
      <td><?php if(!is_null($this->item->title) && $this->item->title != '') {
              echo  $this->item->title ;
            }else{ 
                echo "-";
            } ?>
     </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Owner') ?>:</td>
      <td><?php echo  $this->item->getOwner(); ?></td>
    </tr>
    
    <!--<tr>
      <td><?php echo $this->translate('Approved') ?>:</td>
      <td><?php  if($this->item->approved == 1){ ?>
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
     </td>
    </tr>-->
    
     <tr>
      <td><?php echo $this->translate('Featured') ?>:</td>
      <td><?php  if($this->item->featured == 1){ ?>
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
     </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Sponsored') ?>:</td>
      <td><?php  if($this->item->sponsored == 1){ ?>
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
     </td>
    </tr>
    
    <tr>
      <td><?php echo $this->translate('Hot') ?>:</td>
      <td><?php  if($this->item->hot == 1){ ?>
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
     </td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Verified') ?>:</td>
      <td><?php  if($this->item->verified == 1){ ?>
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png'; ?>"/> <?php }else{ ?> 
      <img src="<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png'; ?>" /> <?php } ?>
     </td>
    </tr>
    
    <tr>
      <td><?php echo $this->translate('Comments Count') ?>:</td>
      <td><?php echo $this->item->comment_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Likes Count') ?>:</td>
      <td><?php echo $this->item->like_count ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Views Count') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->view_count) ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Favourites Count') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->favourite_count) ?></td>
    </tr>
    
    <tr>
      <td><?php echo $this->translate('Answer Count') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->answer_count) ?></td>
    </tr>
    <tr>
      <td><?php echo $this->translate('Follow Count') ?>:</td>
      <td><?php echo $this->locale()->toNumber($this->item->follow_count) ?></td>
    </tr>
    
    
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1)){ ?>
    <tr>
      <td><?php echo $this->translate('Location') ?>:</td>
      <td><?php if(!is_null($this->item->location)) echo $this->item->location; else echo '-' ;?></td>
    </tr>
   <?php } ?>
     <tr>
      <td><?php echo $this->translate('Date') ?>:</td>
      <td><?php echo $this->item->creation_date; ;?></td>
    </tr>
  </table>
  <br />
  <button onclick='javascript:parent.Smoothbox.close()'>
    <?php echo $this->translate("Close") ?>
  </button>
</div>
<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
