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
<div class="sesbasic_breadcrumb">
  <a href="<?php echo $this->url(array('action' => 'home'), 'sesjob_general'); ?>"><?php echo $this->translate("Jobs Home");?></a>&nbsp;&raquo;
  <a href="<?php echo $this->url(array('action' => 'browse'), 'sesjob_companygeneral'); ?>"><?php echo $this->translate("Browse Companies"); ?></a>&nbsp;&raquo;
  <?php echo $this->subject->company_name; ?>
</div>
