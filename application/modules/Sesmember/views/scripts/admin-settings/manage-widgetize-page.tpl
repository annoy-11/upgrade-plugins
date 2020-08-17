<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl 2015-06-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>
<h3><?php echo $this->translate("Manage Widgetize Pages") ?></h3>
<p>
	<?php echo $this->translate('This page lists all of the Widgetize Page in this plugin. From here you can easily go to particular page in "Layout Editor" by clicking on "Get Widgetize Page" and also you can view directly user side page by click on "View Page" link.'); ?>
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
    $corePages = Engine_Api::_()->sesmember()->getwidgetizePage(array('name' => $item));
    $page = explode("_",$corePages->name);
    $executed = false;
    ?>
    <tr>
      <td><?php echo $corePages->displayname ?></td>
      <td>
        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Get Widgetize Page";?></a>
        |
        <?php if($results): ?>
        <a href="<?php echo $results->getHref(); ?>" target="_blank"><?php echo $this->translate("View Page") ?></a>
        <?php elseif($executed):?>
        	<?php echo $this->translate("---") ?>
        <?php else: ?>
        <?php $viewPageUrl = $this->url(array('module' => $page[0], 'controller' => $page[1], 'action' => $page[2]), 'default');?>
        <a href="<?php echo $viewPageUrl; ?>" target="_blank"><?php echo $this->translate("View Page") ?></a>
        <?php endif; ?>
      </td>
      <td>
	      <?php if($corePages->name == 'sesmember_index_browse'): ?>
		      <a target="_blank" href="http://demo.socialenginesolutions.com/members"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_index_nearest-member'): ?>
			    
		    <?php elseif($corePages->name == 'sesmember_index_member-compliments'): ?>
		    <a target="_blank" href="http://demo.socialenginesolutions.com/member/member-compliments"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_index_top-members'): ?>
		    <a target="_blank" href="http://demo.socialenginesolutions.com/member/top-members"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_review_browse'): ?>
		    <a target="_blank" href="http://demo.socialenginesolutions.com/browse-review"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_index_locations'): ?>
		    <a target="_blank" href="http://demo.socialenginesolutions.com/member/locations"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_index_pinborad-view-members'): ?>
		    <a target="_blank" href="http://demo.socialenginesolutions.com/member/pinborad-view-members"><?php echo $this->translate("View"); ?></a>
		    <?php elseif($corePages->name == 'sesmember_review_view'): ?>
		    
		    <?php endif; ?>
      </td>
    </tr>
    <?php $results = ''; ?>
    <?php endforeach; ?>
  </tbody>
</table>
