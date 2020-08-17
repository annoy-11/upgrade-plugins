<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete.tpl  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( !$this->status ): ?>
  <?php echo $this->form->render($this) ?>
<?php else: ?>
  <?php echo $this->translate('Deleted') ?>
  <script type="text/javascript">
    var fileindex = '<?php echo sprintf('%d', $this->fileIndex) ?>';
    setTimeout(function() {
      //parent.$('admin_file_' + fileindex).destroy();
      parent.Smoothbox.close();
      setTimeout(function() {
        parent.window.location.replace( parent.window.location.href );
      }, 250);
    }, 1000);
  </script>
<?php endif; ?>