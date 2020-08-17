<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: add.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
<div class='courses_addwishlist_popup'>
  <?php if( isset($this->success) ): ?>
  <div class="global_form_popup_message">
    <?php if( $this->success ): ?>
    <p><?php echo $this->message ?></p>
    <br />

    <?php elseif( !empty($this->error) ): ?>
    <pre style="text-align:left"><?php echo $this->error ?></pre>
    <?php else: ?>
    <p><?php echo $this->translate('There was an error processing your request.  Please try again later.') ?></p>
    <?php endif; ?>
  </div>
  <?php return; endif; ?>
  <?php echo $this->form->render($this) ?>
</div>
<script type="text/javascript">
  function updateTextFields() {
    if ($('wishlist_id').value == 0) {
      $('title-wrapper').show();
      $('description-wrapper').show();
      $('mainphoto-wrapper').show();
			$('is_private-wrapper').show();
    } else {
      $('title-wrapper').hide();
			$('is_private-wrapper').hide();
      $('description-wrapper').hide();
      $('mainphoto-wrapper').hide();
    }
    parent.Smoothbox.instance.doAutoResize();
  }
  en4.core.runonce.add(updateTextFields);
</script>
