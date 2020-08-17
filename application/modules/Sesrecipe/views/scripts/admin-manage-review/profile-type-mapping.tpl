<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: profile-type-mapping.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/dismiss_message.tpl';?>

<div class='clear sesbasic-form'>
  <div>
    <?php if( count($this->subnavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subnavigation)->render(); ?>
      </div>
    <?php endif; ?>
    <div class="sesbasic-form-cont">
      <div class='settings sesbasic_admin_form'>
				<h3><?php echo $this->translate("Category Mapping with Profile Type") ?> </h3>
				<p class="description">
				  <?php echo $this->translate("Here, you can map category with profile type.") ?>
				</p>
				<?php if (count($this->results) > 0): ?>
				<table class='admin_table' style="width: 60%;">
				  <thead>
				    <tr>
				      <th><?php echo $this->translate("Category Name") ?></th>
				      <th><?php echo $this->translate("Profile Type") ?></th>
				      <th><?php echo $this->translate("Option") ?></th>
				    </tr>
				  </thead>
				  <tbody>
				    <?php foreach ($this->results as $result):  ?>
				    <tr>
				      <td><strong class="bold"><?php echo $result['category_name']; ?><strong></td>
				      <?php $isCategoryMapped = Engine_Api::_()->getDbtable('categorymappings', 'sesrecipe')->isCategoryMapped(array('module_name' => $this->module_name, 'category_id' => $result['category_id'], 'column_name' => 'categorymapping_id'));  ?>
				      <?php $mapped = Engine_Api::_()->getDbtable('categorymappings', 'sesrecipe')->isCategoryMapped(array('module_name' => $this->module_name, 'category_id' => $result['category_id'], 'column_name' => 'profile_type'));  ?>
				      <td>
				        <?php if($mapped): ?>
				        <?php echo "Mapped"; ?>
				        <?php else: ?>
				        <?php echo '-----'; ?>
				        <?php endif; ?>
				      </td>
				      <td>
				        <?php if (empty($mapped)): ?>
				        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesrecipe', 'controller' => 'manage-review', 'action' => 'category-mapping', 'category_id' => $result['category_id'], 'module_name' => $this->module_name), $this->translate('Add'), array('class' => 'smoothbox')); ?>
				        <?php else: ?>
				        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesrecipe', 'controller' => 'manage-review', 'action' => 'remove-category-mapping', 'category_id' => $result['category_id'], 'module_name' => $this->module_name, 'categorymapping_id' => $isCategoryMapped), $this->translate('Remove'), array('class' => 'smoothbox')); ?>
				        <?php endif; ?>
				      </td>
				    </tr>
				    <?php endforeach; ?>
				  </tbody>
				</table>
				<?php else: ?>
				  <div class="tip">
				    <span><?php echo $this->translate("No category mapping yet.") ?></span>
				  </div>
				<?php endif; ?>
      </div>
    </div>
  </div>
</div>

