<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: form.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php echo $this->form->setAttrib('class', 'global_form_popup')->render($this) ?>


<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
