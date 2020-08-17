<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php 
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/styles/magnific-popup.css');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/styles/styles.css');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/scripts/jquery.magnific-popup.js');
?>
<?php $popupId = $this->popup->popup_id.rand(10,1000); ?>

<a class="sespagebuilder-popup-with-move-anim" <?php if(!$this->show_button){ ?> style="display:none"; <?php } ?> id="ses_popup_an_<?php echo $popupId; ?>" data-effect="<?php echo $this->popup->type ?>" href="#ses_popup_page_<?php echo $popupId; ?>"><?php echo $this->popup->title ?></a>
<div id="ses_popup_page_<?php echo $popupId; ?>" class="white-popup mfp-with-anim mfp-hide">
		<?php echo $this->popup->description; ?>
</div>
<script type="application/javascript">
  jqueryObjectOfSes(document).ready(function() {
    jqueryObjectOfSes(".sespagebuilder-popup-with-move-anim").magnificPopup({
      removalDelay: 500, //delay removal by X to allow out-animation
      callbacks: {
	beforeOpen: function() {
	  this.st.mainClass = this.st.el.attr("data-effect");
	}
      },
      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don\'t provide alternative source.
    });
  });
<?php if($this->auto_open){ ?>
	setTimeout(function(){ jqueryObjectOfSes('#ses_popup_an_<?php echo $popupId; ?>').trigger('click'); }, <?php echo $this->time_execution; ?>);
<?php } ?>
</script>