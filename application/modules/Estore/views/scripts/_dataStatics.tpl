<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataStatics.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="estore_data_stats sesbasic_text_light">
  <?php if(isset($this->likeActive)):?>
    <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $store->like_count), $this->locale()->toNumber($store->like_count)) ?>"><i class="fa fa-thumbs-up"></i> <?php echo $store->like_count; ?></span>
  <?php endif;?>
  <?php if(isset($this->commentActive)):?>
    <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)) ?>"><i class="fa fa-comment"></i> <?php echo $store->comment_count; ?></span>
  <?php endif;?>
  <?php if(isset($this->viewActive)):?>
    <span title="<?php echo $this->translate(array('%s View', '%s Views', $store->view_count), $this->locale()->toNumber($store->view_count)) ?>"><i class="fa fa-eye"></i> <?php echo $store->view_count; ?></span>
  <?php endif;?>
  <?php if(isset($this->favouriteActive)):?>
    <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)) ?>"><i class="fa fa-heart"></i> <?php echo $store->favourite_count; ?></span>
  <?php endif;?>
    <?php if(isset($this->followActive)):?>
    <span title="<?php echo $this->translate(array('%s Follow', '%s Follows', $store->follow_count), $this->locale()->toNumber($store->follow_count)) ?>"><i class="fa fa-check"></i> <?php echo $store->follow_count; ?></span>
  <?php endif;?>
    <?php  
        $viewer = Engine_Api::_()->user()->getViewer();
        if ($viewer->getIdentity() && ( $store->isOwner($viewer))) {
            $waitingMembers = Zend_Paginator::factory($store->membership()->getMembersSelect(false));
        }
        $select = $store->membership()->getMembersObjectSelect();
        if ($search) {
        $select->where('displayname LIKE ?', '%' . $search . '%');
        }
        if ($limit_data) {
        $select->limit($limit_data);
        }
        $fullMembers = $fullMembers = Zend_Paginator::factory($select);

        // if showing waiting members, or no full members
        if (($viewer->getIdentity() && ( $store->isOwner($viewer))) && ($waiting || ($fullMembers->getTotalItemCount() <= 0 && $search == ''))) {
            $members = $paginator = $waitingMembers;
        } else {
            $members = $paginator = $fullMembers;
        } 
    ?>
	<?php if(isset($this->memberActive)): ?>
			<span title="<?php echo $this->translate(array('%s Member', '%s Member', $members->getTotalItemCount()), $this->locale()->toNumber($members->getTotalItemCount())) ?>"><i class="fa fa-user"></i> <?php echo $members->getTotalItemCount(); ?></span>
	<?php endif;?>
	<?php if(isset($this->totatProductActive)) {  ?>
		<?php $paginator = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getProduct(array('store_id'=>$store->store_id)); ?>
		 <span title=""><i class="fa fa-shopping-bag"></i>&nbsp; <?php echo count($paginator); ?></span>
	<?php } ?>
</div>

