<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesssoserver
 * @package    Sesssoserver
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>


<?php include APPLICATION_PATH .  '/application/modules/Sesssoserver/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>

<h3><?php echo $this->translate("Manage Client Sites") ?></h3>
<p><?php echo $this->translate('This page lists all the clients added by you for this site. "Clients", are your other SE sites on which users will Login or Signup when they Login or Signup on this site respectively. Use the "Add a New Client" link below to add new Client site.'); ?></p>
<br />

<div style="margin-bottom:15px;">
<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesssoserver', 'controller' => 'admin-settings', 'action' => 'add'), $this->translate("Add a New Client"), array('class' => 'smoothbox buttonlink sesssoserver_add_icon')) ?>
</div>
<?php if( count($this->paginator) ):
$counter = count($this->paginator); ?>
  <div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s client found.', '%s clients found.', $counter), $this->locale()->toNumber($counter)) ?>
  </div>
  <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
    <div class="admin_table_form">
      <table class='admin_table'>
        <thead>
          <tr>
            <th class='admin_table_short'><a href="javascript:void(0);" onclick="javascript:changeOrder('ad_id', 'DESC');"><?php echo $this->translate("ID") ?></a></th>
            <th><a href="javascript:void(0);" ><?php echo $this->translate("Client Site URL") ?></a></th>
            <th><a href="javascript:void(0);"><?php echo $this->translate("Client Secret") ?></a></th>
            <th><a href="javascript:void(0);"><?php echo $this->translate("Client Token") ?></a></th>
            <th align="center"><a href="javascript:void(0);"><?php echo $this->translate("Status") ?></a></th>
            <th><a href="javascript:void(0);"><?php echo $this->translate("Creation Date") ?></a></th>
            <th><?php echo $this->translate("Options") ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($this->paginator as $item): ?>
          <tr>
            <td><?php echo $item->getIdentity() ?></td>
            <td><?php echo $item->url; ?></td>
            <td><?php echo $item->client_secret; ?></td>
            <td><?php echo $item->client_token; ?></td>
            
            <td class="admin_table_centered">
              <?php if($item->active == 1):?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesssoserver', 'controller' => 'admin-settings', 'action' => 'enabled', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesssoserver/externals/images/check.png', '', array('title'=> $this->translate('Disable')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesssoserver', 'controller' => 'admin-settings', 'action' => 'enabled', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesssoserver/externals/images/error.png', '', array('title'=> $this->translate('Enable')))) ?>
              <?php endif; ?>
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesssoserver', 'controller' => 'admin-settings', 'action' => 'add','client_id'=>$item->getIdentity()), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesssoserver', 'controller' => 'admin-settings', 'action' => 'delete', 'id' => $item->getIdentity()), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    
  </form>
  <br/>
  <div>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are no client sites added by you yet.") ?>
    </span>
  </div>
<?php endif; ?>