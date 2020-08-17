<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: editdesignation.tpl 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php echo $this->form->setAttrib('class', 'global_form_popup sesteam_desination_popup')->render($this) ?>

<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
