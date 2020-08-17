<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl;?>

<div class="admin_results" style="margin-bottom:10px;">
<a class="smoothbox buttonlink sesbasic_icon_add" href="<?php echo $this->url(array('action' => 'add')); ?>"><?php echo $this->translate('Add New Compliment Type');?></a>
</div>
<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s compliment found.", "%s compliments found.", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
  </div>
</div>
<br />

<?php if(count($this->paginator) > 0):?>
<div class="admin_table_form">
<form>
  <table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;'><?php echo $this->translate("ID") ?></th>
        <th><?php echo $this->translate("Title") ?></th>
        <th><?php echo $this->translate("Image") ?></th>
        <th style='width: 1%;' class='admin_table_options'><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):?>
          <tr>
            <td><?php echo $item->getIdentity(); ?></td>
            <td class='admin_table_bold'>
              <?php echo $item->title; ?>
            </td>
           <td>
           		<?php
                $photoUrl = Engine_Api::_()->storage()->get($item->file_id, '')->getPhotoUrl();
                if(strpos($photoUrl,'http') === FALSE)
               	 $photoUrl = 'http://' . $_SERVER['HTTP_HOST'] . $photoUrl;
     					 ?>
              <img src="<?php echo $photoUrl; ?>" style="height:50px; widows:50px;" />
              
           </td>
            <td class='admin_table_options'>
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'edit', 'id' => $item->getIdentity()));?>'>
                <?php echo $this->translate("Edit") ?>
              </a>
              |
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'delete', 'id' => $item->getIdentity()));?>'>
                <?php echo $this->translate("Delete") ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
</form>
</div>
<?php else:?>
<div class="tip">
  <span>
    <?php echo $this->translate("There are no compliment created by you yet.");?>
  </span>
</div>
<?php endif;?>