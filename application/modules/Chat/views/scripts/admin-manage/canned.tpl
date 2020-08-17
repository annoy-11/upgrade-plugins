<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Chat
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9915 2013-02-15 01:30:19Z alex $
 * @author     John
 */
?>

<h2><?php echo $this->translate('Chat Plugin') ?></h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>

<p>
  <?php echo $this->translate('Canned Responses.') ?>
</p>

<div>

</div>

<br />

<div class="admin_fields_options">
  
  <?php echo $this->htmlLink(array('action' => 'index','controller'=>'manage', 'module' => 'chat','route'=>'admin_default'), $this->translate('Back'), array(
      'class' => 'buttonlink admin_chat_addroom',
      'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Chat/externals/images/admin/back.png);'
      )) ?>

    <?php echo $this->htmlLink(array('action' => 'create-canned','controller'=>'manage', 'module' => 'chat','route'=>'admin_default','id'=>$this->id), $this->translate('Create Message'), array(
    'class' => 'buttonlink admin_chat_addroom smoothbox',
    'style' => 'background-image: url(' . $this->layout()->staticBaseUrl . 'application/modules/Chat/externals/images/admin/add.png);'
    )) ?>
</div>
<br />


<br />

<table class='admin_table'>
  <thead>
    <tr>
      <th>Message</th>
      <th style='width: 10%;'><?php echo $this->translate('Status') ?></th>
      <th style='width: 10%;' class='admin_table_options'><?php echo $this->translate('Options') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php if( count($this->paginator) ): ?>
      <?php foreach( $this->paginator as $room ): ?>
        <tr>
          <td class='admin_table_bold'><?php echo $room->title ?></td>

            <td>
                <?php if($room->active == 1):?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'chat', 'controller' => 'manage', 'action' => 'status', 'id' => $room->cannedresponse_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title'=> $this->translate('Disable')))) ?>
                <?php else: ?>
                <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'chat', 'controller' => 'manage', 'action' => 'status', 'id' => $room->cannedresponse_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/error.png', '', array('title'=> $this->translate('Enable')))) ?>
                <?php endif; ?>
            </td>

          <td class='admin_table_options'>
            <?php echo $this->htmlLink(array('module'=>'chat','controller'=>'manage','id'=>$room->cannedresponse_id,'action'=>'edit-canned'),
                                       $this->translate('edit'),
                                       array('class'=>'smoothbox')) ?>
            |
            <?php echo $this->htmlLink(array('module'=>'chat','controller'=>'manage','id'=>$room->cannedresponse_id,'action'=>'delete-canned'),
                                       $this->translate('delete'),
                                       array('class'=>'smoothbox')) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<br/>
<div>
  <?php echo $this->paginationControl($this->paginator); ?>
</div>