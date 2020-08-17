<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: documenttypes.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesuserdocverification/views/scripts/dismiss_message.tpl';?>

<div class='sesbasic-form'>
  <div>
    <form class="sesbasic-form-cont">
      <div>
      <h3><?php echo $this->translate("Manage Document Types") ?></h3>
      <p class="description">
        <?php echo $this->translate('This page displays all Document Types that you have created for getting documents uploaded on your website for verification. To create new document type, use "Add New Document Type" from below.') ?>
      </p>

      <div style="margin-bottom:10px;">
     		<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesuserdocverification', 'controller' => 'manage', 'action' => 'add'), $this->translate('Add New Document Type'), array('class' => 'smoothbox buttonlink', 'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Sesuserdocverification/externals/images/add.png);')) ?>
      </div>
      <?php if(count($this->documenttypes) > 0):?>
        <table class='admin_table' style="width:50%;">
          <thead>
            <tr>
              <th><?php echo $this->translate("Document Type Name") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->documenttypes as $documenttype): ?>
            <tr>
              <td><?php echo $documenttype->document_name?></td>
              <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesuserdocverification', 'controller' => 'manage', 'action' => 'edit', 'id' =>$documenttype->documenttype_id), $this->translate('edit'), array(
                  'class' => 'smoothbox',
                )) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesuserdocverification', 'controller' => 'manage', 'action' => 'delete', 'id' =>$documenttype->documenttype_id), $this->translate('delete'), array(
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
        <span><?php echo $this->translate("There are currently no document type.") ?></span>
        </div>
      <?php endif;?>
      </div>
    </form>
  </div>
</div>