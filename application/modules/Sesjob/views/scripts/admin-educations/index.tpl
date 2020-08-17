<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
      <h3><?php echo $this->translate("Manage Educations") ?></h3>
      <p class="description">
        <?php echo $this->translate("Here, you can create education.") ?>
      </p>
      <div class="sesbasic_search_reasult">
       <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesjob', 'controller' => 'educations', 'action' => 'add-education'), $this->translate('Add New Education'), array(
      'class' => 'smoothbox buttonlink sesbasic_icon_add',)) ?>
      </div>
          <?php if(count($this->educations)>0):?>

      <table class='admin_table'>
        <thead>

          <tr>
            <th><?php echo $this->translate("Education Name") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>

        </thead>
        <tbody>
          <?php foreach ($this->educations as $education): ?>

          <tr>
            <td><?php echo $education->education_name?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesjob', 'controller' => 'educations', 'action' => 'edit-education', 'id' =>$education->education_id), $this->translate('edit'), array(
                'class' => 'smoothbox',
              )) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesjob', 'controller' => 'educations', 'action' => 'delete-education', 'id' =>$education->education_id), $this->translate('delete'), array(
                'class' => 'smoothbox',
              )) ?>
            </td>
          </tr>

          <?php endforeach; ?>

        </tbody>
      </table>

      <?php else:?>
      <br/>
      <div class="tip">
      <span><?php echo $this->translate("There are currently no educations.") ?></span>
      </div>
      <?php endif;?>
    
      </div>
    </form>
  </div>
</div>
