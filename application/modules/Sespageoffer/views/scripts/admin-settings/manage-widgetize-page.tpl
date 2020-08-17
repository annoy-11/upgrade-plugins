<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php $sespageoffer_widget = Zend_Registry::isRegistered('sespageoffer_widget') ? Zend_Registry::get('sespageoffer_widget') : null; ; ?>
    <?php if($sespageoffer_widget) { ?>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <?php } ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
        <h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
        <p>
          <?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link. The user side link of the page can be viewed by clicking on "User Page" link'); ?>
        </p>
        <br />
        <table class='admin_table'>
          <thead>
            <tr>
              <th><?php echo $this->translate("Page Name") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
              <th><?php //echo $this->translate("Demo Links") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->pagesArray as $item):
            $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
            $page = explode("_",$corePages->name);
            $executed = false;
            ?>
            <tr>
              <td><?php echo $corePages->displayname ?></td>
              <td>
                <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
                <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
                <?php if($corePages->name != 'sespageoffer_index_view' && $corePages->name != 'sespageoffer_index_edit' && $corePages->name != 'sespageoffer_index_create'):?>
                |
                <?php $viewPageUrl = $this->url(array('module' => $page[0], 'controller' => $page[1], 'action' => $page[2]), 'default');?>
                <a href="<?php echo $viewPageUrl; ?>" target="_blank"><?php echo $this->translate("User Page") ?></a>
                <?php endif;?>
              </td>
            </tr>
            <?php $results = ''; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
			</div>
		</div>
  </div>
</div>
