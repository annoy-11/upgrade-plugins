<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprofilefield/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', '')); ?>
<script>

function showOptions() {
  if(sesJqueryObject('#sesprofilefield_infoadd_btn').hasClass('_expend')) {
    //$('sesprofilefield_infoadd_options').style.display = 'none';
		sesJqueryObject('#sesprofilefield_infoadd_btn').removeClass('_expend');
  } else {
    //$('sesprofilefield_infoadd_options').style.display = 'block';
		sesJqueryObject('#sesprofilefield_infoadd_btn').addClass('_expend');
  }
}

function showSubOptions(value) {
  if(value == 1) {
    sesJqueryObject('#sesprofilefield_summary_op').addClass('_expend');
    sesJqueryObject("#sesprofilefield_skills_op").removeClass('_expend');
    sesJqueryObject("#sesprofilefield_acco_op").removeClass('_expend');
  } else if(value == 2) {
    sesJqueryObject('#sesprofilefield_summary_op').removeClass('_expend');
    sesJqueryObject("#sesprofilefield_skills_op").addClass('_expend');
    sesJqueryObject("#sesprofilefield_acco_op").removeClass('_expend');
  } else if(value == 3) {
    sesJqueryObject('#sesprofilefield_summary_op').removeClass('_expend');
    sesJqueryObject("#sesprofilefield_skills_op").removeClass('_expend');
    sesJqueryObject("#sesprofilefield_acco_op").addClass('_expend');
  }
}
</script>

<div class="sesprofilefield_infoadd_btn sesbasic_bxs" id="sesprofilefield_infoadd_btn">
	<span onclick="showOptions();" class="_mainbtn">
  	<span><?php echo $this->translate("Add new profile section"); ?></span>
    <i class="fa fa-caret-down "></i>
  </span>
  <div id="sesprofilefield_infoadd_options" class="sesprofilefield_infoadd_options">
  	<ul>
      <?php if(in_array('experience', $this->allowprofile) || in_array('education', $this->allowprofile)) { ?>
        <li onclick="showSubOptions(1);" id="sesprofilefield_summary_op" class="_expend">
          <div class="_suboptionshead">
            <span><?php echo $this->translate("Summary"); ?></span>
            <i class="fa fa-angle-down sesbasic_text_light"></i>
          </div>
          <div class="_suboptions">
            <?php if($this->exper_count > count($this->experienceEntries) && in_array('experience', $this->allowprofile)) { ?>
              <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-experience'), 'default', true);?>" class="sessmoothbox _work">
                <i class="_icon"></i>
                <i class="_plisicon fa fa-plus"></i>
                <span class="_title"><?php echo $this->translate('Work Experience'); ?></span>
              </a>	
            <?php } ?>
            <?php if($this->edution_count > count($this->educationEntries) && in_array('education', $this->allowprofile)) { ?>
              <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-education'), 'default', true);?>" class="sessmoothbox _edu">
                <i class="_icon"></i>
                <i class="_plisicon fa fa-plus"></i>
                <span class="_title"><?php echo $this->translate('Education'); ?></span>
              </a>
            <?php } ?>
          </div>
        </li>
      <?php } ?>
      <?php if($this->skill_count > count($this->skills) && in_array('skills', $this->allowprofile)) { ?>
        <li onclick="showSubOptions(2);" id="sesprofilefield_skills_op">
          <div class="_suboptionshead">
            <span><?php echo $this->translate("Skills") ;?></span>
            <i class="fa fa-angle-down sesbasic_text_light"></i>
          </div>
          <div class="_suboptions">
            <a href="<?php echo $this->url(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-skill'), 'default', true);?>" class="sessmoothbox _skill">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Skills'); ?></span>
            </a>	
          </div>
        </li>
      <?php } ?>
      <?php if(in_array('certificate', $this->allowprofile) || in_array('awards', $this->allowprofile) || in_array('organization', $this->allowprofile) || in_array('course', $this->allowprofile) || in_array('project', $this->allowprofile) || in_array('language', $this->allowprofile)) { ?>
        <li onclick="showSubOptions(3);" id="sesprofilefield_acco_op">
          <div class="_suboptionshead">
            <span><?php echo $this->translate("Accomplishments"); ?></span>
            <i class="fa fa-angle-down sesbasic_text_light"></i>
          </div>
          <div class="_suboptions">
            <?php if($this->cer_count > count($this->certificationEntries) && in_array('certificate', $this->allowprofile)) { ?>
              <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-certification'), 'default', true);?>" class="sessmoothbox _certification">
                <i class="_icon"></i>
                <i class="_plisicon fa fa-plus"></i>
                <span class="_title"><?php echo $this->translate('Certification'); ?></span>
              </a>
            <?php } ?>
            <?php if($this->awards_count > count($this->awardEntries) && in_array('awards', $this->allowprofile)) { ?>
            <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-award'), 'default', true);?>" class="sessmoothbox _awards">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Honors & Awards'); ?></span>
            </a>
            <?php } ?>
            <?php if($this->org_count > count($this->organizationEntries) && in_array('organization', $this->allowprofile)) { ?>
            <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-organization'), 'default', true);?>" class="sessmoothbox _organizations">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Organizations'); ?></span>
            </a>
            <?php } ?>
            <?php if($this->course_count > count($this->courseEntries) && in_array('course', $this->allowprofile)) { ?>
            <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-course'), 'default', true);?>" class="sessmoothbox _courses">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Courses'); ?></span>
            </a>
            <?php } ?>
            <?php if($this->project_count > count($this->projectEntries) && in_array('project', $this->allowprofile)) { ?>
            <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-project'), 'default', true);?>" class="sessmoothbox _projects">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Projects'); ?></span>
            </a>
            <?php } ?>
            <?php if($this->lng_count > count($this->languages) && in_array('language', $this->allowprofile)) { ?>
            <a href="<?php echo $this->url(array('module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'add-language'), 'default', true);?>" class="sessmoothbox _languages">
              <i class="_icon"></i>
              <i class="_plisicon fa fa-plus"></i>
              <span class="_title"><?php echo $this->translate('Languages'); ?></span>
            </a>
            <?php } ?>
          </div>  
        </li>
      <?php } ?>
		</ul>
  </div>
</div>
