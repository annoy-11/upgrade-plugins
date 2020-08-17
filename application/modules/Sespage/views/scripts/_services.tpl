<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _services.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->paginator as $item): ?>
  <div class="_services sesbasic_bg sesbasic_clearfix" id="sespageservice_service_<?php echo $item->service_id; ?>">
    <div class="_thumb">
      <?php echo $this->itemPhoto($item, 'thumb.normal', $item->getTitle()); ?>
    </div>
    <div class="_cont">
      <div class="sesbasic_pulldown_wrapper _option">
        <a href="javascript:void(0);" class="sesbasic_button sesbasic_pulldown_toggle"><i class="fa fa-ellipsis-h"></i></a>
        <div class="sesbasic_pulldown_options">
          <ul class="_isicon">
            <li><a href="<?php echo $this->url(array('page_id' => $item->page_id,'service_id' => $item->service_id, 'action'=>'editservice'),'sespage_dashboard',true);?>" class="sessmoothbox sesbasic_icon_edit"><?php echo $this->translate("Edit");?></a></li>
            <li><a href="<?php echo $this->url(array('page_id' => $item->page_id,'service_id' => $item->service_id,'action'=>'deleteservice'),'sespage_dashboard',true);?>" class="sessmoothbox sesbasic_icon_delete"><?php echo $this->translate("Delete");?></a></li>
          </ul>
        </div>
      </div>
      <div class="_title sesbasic_clearfix">
        <?php echo $item->title;?>
      </div>
			<div class="_pd sesbasic_text_light">
        <?php if($item->duration && $item->duration_type) { ?>
          <span><?php echo $item->duration . ' ' . lcfirst($item->duration_type);?></span>
        <?php } ?>
        <?php if($item->duration && $item->duration_type && $item->price) { ?><span>&middot;</span><?php } ?>
				<?php if($item->price) { ?>
          <span><?php echo $item->price;?></span>
        <?php } ?>
      </div>
      <?php if($item->description) { ?>
        <div class="_des">
					<?php echo $item->description;?>
        </div>
      <?php } ?>

    </div>
  </div>
<?php endforeach;?>