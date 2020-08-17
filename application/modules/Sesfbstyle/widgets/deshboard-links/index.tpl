<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfbstyle
 * @package    Sesfbstyle
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-09-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity() ;?>
<?php if($viewer_id && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1)) { ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesshortcut/externals/scripts/core.js'); ?>
<?php } ?>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php $moduleName = $request->getModuleName(); ?>
<div class="user_dashboard_links sesbasic_bxs sesbasic_clearfix">
	<div class="dashboard_explore_links_v sesbasic_clearfix">
  	<ul>
    	<li class="_profile">
        <a class="profile_link" href="<?php echo $this->viewer->getHref(); ?>">
          <?php if($this->viewer->photo_id) { ?>
            <img src="<?php echo $this->viewer->getPhotoUrl('thumb.icon'); ?>" />
          <?php } else { ?>
            <img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" />
          <?php } ?>
          <span><?php echo $this->viewer->getTitle(); ?></span>
        </a>
        <span><a onclick="showHideInformation('sesfbstyle_information');" href="javascript:void(0);" class="fa fa-ellipsis-h sesbasic_text_light" title='<?php echo $this->translate("Edit Profile")?>'></a></span>
        <ul class="edit_profile_dropdown" style="display:none;" id="sesfbstyle_information">
          <?php foreach( $this->homelinksnavigation as $link ): ?>
            <li>
              <a href="<?php echo $link->getHref(); ?>"><?php echo $this->translate($link->getLabel()); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
    	</li>
      <li class="_newsfeed<?php if($moduleName = 'user' && $controllerName == 'index' && $actionName == 'home') { ?> active<?php } ?>">
        <a href="">
          <img src="application/modules/Sesfbstyle/externals/images/newsfeeed.png" />
          <span><?php echo $this->translate("News Feed");?></span>
        </a>
      </li>
      <li class="_message">
        <a class="profile_link" href="/messages/inbox">
          <img src="application/modules/Sesfbstyle/externals/images/message.png" />
          <span><?php echo $this->translate("Messages");?></span>
        </a>
    	</li>
    </ul>
  </div>
  <?php if($viewer_id && Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesshortcut') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1)) { ?>
    <?php $results = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->getShortcuts($viewer_id); ?>
    <?php if(count($results) > 0) { ?>
      <div class="dashboard_explore_links_v sesbasic_clearfix">
        <p class="links_tittle"> <?php echo $this->translate("Shortcuts"); ?><span><a href="sesshortcut/index/get-all-shortcuts/user_id/<?php echo $viewer_id ?>" class="sessmoothbox"><?php echo $this->translate("Edit"); ?></a></span></p>
        <?php $countMenu = 0; ?>
        <ul class="sesasic_clearfix" id="sesshortcut_allmenus">
          <?php foreach($results as $result) { ?>
            <?php if( $countMenu < $this->shortCount ): ?>
              <?php $resource = Engine_Api::_()->getItem($result['resource_type'], $result['resource_id']); ?>
              <li class="_menu_item _op" id="shortcutsmenu_<?php echo $result['shortcut_id']; ?>">
                <a href="<?php echo $resource->getHref(); ?>"><?php echo $this->itemPhoto($resource, 'thumb.icon'); ?><span><?php echo $this->translate($resource->getTitle()); ?></span></a>
                <span>
                  <a href="javascript:void(0);" class="sesshortcut_menu_toggle _menu fa fa-ellipsis-h sesbasic_text_light"></a>
                  <div class="sesshortcut_menu_options">
                  <ul>
                    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enablepintotop', 1)) { ?>
                      <li>
                        <a id="unpintotop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> href="javascript:void(0);" onclick="unpinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Unpin from Top"); ?></a>
                        <a id="pinToTop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> href="javascript:void(0);" onclick="pinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Pin to Top"); ?></a>
                      </li>
                    <?php } ?>
                    <li>
                      <?php if (!empty($viewer_id)) { ?>
                        <?php $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $result['resource_type'], 'resource_id' => $result['resource_id'])); ?>
                        <a href="javascript:void(0);" onclick="shortcutButton('<?php echo $result['resource_id']; ?>', '<?php echo $result['resource_type'] ?>');" id="<?php echo $result['resource_type'] ?>_unshortcut_<?php echo $result['resource_id']; ?>" style='display:<?php echo $isShortcut ? "block" : "none" ?>' href=""><?php echo $this->translate("Hide from Shortcuts"); ?></a>
                        <input type ="hidden" id = "<?php echo $result['resource_type'] ?>_shortcutunshortcuthidden_<?php echo $result['resource_id']; ?>" value = '<?php echo $isShortcut ? $isShortcut : 0; ?>' />
                      <?php } ?>
                    </li>
                  </ul>
                </div>	
                </span>
              </li>
            <?php else:?>
              <?php break;?>
            <?php endif;?>
            <?php $countMenu++;?>
          <?php } ?>
          <?php if (count($results) > $this->shortCount):?>
            <?php $countMenu = 0; ?>
            <?php foreach($results as $result) { ?>
              <?php if ($countMenu >= $this->shortCount): ?>
                <?php $resource = Engine_Api::_()->getItem($result['resource_type'], $result['resource_id']); ?>
                <li style="display:none;" class="_menu_item sesshortcut_exta_menus _op" id="shortcutsmenu_<?php echo $result['shortcut_id']; ?>">
                  <a href="<?php echo $resource->getHref(); ?>"><?php echo $this->itemPhoto($resource, 'thumb.icon'); ?><span><?php echo $this->translate($resource->getTitle()); ?></span></a>
                  <span>
                    <a href="javascript:void(0);" class="sesshortcut_menu_toggle _menu fa fa-ellipsis-h sesbasic_text_light"></a>
                    <div class="sesshortcut_menu_options">
                      <ul>
                        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enablepintotop', 1)) { ?>
                          <li>
                            <a id="unpintotop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?> href="javascript:void(0);" onclick="unpinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Unpin from Top"); ?></a>
                            <a id="pinToTop_<?php echo $result['shortcut_id']; ?>" <?php if($result['pintotop']) { ?> style="display:none;" <?php } else { ?> style="display:block;" <?php } ?> href="javascript:void(0);" onclick="pinToTop('<?php echo $result['shortcut_id']  ?>');"><?php echo $this->translate("Pin to Top"); ?></a>
                          </li>
                        <?php } ?>
                        <li>
                          <?php if (!empty($viewer_id)) { ?>
                            <?php $isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $result['resource_type'], 'resource_id' => $result['resource_id'])); ?>
                            <a href="javascript:void(0);" onclick="shortcutButton('<?php echo $result['resource_id']; ?>', '<?php echo $result['resource_type'] ?>');" id="<?php echo $result['resource_type'] ?>_unshortcut_<?php echo $result['resource_id']; ?>" style='display:<?php echo $isShortcut ? "block" : "none" ?>' href=""><?php echo $this->translate("Hide from Shortcuts"); ?></a>
                            <input type ="hidden" id = "<?php echo $result['resource_type'] ?>_shortcutunshortcuthidden_<?php echo $result['resource_id']; ?>" value = '<?php echo $isShortcut ? $isShortcut : 0; ?>' />
                          <?php } ?>
                        </li>
                      </ul>
                    </div>
                  </span>
                </li>
              <?php endif;?>
              <?php $countMenu++;?>
            <?php } ?>
          <?php endif;?>
        </ul>
        <?php if (count($results) > $this->shortCount):?>
          <?php $countMenu = 0; ?>
          <div class="sesshortcut_menu_more" id="sesshortcut_menu_more">
            <a onclick="showExtraMenu();" href="javascript:void(0);" class="sesasic_clearfix"><i class="fa fa-caret-down sesbasic_text_light"></i><span><?php echo $this->translate("See More");?></span></a>
          </div>
        <?php endif;?>
      </div>
  	<?php } ?>
  <?php } ?>

  <?php foreach( $this->dashboardlinks as $item ): ?>
    <div class="<?php if(!empty($item->type) && $item->type == 'horizontal') { ?> dashboard_explore_links_h <?php } else { ?> dashboard_explore_links_v <?php } ?>sesbasic_clearfix">
      <?php $footersubresults = Engine_Api::_()->getDbTable('dashboardlinks', 'sesfbstyle')->getInfo(array('sublink' => $item->dashboardlink_id, 'enabled' => 1)); ?>
      <?php if(count($footersubresults) > 0) { ?>
        <p class="links_tittle"><?php echo $this->translate($item->name); ?></p>
        <ul>
          <?php foreach($footersubresults as $footersubresult) { ?>
            <li><a href="<?php echo $footersubresult->url; ?>">
            <?php if(empty($footersubresult->icon_type) && !empty($footersubresult->file_id)): ?>
              <?php $photo = Engine_Api::_()->storage()->get($footersubresult->file_id, '');
              if($photo) {
              $photo = $photo->map(); ?>
              <img src="<?php echo $photo; ?>" />
              <?php } ?>
            <?php elseif(empty($footersubresult->file_id) && !empty($footersubresult->icon_type)): ?>
              <i class="fa <?php echo $footersubresult->font_icon; ?>"></i>
            <?php endif;?>
            <span><?php echo $this->translate($footersubresult->name); ?></span></a></li>
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
