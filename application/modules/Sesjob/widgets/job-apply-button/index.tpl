<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(empty($this->viewer_id)) { ?>

<a class="smoothbox" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'company', 'action' => 'apply', 'job_id' => $this->job_id), 'default', true); ?>"><?php echo $this->translate("Apply For Job"); ?></a>

<?php } else { ?>
<?php if(!empty($this->isApplied)) { ?>
  <a href="javascript:void(0);"><?php echo $this->translate("Applied"); ?></a>
<?php } else { ?>
  <a class="smoothbox" href="<?php echo $this->url(array('module' => 'sesjob', 'controller' => 'company', 'action' => 'apply', 'job_id' => $this->job_id), 'default', true); ?>"><?php echo $this->translate("Apply For Job"); ?></a>
<?php } ?>
<?php } ?>
