<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: skills.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesprofilefield/views/scripts/dismiss_message.tpl';?>
<div class='settings sesbasic_admin_form'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Manage Skills") ?> </h3>
      <p class="description">
        <?php echo $this->translate('') ?>
      </p>        
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'add-skill'), $this->translate('Add New Skill'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />        
      <?php if(count($this->skills)>0):?>
      <table class='admin_table' style="width: 100%;">
        <thead>
          <tr>
            <th><?php echo $this->translate("Name") ?></th>
            <th><?php echo $this->translate("Status") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->skills as $result): ?>
          <tr>
            <td><b class="bold"><?php echo $result->skillname ?></b></td>
            <td>
							<?php if(empty($result->created_by)) { ?>
								<?php if($result->enabled == 1):?>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled-skill', 'id' => $result->manageskill_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Disable')))) ?>
								<?php else: ?>
									<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'enabled-skill', 'id' => $result->manageskill_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Enable')))) ?>
								<?php endif; ?>
							<?php } else { ?>
							-
							<?php } ?>
						</td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'edit-skill', 'id' => $result->manageskill_id), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'manage', 'action' => 'delete-skill', 'id' => $result->manageskill_id, 'value' => $result->skillname), $this->translate('Delete'), array('class' => 'smoothbox')); ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else:?>
      <br/>
      <div class="tip">
        <span><?php echo $this->translate("There are currently no skills.") ?></span>
      </div>
      <?php endif;?>
    </div>
  </form>
</div>