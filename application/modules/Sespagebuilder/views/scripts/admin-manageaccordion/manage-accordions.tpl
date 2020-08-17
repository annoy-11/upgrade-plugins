<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage-accordion.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<br />	
<div>
  <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder','controller' => 'manageaccordion'), $this->translate("Back to Manage Accordion Menus"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />
<br />
<div class='clear'>
  <div class='settings'>
    <form class="global_form">
      <div>
        <h3><?php echo $this->translate("Manage Accordion Menu Items") ?> </h3>
        <p class="description">
          <?php echo $this->translate("This page lists all the menu items for the associated accordion menu. To create new menu items, use “Create New Accordion Menu Item” link below.") ?>
        </p>        
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'add-accordion', 'content_id' => $this->content_id), $this->translate('Create New Accordion Menu Item'), array('class' => 'buttonlink sesbasic_icon_add')) ?><br /><br />        
        <?php if(count($this->accordions)>0):?>
        <table class='admin_table' style="width: 60%;">
          <thead>
            <tr>
              <th><?php echo $this->translate("Name") ?></th>
              <th><?php echo $this->translate("Icon") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php //Accordion Work ?>
            <?php foreach ($this->accordions as $accordion): ?>
            <?php if($accordion->accordion_id == 0 && $this->resource_type == 'album') : ?>
              <?php continue; ?>
            <?php endif; ?>
            <tr>
              <td><?php echo $accordion->accordion_name ?></td>
              <td>
                <?php if($accordion->accordion_icon): ?>
                	<img style="max-width: 20px;" alt="" src="<?php echo Engine_Api::_()->storage()->get($accordion->accordion_icon, '')->getPhotoUrl(); ?>" />
                <?php else: ?>
                	<?php echo "---"; ?>
                <?php endif; ?>
              </td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $accordion->accordion_id,'cataccordion' => 'maincat', 'content_id' => $this->content_id), $this->translate('Edit'), array()) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete', 'id' => $accordion->accordion_id, 'cataccordion' => 'maincat', 'content_id' => $this->content_id), $this->translate('Delete'), array('class' => 'smoothbox')); ?>               
                <?php if(!$accordion->subaccordion_id): ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'add-accordion', 'accordion_id' => $accordion->accordion_id, 'content_id' => $this->content_id), $this->translate('Add Sub Menu Item'), array()) ?>
                <?php if($accordion->accordion_icon): ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete-icon', 'accordion_id' => $accordion->accordion_id, 'file_id' => $accordion->accordion_icon, 'cataccordion' => 'maincat', 'content_id' => $this->content_id), $this->translate("Delete Icon"), array('class' => 'smoothbox')) ?>
                <?php endif; ?>

                <?php endif; ?>
              </td>
            </tr>
            <?php //Subcategory Work
            $subcategory = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getModuleSubaccordion($accordion->accordion_id);           
            foreach ($subcategory as $sub_accordion):  ?>
            <tr>
              <td>&rarr; <?php echo $sub_accordion->accordion_name ?></td>
              <td>
                <?php if($sub_accordion->accordion_icon): ?>
                <img style="height: 25px;" class="" alt="" src="<?php echo Engine_Api::_()->storage()->get($sub_accordion->accordion_icon, '')->getPhotoUrl(); ?>" />
                <?php else: ?>
                <?php echo "---"; ?>
                <?php endif; ?>
              </td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $sub_accordion->accordion_id,'cataccordion' => 'sub', 'accordion_id' => $sub_accordion->accordion_id, 'content_id' => $this->content_id), $this->translate('Edit'), array()) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete', 'id' => $sub_accordion->accordion_id,'cataccordion' => 'sub', 'content_id' => $this->content_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
                
                <?php //echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'add-accordion', 'accordion_id' => $sub_accordion->accordion_id, 'subaccordion_id' => $sub_accordion->subaccordion_id, 'id' => $this->id, 'content_id' => $this->content_id), $this->translate('Add Subsub Accordion'), array()) ?>
                <?php if($sub_accordion->accordion_icon): ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete-icon', 'accordion_id' => $sub_accordion->accordion_id, 'file_id' => $sub_accordion->accordion_icon, 'cataccordion' => 'sub', 'content_id' => $this->content_id), $this->translate("Delete Icon"), array('class' => 'smoothbox')) ?>
                <?php endif; ?>
                <?php //endif; ?>
              </td>
            </tr>

            <?php //SubSubaccordion Work
            $subsubcategory = Engine_Api::_()->getDbtable('accordions', 'sespagebuilder')->getModuleSubsubaccordion($sub_accordion->accordion_id);
            foreach ($subsubcategory as $subsub_category): ?>
            <tr>
              <td>&nbsp;&nbsp;&nbsp;&nbsp;&rarr; <?php echo $subsub_category->accordion_name ?></td>
              <td><?php if($subsub_category->accordion_icon): ?>
                <img style="height: 25px;" class="" alt="" src="<?php echo Engine_Api::_()->storage()->get($subsub_category->accordion_icon, '')->getPhotoUrl(); ?>" />
                <?php else: ?>
                <?php echo "---"; ?>
                <?php endif; ?>
              </td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'edit-accordion', 'id' => $subsub_category->accordion_id,'cataccordion' => 'subsub', 'content_id' => $this->content_id), $this->translate('Edit'), array()) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete', 'id' => $subsub_category->accordion_id, 'cataccordion' => 'subsub', 'content_id' => $this->content_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
                <?php if($subsub_category->accordion_icon): ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'manageaccordion', 'action' => 'delete-icon', 'accordion_id' => $subsub_category->accordion_id, 'file_id' => $subsub_category->accordion_icon, 'cataccordion' => 'sub', 'content_id' => $this->content_id), $this->translate("Delete Icon"), array('class' => 'smoothbox')) ?>
                <?php endif; ?>
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
          <span><?php echo $this->translate("You have not created any menu item yet.") ?></span>
        </div>
        <?php endif;?>
        <br/>
      </div>
    </form>
  </div>
</div>