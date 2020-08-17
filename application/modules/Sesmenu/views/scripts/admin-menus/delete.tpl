<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if( $this->form ): ?>

  <?php echo $this->form->render($this) ?>

<?php elseif( $this->status ): ?>

  <div><?php echo $this->translate("Deleted") ?></div>

  <script type="text/javascript">
    var name = '<?php echo $this->name ?>';
    setTimeout(function() {
      parent.$('admin_menus_item_' + name).destroy();
      parent.Smoothbox.close();
    }, 500);
  </script>

<?php endif; ?>