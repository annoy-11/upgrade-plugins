<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesshortcut/externals/scripts/core.js'); ?>
<h3 class="sesshortcut_menu_edit">
	<?php echo $this->translate($this->title); ?>
  <?php if($this->viewer_id) { ?>
    <span><a href="sesshortcut/index/get-all-shortcuts/user_id/<?php echo $this->viewer_id ?>" class="sessmoothbox"><?php echo $this->translate("Edit"); ?></a></span>
  <?php } ?>
</h3>
<div class="sesshortcut_menu sesbasic_bxs">
  <?php $countMenu = 0; ?>
  <ul class="sesasic_clearfix" id="sesshortcut_allmenus">
    <?php foreach($this->results as $result) { ?>
      <?php if( $countMenu < $this->shortCount ): ?>
        <?php $resource = Engine_Api::_()->getItem($result['resource_type'], $result['resource_id']); ?>
        <?php if($resource) { ?>
					<li class="_menu_item" id="shortcutsmenu_<?php echo $result['shortcut_id']; ?>">
						<a href="<?php echo $resource->getHref(); ?>"><?php echo $this->itemPhoto($resource, 'thumb.icon'); ?><span><?php echo $resource->getTitle(); ?></span></a>
						<a href="javascript:void(0);" class="sesshortcut_menu_toggle _menu fa fa-ellipsis-h"></a>
						<div class="sesshortcut_menu_options">
							<ul>
								<?php if($this->enablepintotop) { ?>
									<li>
										<a id="unpintotop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> href="javascript:void(0);" onclick="unpinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Unpin from Top"); ?></a>
										<a id="pinToTop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> href="javascript:void(0);" onclick="pinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Pin to Top"); ?></a>
									</li>
								<?php } ?>
								<li>
									<?php if (!empty($this->viewer_id)) { ?>
										<?php $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $result['resource_type'], 'resource_id' => $result['resource_id'])); ?>
										<a href="javascript:void(0);" onclick="shortcutButton('<?php echo $result['resource_id']; ?>', '<?php echo $result['resource_type'] ?>');" id="<?php echo $result['resource_type'] ?>_unshortcut_<?php echo $result['resource_id']; ?>" style='display:<?php echo $isShortcut ? "block" : "none" ?>' href=""><?php echo $this->translate("Hide from Shortcuts"); ?></a>
										<input type ="hidden" id = "<?php echo $result['resource_type'] ?>_shortcutunshortcuthidden_<?php echo $result['resource_id']; ?>" value = '<?php echo $isShortcut ? $isShortcut : 0; ?>' />
									<?php } ?>
								</li>
							</ul>
						</div>
					</li>
				<?php } ?>
	    <?php else:?>
	      <?php break;?>
	    <?php endif;?>
	    <?php $countMenu++;?>
    <?php } ?>
    <?php if (count($this->results) > $this->shortCount):?>
      <?php $countMenu = 0; ?>
      <div class="sesshortcut_menu_more" id="sesshortcut_menu_more">
        <a onclick="showExtraMenu();" href="javascript:void(0);" class="sesasic_clearfix"><i class="fa fa-caret-down sesbasic_text_light"></i><span><?php echo $this->translate("See More");?></span></a>
      </div>
      <?php foreach($this->results as $result) { ?>
        <?php if ($countMenu >= $this->shortCount): ?>
          <?php $resource = Engine_Api::_()->getItem($result['resource_type'], $result['resource_id']); ?>
            <li style="display:none;" class="_menu_item sesshortcut_exta_menus" id="shortcutsmenu_<?php echo $result['shortcut_id']; ?>">
              <a href="<?php echo $resource->getHref(); ?>"><?php echo $this->itemPhoto($resource, 'thumb.icon'); ?><span><?php echo $resource->getTitle(); ?></span></a>
              <a href="javascript:void(0);" class="sesshortcut_menu_toggle _menu fa fa-ellipsis-h"></a>
              <div class="sesshortcut_menu_options">
                <ul>
                  <?php if($this->enablepintotop) { ?>
                    <li>
                      <a id="unpintotop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> href="javascript:void(0);" onclick="unpinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Unpin from Top"); ?></a>
                      <a id="pinToTop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> href="javascript:void(0);" onclick="pinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Pin to Top"); ?></a>
                    </li>
                  <?php } ?>
                  <li>
                    <?php if (!empty($this->viewer_id)) { ?>
                      <?php $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $result['resource_type'], 'resource_id' => $result['resource_id'])); ?>
                      <a href="javascript:void(0);" onclick="shortcutButton('<?php echo $result['resource_id']; ?>', '<?php echo $result['resource_type'] ?>');" id="<?php echo $result['resource_type'] ?>_unshortcut_<?php echo $result['resource_id']; ?>" style='display:<?php echo $isShortcut ? "block" : "none" ?>' href=""><?php echo $this->translate("Hide from Shortcuts"); ?></a>
                      <input type ="hidden" id = "<?php echo $result['resource_type'] ?>_shortcutunshortcuthidden_<?php echo $result['resource_id']; ?>" value = '<?php echo $isShortcut ? $isShortcut : 0; ?>' />
                    <?php } ?>
                  </li>
                </ul>
              </div>
            </li>
        <?php endif;?>
        <?php $countMenu++;?>
      <?php } ?>
    <?php endif;?>
  </ul>

</div>
