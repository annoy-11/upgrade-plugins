<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-review.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="application/javascript">
  Sessmoothbox.css.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbusinessreview/externals/styles/styles.css'; ?>");
  Sessmoothbox.javascript.push("<?php echo $this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'; ?>");
</script>
<div class="sesbusinessreview_editreview_popup">
  <?php echo $this->form->render($this);?>
</div>
<script type="text/javascript">
  function closeReviewForm() {
    sessmoothboxclose();
  }
</script>
<script type="application/javascript">
 executetimesmoothboxTimeinterval = 700;
 executetimesmoothbox = true;
 en4.core.runonce.add(function() {
   sesJqueryObject('#sesbusinessreview_review_form').attr('action',sesJqueryObject('#sesbusinessreview_review_form').attr('action').replace('?format=html&typesmoothbox=sessmoothbox',''));   
   tinymce.init({
     mode: "specific_textareas",
     plugins: "table,fullscreen,media,preview,paste,code,image,textcolor,jbimages,link",
     theme: "modern",
     menubar: false,
     statusbar: false,
     toolbar1:  "undo,redo,removeformat,pastetext,|,code,media,image,jbimages,link,fullscreen,preview",
     toolbar2: "fontselect,fontsizeselect,bold,italic,underline,strikethrough,forecolor,backcolor,|,alignleft,aligncenter,alignright,alignjustify,|,bullist,numlist,|,outdent,indent,blockquote",
     toolbar3: "",
     element_format: "html",
     height: "225px",
content_css: "bbcode.css",
entity_encoding: "raw",
add_unload_trigger: "0",
remove_linebreaks: false,
     convert_urls: false,
     language: "<?php echo $this->language; ?>",
     directionality: "<?php echo $this->direction; ?>",
     upload_url: "<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'index', 'action' => 'upload-image'), 'default', true); ?>",
     editor_selector: "tinymce"
   });
 });
</script>	
<?php die; ?>