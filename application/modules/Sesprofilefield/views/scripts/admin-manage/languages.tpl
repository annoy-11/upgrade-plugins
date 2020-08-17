<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: languages.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesprofilefield/views/scripts/dismiss_message.tpl';?>
<div class='settings sesbasic_admin_form'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Manage Languages") ?> </h3>
      <p class="description">
        <?php echo $this->translate('') ?>
      </p>        
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'add-language'), $this->translate('Add New Language'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />        
      <?php if(count($this->languages)>0):?>
      <table class='admin_table' style="width: 100%;">
        <thead>
          <tr>
            <th><?php echo $this->translate("Name") ?></th>
            <th><?php echo $this->translate("Status") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->languages as $result): ?>
          <tr>
            <td><b class="bold"><?php echo $result->languagename ?></b></td>
            <td>
							<?php if(empty($result->created_by)) { ?>
								<?php if($result->enabled == 1):?>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled-language', 'id' => $result->managelanguage_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Disable')))) ?>
								<?php else: ?>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled-language', 'id' => $result->managelanguage_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Enable')))) ?>
								<?php endif; ?>
							<?php } else { ?>
							-
							<?php } ?>
						</td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'edit-language', 'id' => $result->managelanguage_id), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'delete-language', 'id' => $result->managelanguage_id, 'value' => $result->languagename), $this->translate('Delete'), array('class' => 'smoothbox')); ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else:?>
      <br/>
      <div class="tip">
        <span><?php echo $this->translate("There are currently no languages.") ?></span>
      </div>
      <?php endif;?>
    </div>
  </form>
</div>
