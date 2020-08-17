<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescusdash
 * @package    Sescusdash
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity() ;?>
<div class="sescusdash_links_block sescusdash_bxs">
  <?php foreach( $this->dashboardlinks as $item ): ?>
    <div class="sescusdash_links <?php if(!empty($item->type) && $item->type == 'horizontal') { ?> sescusdash_links_h <?php } else { ?> sescusdash_links_v <?php } ?>">
      <?php $results = Engine_Api::_()->getDbTable('dashboardlinks', 'sescusdash')->getInfo(array('sublink' => $item->dashboardlink_id, 'enabled' => 1)); ?>
      <?php if(count($results) > 0) { ?>
        <p class="links_title"><?php echo $item->name; ?></p>
        <ul>
          <?php foreach($results as $result) { ?>
            <li><a href="<?php echo $result->url; ?>">
            <?php if(empty($result->icon_type) && !empty($result->file_id)): ?>
              <?php $photo = Engine_Api::_()->storage()->get($result->file_id, '');
              if($photo) {
              $photo = $photo->map(); ?>
              <i class="_icon"><img src="<?php echo $photo; ?>" /></i>
              <?php } ?>
            <?php elseif(empty($result->file_id) && !empty($result->icon_type)): ?>
              <i class="_ficon fa <?php echo $result->font_icon; ?>"></i>
            <?php endif;?>
            <span><?php echo $result->name; ?></span></a></li>
          <?php } ?>
        </ul>
      <?php } ?>
    </div>
  <?php endforeach; ?>
</div>
<script>

	function showHideInformation( id) {
    if($(id).style.display == 'block') {
      $(id).style.display = 'none';
    } else {
      $(id).style.display = 'block';
    }
	}
</script>
