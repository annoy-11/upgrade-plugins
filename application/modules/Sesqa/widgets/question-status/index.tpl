<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
  <span class="sesqa_qstatus" style="background-color: #<?php echo $this->color; ?>;color: #<?php echo $this->text; ?>;"><?php echo $this->question->open_close ? $this->translate('SESClose') : $this->translate("SESOpen"); ?></span>