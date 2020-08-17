<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Payment
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9924 2013-02-16 02:16:02Z alex $
 * @author     John Boehr <j@webligo.com>
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Ememsub/views/scripts/dismiss_message.tpl';?>
<div class="sesbasic-form sesbasic-categories-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3><?php echo $this->translate("Create New Templete") ?></h3>
      <div class="sesbasic_search_reasult">
        <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate('Back to Manage Template'), array('class' => 'buttonlink sesbasic_icon_back')) ?>
      </div>
      <?php $counter = $this->paginator->getTotalItemCount(); ?> 
      <?php if( count($this->paginator) ): ?>
        <div class="sesbasic_search_reasult">
          <?php echo $this->translate(array('%s Package found.', '%s Packages found.', $counter), $this->locale()->toNumber($counter)) ?>
        </div>
        <form id='multidelete_form' method="post" action="<?php echo $this->url();?>">
          <div class="admin_table_form">
            <table class='admin_table'>
              <thead>
                <tr>
                  <th class='admin_table_short' style="width:1%;"><a href="javascript:void(0);" onclick="javascript:changeOrder('package_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
                  <th style="width:60%;"><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate("Title") ?></a></th>
                  <th style="width:20%;"><?php echo $this->translate("Options") ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($this->paginator as $item):?>
                <tr>
                  <td><?php echo $item->package_id ?></td>
                  <td><?php echo $this->translate(Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(),50)); ?></td>
                  <td>
                    <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'ememsub', 'controller' => 'admin-templete', 'action' => 'create', 'package_id' => $item->package_id,'template_id'=>$this->template_id), $this->translate("Change style")) ?> 
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        	</div>
        </form>
        <div>
          <?php echo $this->paginationControl($this->paginator,null,null,$this->urlParams); ?>
        </div>
      <?php else:?>
        <div class="tip">
          <span>
            <?php echo $this->translate("There are no templete created by your members yet.") ?>
          </span>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>      
