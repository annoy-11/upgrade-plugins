<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $products = $this->wishlist->getProducts(); ?>
<div>
  <?php if (!empty($products)): ?>
    <ul id="sesproduct_playlist">
      <?php foreach ($products as $product): 
      	$productMain = Engine_Api::_()->getItem('sesproduct', $product->file_id);
      ?>
      <li id="song_item_<?php echo $product->playlistproduct_id ?>" class="file file-success">
        <a href="javascript:void(0)" class="product_action_remove file-remove"><?php echo $this->translate('Remove') ?></a>
        <span class="file-name">
          <?php echo $productMain->getTitle() ?>
        </span>
      </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function(){
    $('demo-status').style.display = 'none';
    if ($$('#sesproduct_playlist li.file').length) {
      $$('#sesproduct_playlist li.file').inject($('demo-list'));
      $('demo-list').show()
    }
    
});
//REMOVE/DELETE SONG FROM PLAYLIST
    sesJqueryObject('.product_action_remove').click(function(){
      var product_id  = sesJqueryObject(this).parent().attr('id').split(/_/);
          product_id  = product_id[ product_id.length-1 ];
      
      sesJqueryObject(this).parent().remove();
      new Request.JSON({
        url: '<?php echo $this->url(array('module'=> 'sesproduct' ,'controller'=>'wishlist','action'=>'delete-playlistproduct'), 'default') ?>',
        data: {
          'format': 'json',
          'playlistproduct_id': product_id,
          'wishlist_id': <?php echo $this->wishlist->wishlist_id ?>
        }
      }).send();
      return false;
    });
</script>
