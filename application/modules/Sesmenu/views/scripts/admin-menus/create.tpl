<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( $this->form ): ?>

  <?php echo $this->form->render($this) ?>

<?php elseif( $this->status ): ?>

  <div><?php echo $this->translate("Your changes have been saved."); ?></div>

  <script type="text/javascript">
    setTimeout(function() {
      parent.window.location.replace( '<?php echo $this->url(array('action' => 'index', 'name' => $this->selectedMenu->name)) ?>' )
    }, 500);
  </script>

<?php endif; ?>