<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sestestimonial/views/scripts/dismiss_message.tpl';?>
<?php $baseURL = $this->layout()->staticBaseUrl; ?>
<div class='admin_search'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />
<div class='clear settings'>
  <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'sestestimonial', 'controller' => 'manage', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()">
    <div>
      <h3><?php echo $this->translate("Manage Testimonials"); ?></h3>
      <p><?php echo $this->translate('Here, you can see all testimonials created by you and your site members.') ?></p>
      <br /><br />
      <?php if(count($this->paginator) > 0):?>
        <div class="sestestimonial_manage_testimonials">
          <div class="sestestimonial_manage_testimonials_head">
            <div style="width:5%">
              <input onclick="selectAll()" type='checkbox' class='checkbox'>
            </div>
            <div style="width:20%">
              <?php echo "User Name";?>
            </div>
            <div style="width:30%">
              <?php echo "Testimonial";?>
            </div>
            <div style="width:20%">
              <?php echo "Designation";?>
            </div>
            <div class="admin_table_centered" style="width:10%">
              <?php echo "Approve";?>
            </div>
            <div style="width:15%" class="">
              <?php echo "Option";?>
            </div>   
          </div>
          <ul class="sestestimonial_manage_testimonials_list">
            <?php foreach ($this->paginator as $item):
            $user = $this->item('user', $item->user_id); ?>
              <li class="item_label" id="teams_<?php echo $item->testimonial_id ?>">
                <input type='hidden'  name='order[]' value='<?php echo $item->testimonial_id; ?>'>
                <div style="width:5%;">
                  <input name='delete_<?php echo $item->testimonial_id ?>_<?php echo $item->testimonial_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->testimonial_id ?>_<?php echo $item->testimonial_id ?>"/>
                </div>
                <div style="width:20%;">
                  <?php echo $this->htmlLink($user->getHref(), $this->string()->truncate($user->getTitle(), 20), array('target' => '_blank', 'title' => $user->getTitle()))?>
                </div>
                <div style="width:30%;">
                    <?php echo $item->description ?>
                </div>
                <div style="width:20%;">
                  <?php if($item->designation): ?>
                    <?php echo $item->designation ?>
                  <?php else: ?>
                   <?php echo "---"; ?>
                  <?php endif; ?>
                </div>
                <div class="admin_table_centered" style="width:10%;">
                  <?php echo ( $item->approve ? $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestestimonial', 'controller' => 'manage', 'action' => 'approve', 'testimonial_id' => $item->testimonial_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/images/icons/check.png', '', array('title' => $this->translate('Unmark as Approve'))), array()) : $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestestimonial', 'controller' => 'manage', 'action' => 'approve', 'testimonial_id' => $item->testimonial_id), $this->htmlImage('application/modules/Sesbasic/externals/images/icons/error.png', '', array('title' => $this->translate('Mark Approve')))) ) ?>
                </div>
                <div style="width:15%;">          
                  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sestestimonial', 'controller' => 'manage', 'action' => 'delete', 'testimonial_id' => $item->testimonial_id), $this->translate('Delete'), array('class' => 'smoothbox')) ?>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class='buttons'>
          <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
        </div>
      <?php else:?>
        <div class="tip">
          <span>
            <?php echo "There are no testimonial yet.";?>
          </span>
        </div>
      <?php endif;?>
    </div>
  </form>
</div>

<script type="text/javascript"> 
 
  function selectAll(){
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;

    for (i = 1; i < inputs.length - 1; i++) {
      if (!inputs[i].disabled) {
       inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
  function multiDelete(){
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected testimonials?")) ?>');
  }
</script>
