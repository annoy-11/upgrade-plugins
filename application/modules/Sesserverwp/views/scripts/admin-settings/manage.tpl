<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manage.tpl  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesserverwp/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl;?>

<h3><?php echo $this->translate("Manage Client Sites") ?></h3>
<p><?php echo $this->translate('This page lists all the clients added by you for this site. "Clients", are your other Wordpress sites on which users will Login or Signup when they Login or Signup on this site respectively. Use the "Add a New Client" link below to add new Wordpress Client site.'); ?></p>
<br />

<div style="margin-bottom:15px;">
<?php echo 
$this->htmlLink(
        array(
            'route' => 'default',
            'module' => 'sesserverwp', 
            'controller' => 'admin-settings', 
            'action' => 'add'), 
            $this->translate("Add a New WP Client"), array('class' => 'smoothbox buttonlink sesserverwp_add_icon')) 
?>
</div>
<?php if(count($this->paginator)){ ?>
<div class="sesbasic_search_reasult">
    <?php echo $this->translate(array('%s WP client found.', '%s WP clients found.', count($this->paginator)), $this->locale()->toNumber(count($this->paginator))) ?>
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
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesserverwp', 'controller' => 'admin-settings', 'action' => 'enabled', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesserverwp/externals/images/check.png', '', array('title'=> $this->translate('Disable')))) ?>
              <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesserverwp', 'controller' => 'admin-settings', 'action' => 'enabled', 'id' => $item->getIdentity()), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesserverwp/externals/images/error.png', '', array('title'=> $this->translate('Enable')))) ?>
              <?php endif; ?> 
            </td>
            <td><?php echo $item->creation_date ?></td>
            <td>
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesserverwp', 'controller' => 'admin-settings', 'action' => 'add','client_id'=>$item->getIdentity()), $this->translate("Edit"), array('class' => 'smoothbox')) ?>
              |
              <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesserverwp', 'controller' => 'admin-settings', 'action' => 'delete', 'id' => $item->getIdentity()), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      </div>
    <br />
    
  </form>
  <?php } else { ?>
  <div class="tip"><span>No client added yet!</span></div>
  <?php } ?>
  <div>
  </div>
