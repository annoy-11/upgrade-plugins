<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesinterest/views/scripts/dismiss_message.tpl';?>
<div>
  <h3><?php echo $this->translate('Manage Interests'); ?></h3>
  <p class="description">
    <?php  ?>
  </p> 
  <div class='admin_search sesbasic_search_form'>
    <?php echo $this->formFilter->render($this) ?>
  </div>  
  <br />
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'add'), $this->translate('Add New Interests'), array('class' => 'buttonlink smoothbox sesbasic_icon_add')) ?><br /><br />        
  <?php if(count($this->paginator)>0):?>
  <div class="sesnewsletter_search_reasult">
    <?php echo $this->translate(array('%s interest found.', '%s interests found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
  </div>
  <br />
  <table class='admin_table' style="width: 100%;">
    <thead>
      <tr>
        <th><?php echo $this->translate("Interest Name") ?></th>
        <th align="center"><?php echo $this->translate("Owner Name") ?></th>
        <th align="center"><?php echo $this->translate("Approved") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->paginator as $interest): ?>
      <tr>
        <td><b class="bold"><?php echo $interest->interest_name ?></b></td>
        <?php $user = Engine_Api::_()->getItem('user', $interest->user_id); ?>
        <td  class="admin_table_centered"><b class="bold"><a href="<?php echo $user->getHref(); ?>"><?php echo $user->getTitle() ?></a></b></td>
        <td class="admin_table_centered">
          <?php if(empty($interest->created_by)) { ?>
            <?php if($interest->approved == 1):?>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'approved', 'id' => $interest->interest_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) ?>
            <?php else: ?>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'approved', 'id' => $interest->interest_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved')))) ?>
            <?php endif; ?>
          <?php } else { ?>
            <?php if($interest->approved == 1):?>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'approved', 'id' => $interest->interest_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Unmark as Approved')))) ?>
            <?php else: ?>
              <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'approved', 'id' => $interest->interest_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Mark Approved')))) ?>
            <?php endif; ?>
          <?php } ?>
        </td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'edit', 'id' => $interest->interest_id), $this->translate('Edit'), array('class' => 'smoothbox')) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesinterest', 'controller' => 'manage', 'action' => 'delete', 'id' => $interest->interest_id), $this->translate('Delete'), array('class' => 'smoothbox')); ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <br />
  <div>
    <?php echo $this->paginationControl($this->paginator); ?>
  </div>
  <?php else:?>
  <br/>
  <div class="tip">
    <span><?php echo $this->translate("There are currently no interests.") ?></span>
  </div>
  <?php endif;?>
</div>

