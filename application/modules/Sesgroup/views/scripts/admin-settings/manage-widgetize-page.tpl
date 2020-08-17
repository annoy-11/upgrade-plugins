<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetized-group.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/dismiss_message.tpl';?>
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
    <?php foreach ($this->groupsArray as $item):
    $corePages = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
    $group = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
        <?php if($corePages->name != 'sesgroup_join_view' && $corePages->name != 'sesgroup_profile_index_1' && $corePages->name != 'sesgroup_profile_index_2' && $corePages->name != 'sesgroup_profile_index_3' && $corePages->name != 'sesgroup_profile_index_4' && $corePages->name != 'sesgroup_category_index' &&  $corePages->name != 'sesgroup_album_view' && $corePages->name != 'sesgroup_photo_view' && $corePages->name != 'sesgroup_index_claim-requests' && $corePages->name != 'sesgroup_index_claim'):?>
        |
        <?php $viewGroupUrl = $this->url(array('module' => $group[0], 'controller' => $group[1], 'action' => $group[2]), 'default');?>
        <a href="<?php echo $viewGroupUrl; ?>" target="_blank"><?php echo $this->translate("User Page") ?></a>
        <?php endif;?>
      </td>
      <td>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>

