<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Seserror/views/scripts/dismiss_message.tpl';?>

<h3 style="margin-bottom:6px;"><?php echo $this->translate("Coming Soon Page Design Template Settings"); ?></h3>
<p><?php echo $this->translate("Here, you can configure the design template settings for the Coming Soon page on your website."); ?></p>
<br style="clear:both;" />

<div class='tabs'>
  <ul class="navigation">
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'comingsoon'), $this->translate('General Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'comingsoon', 'action' => 'designs'), $this->translate('Designs')) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'visitors', 'action' => 'index'), $this->translate('Manage Visitors')) ?>
    </li>
  </ul>
</div>


<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'seserror', 'controller' => 'manage', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo $this->translate("Manage Visitors"); ?></h3>
      <p><?php echo $this->translate('Here, you can manage the visitors who have contacted you from the Coming Soon page. You can email individual visitor using the “Email” link beside each of them or email all visitors using “Email All Visitors” link below.') ?></p>
      <br />
      <div>
        <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'seserror', 'controller' => 'visitors', 'action' => 'mail'), $this->translate('Email All Visitors'), array('class' => ' seserror_icon_email smoothbox buttonlink'))
        ?><br/>
      </div><br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sesbasic_manage_table">
          <div class="sesbasic_manage_table_head">
            <div style="width:25%">
              <?php echo "Name";?>
            </div>
            <div style="width:30%">
              <?php echo "Email";?>
            </div>
             <div class="admin_table_centered" style="width:15%">
              <?php echo "Message";?>
            </div>
            <div style="width:30%" class="">
              <?php echo "Options";?>
            </div>   
          </div>
          <ul class="sesbasic_manage_table_list">
            <?php foreach ($this->paginator as $item): ?>
              <li class="item_label" id="teams_<?php echo $item->visitor_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->visitor_id; ?>'>
                <div style="width:25%;">
                  <?php echo  $item->name; ?>             
                </div>
                <div style="width:30%;">
                  <?php echo $item->email; ?>
                </div>
                <div class="admin_table_centered" style="width:15%;">
                  <?php echo $item->body; ?>
                </div>
                <div style="width:30%;">
                  <a href="mailto:<?php echo $item->email; ?>">Reply</a>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php else:?>
        <div class="tip">
          <span>
            <?php echo "No visitor has contacted yet.";?>
          </span>
        </div>
      <?php endif;?>
    </div>
  </form>
</div>