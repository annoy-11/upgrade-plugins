<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: verify.tpl  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if( $this->status ): ?>
  <script type="text/javascript">
    setTimeout(function() {
      parent.window.location.href = '<?php echo $this->url(array(), 'user_login', true); ?>';
    }, 5000);
  </script>
  <?php echo $this->translate("Your account has been verified. Please wait to be redirected or click %s to login.", $this->htmlLink(array('route'=>'user_login'), $this->translate("here"))) ?>
<?php else: ?>
  <div class="error">
    <span>
      <?php echo $this->translate($this->error) ?>
    </span>
  </div>
<?php endif;