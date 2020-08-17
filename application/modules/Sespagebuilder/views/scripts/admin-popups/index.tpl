<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<h3>
  <?php echo $this->translate('Manage Modal Windows') ?>
</h3>
<p>
  <?php echo 'This page lists all the modal windows (popups) created by you using this plugin. You can create new modal window by using “Create New Modal Window” link below. [Note: Modal Windows can be used as shortcodes only in the widgetized pages created using this plugin.]' ?>
</p>
<br />	
<div>
  <?php echo $this->htmlLink(array('action' => 'create', 'reset' => false), $this->translate("Create New Modal Window"),array('class' => 'buttonlink sesbasic_icon_add')) ?>
</div>
<br />
<?php if( count($this->pages) > 0): ?>
<form id='multidelete_form' method="post" action="<?php echo $this->url();?>" >
  <table class='admin_table' style="width:60%;">
    <thead>
      <tr>
        <th>ID</th>
        <th><?php echo $this->translate("Modal Window Name") ?></th>        
        <th><?php echo $this->translate("Type") ?></th>
        <th><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($this->pages as $item): ?>
      <tr>
        <td><?php echo $item->popup_id ?></td>
        <td><?php echo $item->title; ?></td>
         <?php 
         $popupStyle = array('mfp-zoom-in'=>' Zoom In','mfp-newspaper'=>'Zoom Roll','mfp-move-horizontal'=>'Move Horizontal','mfp-move-from-top'=>'Move From Top','mfp-3d-unfold'=>'Unfold','mfp-zoom-out'=>'Zoom Out'); 
          if($item->type == 'mfp-zoom-in')
          $type = 'Zoom In';
          else if($item->type == 'mfp-newspaper')
          $type = 'Zoom Roll';
          else if($item->type == 'mfp-move-horizontal')
          $type = 'Move Horizontal';
          else if($item->type == 'mfp-move-from-top')
          $type = 'Move From Top';
          else if($item->type == 'mfp-3d-unfold')
          $type = 'Unfold';
          else if($item->type == 'mfp-zoom-out')
          $type = 'Zoom Out';
          else
          $type = 'Unknown';
        ?>        
        <td><?php echo $type; ?></td>
        <td>
          <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'edit', 'id' => $item->popup_id ), $this->translate("Edit")) ?>
          |
          <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'delete', 'id' => $item->popup_id ), $this->translate("Delete"), array('class' => 'smoothbox')) ?>
          |
         <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'popups', 'action' => 'duplicate-model', 'id' => $item->popup_id), $this->translate("Duplicate Modal Window"),array('class' => 'smoothbox')) ?>
         |
         <?php echo $this->htmlLink('javascript:void(0)', $this->translate("Get Shortcode"),array('onclick' => 'getShortCode(\''.$item->popup_id.'\');')) ?>    
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</form>
<?php else: ?>
<div class="tip">
  <span>
    <?php echo $this->translate("You have not create any modal window yet.") ?>
  </span>
</div>
<?php endif; ?>

<script>
  var getShortCode = function(popupId) {
    Smoothbox.open('<div><h3>Shortcode</h3><p>Copy the below shortcode and use in desired Widgetized Pages created using this plugin.</p><input type=\'text\' style=\'width:200px\' /><br /><br /><button onclick="Smoothbox.close();">Close</button></div>', {autoResize : true});
    Smoothbox.instance.content.getElement('input').set('value', '[ses_popup_'+popupId+']').focus();
    Smoothbox.instance.content.getElement('input').select();
    Smoothbox.instance.doAutoResize();
  }
</script>