<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: subscriber.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbrowserpush/views/scripts/dismiss_message.tpl';
?>
<div class="sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <h3><?php echo $this->translate("Manage Subscribers"); ?></h3>
      <p><?php echo $this->translate("This page lists all the subscribers of the push notifications of your website. Below, you can make any user as test user and test the push notifications to them before sending to other users. You can also send notifications to any specific users. <br>
      Entering criteria into the filter fields will help you find specific subscriber. Leaving the filter fields blank will show all the subscribers on your social network."); ?></p>
      <br>
      <div class='admin_search sesbrowsepush_admin_search'>
        <?php echo $this->formFilter->render($this) ?>
      </div>
      <br />
      
      <?php if( count($this->paginator) ): ?>
        <div class="sesbrowsepush_search_reasult">
          <?php echo $this->translate(array('%s subscriber found.', '%s subscribers found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
        </div>
        <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
        <div style="overflow-x:auto;">
        <table class='admin_table'>
          <thead>
            <tr>
              <th class='admin_table_short center'>ID</th>
              <th class='admin_table_short center'>User Id</th>
              <th class='admin_table_short'><?php echo $this->translate("Display Name") ?></th>
              <th><?php echo $this->translate("Username") ?></th>
              <th><?php echo $this->translate("Email") ?></th>
              <th><?php echo $this->translate("Browser") ?></th>
              <th><?php echo $this->translate("Device") ?></th>
              <th><?php echo $this->translate("IP Address") ?></th>
              <th><?php echo $this->translate("Subscription Date") ?></th>
              <th><?php echo $this->translate("Options") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($this->paginator as $item): ?>
              <tr>
                <td class="admin_table_centered"><?php echo $item->token_id; ?></td>
                <td class="admin_table_centered"><?php echo $item->user_id ? $item->getIdentity() : '-'; ?></td>
                <td>
                  <?php 
                 if($item->user_id) 
                  echo $this->htmlLink($item->getHref(),
                        $this->string()->truncate($item->getTitle(), 16),
                        array('target' => '_blank'));
                        
                 else
                  echo "Guest User";
                 ?>
                </td>
                <td><?php echo $item->user_id ? $this->htmlLink($item->getHref(), $item->username, array('target' => '_blank')) : '-';?></td>
                <td class="admin_table_centered"><?php if($item->user_id) { ?><a href='mailto:<?php echo $item->email ?>'><?php echo $item->user_id ? $item->email : '-'; ?></a><?php }else{ echo "-"; } ?></td>
                 <td><?php echo $item->browser; ?></td>
                 <td><?php echo !empty($item->user_agent) ? ucfirst($item->user_agent) : '---'; ?></td>
                 <td><?php echo $item->ip_address; ?></td>
                 <td><?php echo $this->locale()->toDateTime($item->creation_date) ?></td>
                <td>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'settings', 'action' => 'notification', 'token_id' => $item->token_id), 'Send Notification', array('class' => 'smoothbox')) ?>
                |
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'settings', 'action' => 'removesubscriber', 'token_id' => $item->token_id), 'Remove Subscriber', array('class' => 'smoothbox')) ?>
                |
                <?php if($item->test_user){ ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'settings', 'action' => 'test-user','act'=>'remove', 'id' => $item->user_id,'token_id'=>$item->token_id), 'Remove Test User', array('class' => '')) ?>
                <?php }else{ ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesbrowserpush', 'controller' => 'settings', 'action' => 'test-user','act'=>'add', 'id' => $item->user_id,'token_id'=>$item->token_id), 'Make Test User', array('class' => '')) ?>
                <?php } ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        </div>
        <br />
        <div>
          <?php echo $this->paginationControl($this->paginator); ?>
        </div>
        </form>
        <br />
      <?php else: ?>
        <br />
        <div class="tip">
          <span>
            <?php echo $this->translate("There are no subscribers yet.") ?>
          </span>
        </div>
      <?php endif; ?>
  	</div>
	</div>
</div>      
