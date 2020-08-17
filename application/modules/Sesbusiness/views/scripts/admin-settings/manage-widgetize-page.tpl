<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetized-business.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
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
      <th><?php echo $this->translate("Demo Links") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->businessesArray as $item):
    $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
    $business = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
        <?php if($corePages->name != 'sesbusiness_album_view' && $corePages->name != 'sesbusiness_photo_view' && $corePages->name != 'sesbusiness_join_view' && $corePages->name != 'sesbusiness_profile_index_1' && $corePages->name != 'sesbusiness_profile_index_2' && $corePages->name != 'sesbusiness_profile_index_3' && $corePages->name != 'sesbusiness_profile_index_4' && $corePages->name != 'sesbusiness_category_index'):?>
        |
        <?php $viewBusinessUrl = $this->url(array('module' => $business[0], 'controller' => $business[1], 'action' => $business[2]), 'default');?>
        <a href="<?php echo $viewBusinessUrl; ?>" target="_blank"><?php echo $this->translate("User Page") ?></a>
        <?php endif;?>
      </td>
      <td>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>

