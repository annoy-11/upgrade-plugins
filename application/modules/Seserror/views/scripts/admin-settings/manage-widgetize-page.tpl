<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Seserror/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link.'); ?>
</p>
<br />
<table class='admin_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Page Name") ?></th>
      <th><?php echo $this->translate("Options") ?></th>
      <th><?php echo $this->translate("Demo Links") ?></th>
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
      </td>
      <td>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>

