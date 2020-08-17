<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesforum/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
      <p>
        <?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link. The user side link of the Page can be viewed by clicking on "User Page" link.'); ?>
      </p>
      <br />
      <table class='admin_table' width="100%">
        <thead>
          <tr>
            <th><?php echo $this->translate("Page Name") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->pagesArray as $item):
          $corePages = Engine_Api::_()->sesforum()->getwidgetizePage(array('name' => $item));
          if(!$corePages) continue;
          $page = explode("_",$corePages->name);
          ?>
          <tr>
            <td><?php echo $corePages->displayname; ?></td>
            <td>
              <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
              <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
              
              <?php if($item == 'sesforum_forum_view' || $item == 'sesforum_category_view' || $item == 'sesforum_topic_view' || $item == 'sesforum_index_dashboard'): ?>
              <?php else: ?>
              |
              <?php $viewPageUrl = $this->url(array('module' => $page[0], 'controller' => $page[1], 'action' => $page[2]), 'default');?>
              <a href="<?php echo $viewPageUrl; ?>" target="_blank"><?php echo $this->translate("User Page") ?></a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>      
