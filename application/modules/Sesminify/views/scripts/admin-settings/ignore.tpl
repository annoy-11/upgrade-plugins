<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ignore.tpl  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php include APPLICATION_PATH .  '/application/modules/Sesminify/views/scripts/dismiss_message.tpl';
?>
<div class="clear">
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script type="application/javascript">
  document.getElementById('sesminify_ignorejs-label').style.display = "none";
</script>
