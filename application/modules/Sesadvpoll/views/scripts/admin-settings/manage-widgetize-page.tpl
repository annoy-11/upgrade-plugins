<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesadvpoll/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link. The user side link of the Page can be viewed by clicking on "User Page" link.'); ?>
</p>
<br />
<table class='admin_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Page Name") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->pagesArray as $item):
    $corePages = Engine_Api::_()->sesadvpoll()->getwidgetizePage(array('name' => $item));
    if(!$corePages) continue;
    $page = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname; ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
        <?php $viewPageUrl = $this->url(array('module' => $page[0], 'controller' => $page[1], 'action' => $page[2]), 'default');?>
        <?php if($item != 'sesadvpoll_poll_edit' && $item != 'sesadvpoll_poll_view') { ?>
        |
        <a href="<?php echo $viewPageUrl; ?>" target="_blank"><?php echo $this->translate("User Page") ?></a>
        <?php } ?>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>
