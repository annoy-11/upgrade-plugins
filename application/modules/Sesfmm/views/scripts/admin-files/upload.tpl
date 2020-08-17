<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: upload.tpl  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate('Back to File Manager')) ?>
</div>

<br />

<div class="error">
  <?php echo $this->error ?>
</div>