<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>

<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Modal Windows"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />

<?php 
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/styles/magnific-popup.css');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/styles/styles.css');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl. 'application/modules/Sespagebuilder/externals/scripts/jquery.magnific-popup.js');
?>
<div class='clear sesbasic_admin_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div id="ses_test_form" class="white-popup mfp-with-anim mfp-hide">
  <?php echo "This is a test popup window.";?>
<div>
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
</script>