<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-page.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sescrowdfunding/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
					<h3><?php echo $this->translate("Links to Widgetized Pages") ?></h3>
					<p>
						<?php echo $this->translate('This page lists all the Widgetized Pages of this extension. From here, you can easily go to particular widgetized page in "Layout Editor" by clicking on "Widgetized Page" link.'); ?>
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
					    $corePages = Engine_Api::_()->sescrowdfundingvideo()->getwidgetizePage(array('name' => $item));
					    $page = explode("_",$corePages->name);
					    $executed = false;
					    ?>
					    <tr>
					      <td><?php echo $corePages->displayname ?></td>
					      <td>
					        <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?page='.$corePages->page_id;?>
					        <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Page";?></a>
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
</div>
