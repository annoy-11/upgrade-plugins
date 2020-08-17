<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/seslinkedin/landing_page.css'); ?>
  <div class="lp_job_section">
     <div class="lp_container lp_job_inner">
         <div class="lp_job_head">
          <?php if(!empty($this->heading) && $this->heading != ''): ?>
                <h2><?php echo $this->translate($this->heading); ?></h2>
          <?php endif; ?>
         </div>
         <div class="lp_intro_cont">
            <h2><?php echo $this->translate('SUGGESTED SEARCHES'); ?></h2>
            <ul>
          	<?php foreach($this->paginator as $value):?> 	
                <?php if($value['category_name'] == '' || empty($value['category_name'])):?><?php continue;?>	
                <?php endif;?>	
               <li><a href="<?php echo $this->url(array('module' =>'sesjob','controller' => 'index', 'action' => 'browse'),'sesjob_general',true).'?category_id='.$value['category_id']; ?>"><?php echo trim($value['category_name']); ?></a></li>
            <?php endforeach;?>
            </ul>
            <a href="javascript:;" class="show_more"><?php echo $this->translate('Show More'); ?><i class="fa fa-angle-down"></i></a>
            <a href="javascript:;" class="show_less"><?php echo $this->translate('Show Less'); ?><i class="fa fa-angle-up"></i></a>
         </div>
     </div>
  </div>
<script>
sesJqueryObject(document).ready(function(){
  sesJqueryObject(".show_more").click(function(){
    sesJqueryObject(".lp_intro_cont").addClass("show");
  });
	sesJqueryObject(".show_less").click(function(){
    sesJqueryObject(".lp_intro_cont").removeClass("show");
  });
});
</script>
