<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesprofilefield/views/scripts/dismiss_message.tpl';?>


<div class='settings sesbasic_admin_form'>
  <form class="global_form">
    <div>
      <h3><?php echo $this->translate("Manage Specialities") ?> </h3>
      <p class="description">
        <?php echo $this->translate('This Page lists all the specialty fields. You can use this page to monitor & add more. To create new Specialties, use "Add New Specialty" form below.<br />To create 2nd-level Specialties and 3rd-level Specialties, choose respective 1st-level and 2nd-level Specialty from “Parent Specialty” dropdown below. Choose this carefully as you will not be able to edit Parent Specialty later.<br /><br />To reorder the Specialties, click on their names or row and drag them up or down.'); ?>
      </p>        
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'add'), $this->translate('Add New Specialty'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />
      <?php if(count($this->adminspecialties) > 0):?>
      <table class='admin_table' style="width: 100%;">
        <thead>
          <tr>
            <th><?php echo $this->translate("Name") ?></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php //Specialty Work ?>
          <?php foreach ($this->adminspecialties as $specialty): ?>
          <tr>
            <td><b class="bold"><?php echo $specialty->name ?></b></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'edit', 'id' => $specialty->adminspecialty_id,'sptparam' => 'main'), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'delete', 'id' => $specialty->adminspecialty_id, 'sptparam' => 'main'), $this->translate('Delete'), array('class' => 'smoothbox')); ?>               
              <?php if(!$specialty->subid): ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'add', 'adminspecialty_id' => $specialty->adminspecialty_id), $this->translate('Add 2nd-level Specialty'), array('class' => 'smoothbox')) ?>

              <?php endif; ?>
            </td>
          </tr>
          <?php //Subspecialty Work
          $subspecialty = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getModuleSubspecialty(array('column_name' => "*", 'adminspecialty_id' => $specialty->adminspecialty_id));           
          foreach ($subspecialty as $sub_specialty):  ?>
          <tr>
            <td>&rarr; <?php echo $sub_specialty->name ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'edit', 'id' => $sub_specialty->adminspecialty_id,'sptparam' => 'sub'), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'delete', 'id' => $sub_specialty->adminspecialty_id,'sptparam' => 'sub'), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'add', 'adminspecialty_id' => $sub_specialty->adminspecialty_id, 'subid' => $sub_specialty->subid,'sptparam' => 'subsub'), $this->translate('Add 3rd-level Specialty'), array('class' => 'smoothbox')) ?>
              <?php //endif; ?>
            </td>
          </tr>

          <?php //SubSubspecialty Work
          $subsubspecialty = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getModuleSubsubspecialty(array('column_name' => "*", 'adminspecialty_id' => $sub_specialty->adminspecialty_id));
          foreach ($subsubspecialty as $subsub_specialty): ?>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&rarr; <?php echo $subsub_specialty->name ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'edit', 'id' => $subsub_specialty->adminspecialty_id,'sptparam' => 'subsub'), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesprofilefield', 'controller' => 'specialties', 'action' => 'delete', 'id' => $subsub_specialty->adminspecialty_id, 'sptparam' => 'subsub'), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php endforeach; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php else:?>
      <br/>
      <div class="tip">
        <span><?php echo $this->translate("There are currently no specialties.") ?></span>
      </div>
      <?php endif;?>
    </div>
  </form>
</div>
