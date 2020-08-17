<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetized-page.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Eblog/views/scripts/dismiss_message.tpl'; ?>

<?php $widgetPgsArray = array('eblog_index_welcome', 'eblog_index_home', 'eblog_index_browse', 'eblog_category_browse', 'eblog_index_locations', 'eblog_review_browse', 'eblog_index_manage', 'eblog_index_claim', 'eblog_index_create', 'eblog_index_view_1', 'eblog_index_view_2','eblog_index_view_3','eblog_index_view_4', 'eblog_index_tags', 'eblog_review_view', 'eblog_album_view', 'eblog_photo_view', 'eblog_index_claim-requests', 'eblog_index_list', 'eblog_category_index'); ?>

<h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
<p><?php echo $this->translate('This page lists all the Widgetized Pages of this plugin. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link. The user side link of the Page can be viewed by clicking on "User Page" link.'); ?></p>
<br />

<table class='admin_table'>
  <thead>
    <tr>
      <th><?php echo $this->translate("Page Name") ?></th>
      <th><?php echo $this->translate("Option") ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($widgetPgsArray as $item): ?>
      <?php $widgetPge = Engine_Api::_()->eblog()->getwidgetizePage(array('name' => $item)); ?>
      <tr>
        <td><?php echo $widgetPge->displayname; ?></td>
        <td>
          <a href="<?php echo $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$widgetPge->page_id; ?>"  target="_blank"><?php echo "Widgetized Page";?></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
