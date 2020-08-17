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

<script>

function sesprofilefield_endorsment(resource_id, content_type) {

	var request = sesprofilefield_endorsments(resource_id, content_type,content_type);

	request.addEvent('complete', function(responseJSON) {
		if(responseJSON.endorsement_id )	{
			if($(content_type+'_endorsement_'+ resource_id))
			$(content_type+'_endorsement_'+ resource_id).value = responseJSON.endorsement_id;
			if($(content_type+'_mostEndorsement_'+ resource_id))
			$(content_type+'_mostEndorsement_'+ resource_id).style.display = 'none';
			if($(content_type+'_unendorsement_'+ resource_id))
			$(content_type+'_unendorsement_'+ resource_id).style.display = 'inline-block';
			if($(content_type+'_skillCount_'+ resource_id)) {
				$(content_type + '_skillCount_'+ resource_id).innerHTML = responseJSON.skillCount;
			}
		}	else	{
			if($(content_type+'_endorsement_'+ resource_id))
			$(content_type+'_endorsement_'+ resource_id).value = 0;
			if($(content_type+'_mostEndorsement_'+ resource_id))
			$(content_type+'_mostEndorsement_'+ resource_id).style.display = 'inline-block';
			if($(content_type+'_unendorsement_'+ resource_id))
			$(content_type+'_unendorsement_'+ resource_id).style.display = 'none';
			if($(content_type+'_skillCount_'+ resource_id)) {
				$(content_type + '_skillCount_'+ resource_id).innerHTML = responseJSON.skillCount;
			}
		}
	});
}

function sesprofilefield_endorsments( resource_id, resource_type, content_type ) {
	if($(content_type + '_endorsement_'+ resource_id)) {
		var endorsement_id = $(content_type + '_endorsement_'+ resource_id).value;
	}
	var request = new Request.JSON({
		url : en4.core.baseUrl + 'sesprofilefield/index/endorsements',
		data : {
			format : 'json',
				'resource_id' : resource_id,
				'resource_type' : resource_type,	
				'endorsement_id' : endorsement_id
		}
	});
	request.send();
	return request;
}
</script>
<div class="sesprofilefields_profile_information sesbasic_bxs">
  
  <div class="sesprofilefield_summary">
    <?php if(count($this->experienceEntries) > 0 && in_array('experience', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span>
        <!--<samp id="experience_count"><?php //echo count($this->experienceEntries); ?></samp>-->
        <?php echo $this->translate(" Experiences"); ?></span></h2> <?php if($this->exper_count > count($this->experienceEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-experience" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_experiences" <?php if(count($this->experienceEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_work_experience.tpl'; ?>
        </ul>
        <?php if(count($this->experienceEntries) == 0) { ?>
          <div id="experience_tip"  class="tip">
            <span><?php echo $this->translate("There are no experiences added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
  
    <?php if(count($this->educationEntries) > 0 && in_array('education', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span>
        <!--<samp id="education_count"><?php //echo count($this->educationEntries); ?></samp>-->
        <?php echo $this->translate("Education"); ?></span></h2> <?php if($this->edution_count > count($this->educationEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-education" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_educations" <?php if(count($this->educationEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_educations.tpl'; ?>
        </ul>
        <?php if(count($this->educationEntries) == 0) { ?>
          <div id="education_tip" class="tip">
            <span><?php echo $this->translate("There are no educations added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
  </div>
  
  <?php if(count($this->skills) > 0 && in_array('skills', $this->allowprofile)) { ?>
    <section class="sesbasic_clearfix sesprofilefield_skills">
      <div class="skills_head">
      <h2><span><?php if(count($this->skills) > 0) { ?><samp id="skill_count"><?php echo count($this->skills); ?></samp><?php } ?><?php echo $this->translate(" Skills"); ?></span></h2> <?php if($this->skill_count > count($this->skills) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-skill" class="sessmoothbox add_entries add_skill">Add Skill</a>
      </div>
      <?php } ?>
      <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_skills" <?php if(count($this->skills) == 0) { ?> style="display:none;" <?php } ?>>
        <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_skills.tpl'; ?>
      </ul>
      <?php if(count($this->skills) == 0) { ?>
        <div id="skill_tip" class="tip">
          <span><?php echo $this->translate("There are no skills added."); ?></span>
        </div>
      <?php } ?>
    </section>
  <?php } ?>
  

  <div class="sesprofilefield_accomplishments">
    <div class="accomplishments_head">
       <h2>
         <span><?php echo $this->translate("Accomplishments"); ?></span>
      </h2>
    </div>
    <?php if(count($this->certificationEntries) > 0 && in_array('certificate', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->certificationEntries) > 0) { ?><samp id="certification_count"><?php echo count($this->certificationEntries); ?></samp> <?php } ?><?php echo $this->translate("Certifications"); ?></span></h2> <?php if($this->cer_count > count($this->certificationEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-certification/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_certifications" <?php if(count($this->certificationEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_certifications.tpl'; ?>
        </ul>
        <?php if(count($this->certificationEntries) == 0) { ?>
          <div id="certification_tip"  class="tip">
            <span><?php echo $this->translate("There are no certifications added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
    
    <?php if(count($this->awardEntries) > 0 && in_array('awards', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->awardEntries) > 0) { ?><samp id="award_count"><?php echo count($this->awardEntries); ?></samp> <?php } ?><?php echo $this->translate("Honors & Awards"); ?></span></h2> <?php if($this->awards_count > count($this->awardEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-award/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_awards" <?php if(count($this->awardEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_awards.tpl'; ?>
        </ul>
        <?php if(count($this->awardEntries) == 0) { ?>
          <div id="award_tip" class="tip">
            <span><?php echo $this->translate("There are no honors & awards added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
    
    <?php if(count($this->organizationEntries) > 0 && in_array('organization', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->organizationEntries) > 0) { ?><samp id="organization_count"><?php echo count($this->organizationEntries); ?></samp> <?php } ?><?php echo $this->translate("Organizations"); ?></span></h2> <?php if($this->org_count > count($this->organizationEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-organization/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_organizations" <?php if(count($this->organizationEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_organization.tpl'; ?>
        </ul>
        <?php if(count($this->organizationEntries) == 0) { ?>
          <div id="organization_tip" class="tip">
            <span><?php echo $this->translate("There are no organizations added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
    
    <?php if(count($this->courseEntries) > 0 && in_array('course', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->courseEntries) > 0) { ?><samp id="course_count"><?php echo count($this->courseEntries); ?></samp> <?php } ?><?php echo $this->translate("Courses"); ?></span></h2> <?php if($this->course_count > count($this->courseEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-course/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_courses" <?php if(count($this->courseEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_courses.tpl'; ?>
        </ul>
        <?php if(count($this->courseEntries) == 0) { ?>
          <div id="course_tip" class="tip">
            <span><?php echo $this->translate("There are no courses added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
    
    <?php if(count($this->projectEntries) > 0 && in_array('project', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->projectEntries) > 0) { ?><samp id="project_count"><?php echo count($this->projectEntries); ?></samp> <?php } ?><?php echo $this->translate("Projects"); ?></span></h2> <?php if($this->project_count > count($this->projectEntries) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-project/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_projects" <?php if(count($this->projectEntries) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_projects.tpl'; ?>
        </ul>
        <?php if(count($this->projectEntries) == 0) { ?>
          <div id="project_tip" class="tip">
            <span><?php echo $this->translate("There are no projects added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
    
    <?php if(count($this->languages) > 0 && in_array('language', $this->allowprofile)) { ?>
      <section class="sesbasic_clearfix">
        <h2><span><?php if(count($this->languages) > 0) { ?><samp id="language_count"><?php echo count($this->languages); ?></samp> <?php } ?><?php echo $this->translate("Languages"); ?></span></h2> <?php if($this->lng_count > count($this->languages) && $this->viewer_id == $this->subject_id) { ?><a href="sesprofilefield/index/add-language/" class="sessmoothbox add_entries">+</a>
        <?php } ?>
        <ul class="sesprofilefield_informaint_list_box" id="sesprofilefield_languages" <?php if(count($this->languages) == 0) { ?> style="display:none;" <?php } ?>>
          <?php include APPLICATION_PATH . '/application/modules/Sesprofilefield/views/scripts/_languages.tpl'; ?>
        </ul>
        <?php if(count($this->languages) == 0) { ?>
          <div id="language_tip"  class="tip">
            <span><?php echo $this->translate("There are no languages added."); ?></span>
          </div>
        <?php } ?>
      </section>
    <?php } ?>
  </div>
</div>
