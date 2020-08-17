<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _projects.tpl  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $viewer_id = $this->viewer_id; ?>
<?php foreach($this->projectEntries as $project) { ?>
  <li id="sesprofilefield_project_<?php echo $project->project_id; ?>" class="sesbasic_clearfix">
    <div class="project_details_main">
      <div class="project_details">
        <p class="project_title">
          <?php echo $project->title; ?>
        </p>
        <p class="project_company">
          <?php if($project->associate_with) { ?>
            <span><?php echo $project->associate_with; ?></span>
          <?php } ?>
        </p>
        <p class="project_time sesbasic_text_light">
          <?php if($project->fromyear) { ?>
            <?php echo $project->fromyear; ?>
          <?php } ?>
          <?php if($project->fromyear && $project->toyear) { ?>
            <?php echo " - "; ?>
          <?php } ?>
          <?php if($project->toyear) { ?>
            <?php echo $project->toyear; ?>
          <?php } ?>
        </p>
        <?php if($project->description) { ?>
          <p class="project_des"><?php echo nl2br($project->description); ?></p>
        <?php } ?>
        <?php if($project->project_url) { ?>
          	<span class="project_url"><a href="<?php echo $project->project_url; ?>">See Project</a></span>
          <?php } ?>
      </div>
      <div class="field_option">
        <?php if($viewer_id == $project->owner_id) { ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'edit-project', 'project_id' => $project->project_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-pencil')); ?>
          <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'sesprofilefield', 'controller' => 'index', 'action' => 'delete-project', 'project_id' => $project->project_id), $this->translate(''), array('class' => 'sessmoothbox fa fa-trash')); ?>
        <?php } ?>
      </div>
    </div>
  </li>
<?php } ?>
