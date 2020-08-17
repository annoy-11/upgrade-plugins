<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: delete-answer.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php echo $this->form->render($this) ?>
<?php if($this->status){ ?>
<script type="application/javascript">
  parent.window.removeAnswerDiv();
  parent.Smoothbox.close()
</script>
<?php } ?>