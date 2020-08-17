

<h2>
    <?php echo $this->translate('Double Banner Slideshow Plugin') ?>
</h2>

<?php if( count($this->navigation) ): ?>
<div class='tabs'>
    <?php
    // Render the menu
    //->setUlClass()
    echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
</div>
<?php endif; ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<div class="sesbasic_search_reasult">
    <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdbslide', 'controller' => 'manage', 'action' => 'manage','id'=>$this->gallery_id), $this->translate("Back to Manage Slides") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
    <div class='settings sesbasic_admin_form'>
        <?php echo $this->form->render($this); ?>
    </div>
</div>

<script type="application/javascript">
  window.addEvent('domready',function() {
    gradient(jqueryObjectOfSes('#enable_gradient').val());
      video_buton(jqueryObjectOfSes ("input[name='video_video_url']:checked").val());
    video_buton_check(jqueryObjectOfSes('#enable_watch_video_button').val());
    double_slide(jqueryObjectOfSes('#enable_double_slide').val());
    cta_button_one(jqueryObjectOfSes('#enable_cta_Button_1').val());
    cta_button_two(jqueryObjectOfSes('#enable_cta_button_2').val());
      overlay(jqueryObjectOfSes ('#enable_overlay').val());
  });
    
function double_slide(value){
        if(value == 1){
			jqueryObjectOfSes('div[id^="dbslide_"]').show();
		}
        else{
			jqueryObjectOfSes('div[id^="dbslide_"]').hide();
			jqueryObjectOfSes('div[id^="dummy_6"]').hide();
			jqueryObjectOfSes('div[id^="remove_dbslide_image"]').hide();
		}	
        jqueryObjectOfSes('#double_slide-wrapper').show();
}
function gradient(value){
    if(value == 1)
      jqueryObjectOfSes('div[id^="gradient_background_color"]').show();
    else
      jqueryObjectOfSes('div[id^="gradient_background_color"]').hide();
}
    function cta_button_one(value){
      if(value == 1)
        jqueryObjectOfSes('div[id^="cta1_"]').show();
      else
        jqueryObjectOfSes('div[id^="cta1_"]').hide();
      jqueryObjectOfSes('#cta_button_one-wrapper').show();
    }

function cta_button_two(value){
        if(value == 1)
                jqueryObjectOfSes('div[id^="cta2_"]').show();
        else
                jqueryObjectOfSes('div[id^="cta2_"]').hide();
        jqueryObjectOfSes('#cta_button_two-wrapper').show();
}

function video_buton(value){
        if(jqueryObjectOfSes ("input[name='video_video_url']:checked").val()  == 4){
            jqueryObjectOfSes('div[id^="video_upload"]').show();
            jqueryObjectOfSes('div[id^="video_video_file_url"]').hide();
        }
        else{
             jqueryObjectOfSes('div[id^="video_upload"]').hide();
            jqueryObjectOfSes('div[id^="video_video_file_url"]').show();
        }
}
function video_buton_check(value){
    if(value == 1){
        jqueryObjectOfSes('div[id^="video_"]').show();
        video_buton(jqueryObjectOfSes ("input[name='video_video_url']:checked").val()  == 4);
    }
    else{
        jqueryObjectOfSes('div[id^="video_"]').hide();
        jqueryObjectOfSes('#dummy_7-wrapper').hide();
        jqueryObjectOfSes('#remove_video-element').hide();


    }
        jqueryObjectOfSes('#video_buton_check-wrapper').show();
}
  function overlay(value){
      if(value == 1)
          jqueryObjectOfSes('div[id^="slide_"]').show();
      else
          jqueryObjectOfSes('div[id^="slide_"]').hide();
      jqueryObjectOfSes('#overlay-wrapper').show();
  }


</script>
<style type="text/css">
    .settings div.form-label label.required:after{
        content:" *";
        color:#f00;
    }
</style>