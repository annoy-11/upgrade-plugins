<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _company_industry.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(isset($this->companynameActive) || isset($this->industryActive)) { ?>
  <div class="sesjob_sidebar_job_list_date">
    <span>
      <?php $company = Engine_Api::_()->getItem('sesjob_company', $item->company_id); ?>
      <?php if($company) { ?>
        <?php if(isset($this->companynameActive) && isset($item->company_id) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)){ ?>
        <i class="fa fa-building" aria-hidden="true"></i> <a href="<?php echo $company->getHref(); ?>"><?php echo $company->company_name; ?></a>
        <?php } ?>
        <?php if(isset($this->industryActive) && isset($company->industry_id)) { ?>
          <?php $industry = Engine_Api::_()->getItem('sesjob_industry', $company->industry_id); ?>
          <?php if($industry) { ?>
          <?php echo $this->translate($industry->industry_name); ?>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </span>
  </div>  
<?php } ?>
