<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: rename.tpl  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if( !$this->status ): ?>
  <?php echo $this->form->render($this) ?>
<?php else: ?>
  <?php echo $this->translate('Renamed') ?>
  <script type="text/javascript">
    var fileindex = '<?php echo sprintf('%d', $this->fileIndex) ?>';
    var newName = '<?php echo sprintf('%s', $this->fileName) ?>';
    setTimeout(function() {
      //parent.$('admin_file_' + fileindex).getElement('.admin_file_name').set('html', newName);
      parent.window.location.replace( parent.window.location.href );
      parent.Smoothbox.close();
    }, 1000);
  </script>
<?php endif; ?>