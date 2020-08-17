<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-widgetize-business.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
        <h3><?php echo $this->translate("Links to Widgetized Businesss") ?></h3>
        <p>
          <?php echo $this->translate('This business lists all the Widgetized Businesss of this plugin. From here, you can easily go to particular widgetized business in "Layout Editor" by clicking on "Widgetized Business" link. The user side link of the business can be viewed by clicking on "User Business" link'); ?>
        </p>
        <br />
        <table class='admin_table'>
          <thead>
            <tr>
              <th><?php echo $this->translate("Business Name") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
              <th><?php //echo $this->translate("Demo Links") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->businessesArray as $item):
            $coreBusinesss = Engine_Api::_()->sesbasic()->getwidgetizePage(array('name' => $item));
            $business = explode("_",$coreBusinesss->name);
            $executed = false;
            ?>
            <tr>
              <td><?php echo $coreBusinesss->displayname ?></td>
              <td>
                <?php $url = $this->url(array('module' => 'core', 'controller' => 'content', 'action' => 'index'), 'admin_default').'?business='.$coreBusinesss->page_id;?>
                <a href="<?php echo $url;?>"  target="_blank"><?php echo "Widgetized Business";?></a>
                <?php if($coreBusinesss->name != 'sesbusinessoffer_index_view' && $coreBusinesss->name != 'sesbusinessoffer_index_edit' && $coreBusinesss->name != 'sesbusinessoffer_index_create'):?>
                |
                <?php $viewBusinessUrl = $this->url(array('module' => $business[0], 'controller' => $business[1], 'action' => $business[2]), 'default');?>
                <a href="<?php echo $viewBusinessUrl; ?>" target="_blank"><?php echo $this->translate("User Business") ?></a>
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
