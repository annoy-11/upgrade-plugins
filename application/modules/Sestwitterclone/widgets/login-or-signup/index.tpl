<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( !$this->noForm ): ?>
  <?php echo $this->form->render($this) ?>
  <?php if( !empty($this->fbUrl) ): ?>
    <script type="text/javascript">
      var openFbLogin = function() {
        Smoothbox.open('<?php echo $this->fbUrl ?>');
      }
      var redirectPostFbLogin = function() {
        window.location.href = window.location;
        Smoothbox.close();
      }
    </script>
  <?php endif; ?>
<?php else: ?>
  <?php echo $this->form->setAttrib('class', 'global_form_box no_form')->render($this) ?>
<?php endif; ?>
