<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php

$staticBaseUrl = $this->layout()->staticBaseUrl;
$this->headScript()
    ->appendFile($staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js')
    ->appendFile($staticBaseUrl . 'application/modules/Sestour/externals/scripts/bootstrap.min.js')
    ->appendFile($staticBaseUrl . 'application/modules/Sestour/externals/scripts/bootstrap-tour.min.js');

$this->headLink()
 ->appendStylesheet($staticBaseUrl . 'application/modules/Sestour/externals/styles/styles.css')

 ; ?>
<div class="sestour_btn">
	<button <?php if($this->tour->automaticopen == 'false' && empty($this->tour->showstartbutton)) { ?> style="display:none;" <?php } ?> type="button" id="sestour_tour"><span class="glyphicon glyphicon-play"></span><?php echo $this->translate("Start Tour"); ?></button>
</div>
<script>

var $demo, duration, remaining, tour;
$demo = sesJqueryObject("#sestour_tour");

var sestooltipduration = <?php echo $this->tour->duration ?>; //Set a expiration time for the steps. When the step expires, the next step is automatically shown. See it as a sort of guided, automatized tour functionality. The value is specified in milliseconds

var sestooltipbackdropPadding = 5; // Add padding to the backdrop element that highlights the step element. it can be a number or a object containing optional top, right, bottom and left numbers.

<?php if($this->userview_id && $this->tour->automaticopen == 'true') { ?>
  var storage = false;
<?php } else { ?>
  var storage = true;
<?php } ?>

// Instance the tour
var tour = new Tour({
  onHidden: function(tour) {
    sesJqueryObject(tour.getStep(tour._current).element).show();
  },
  name: "sestour",
  storage: false,
  debug: false,
  autoscroll: true,
  duration: sestooltipduration,
  template: '<div class="popover" role="tooltip"> <div class="arrow"></div> <h3 class="popover-title"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <?php if($this->tour->showpreviousbutton) { ?> <button class="btn btn-sm btn-default" data-role="prev">&laquo; <?php echo $this->tour->previousbutton_text ?></button> <?php } ?> <?php if($this->tour->shownextbutton) { ?><button class="btn btn-sm btn-default" data-role="next"><?php echo $this->tour->nextbutton_text ?> &raquo;</button><?php } ?> <?php if($this->tour->showpausebutton) { ?><button class="btn btn-sm btn-default" data-role="pause-resume" data-pause-text="<?php echo $this->tour->pausebutton_text ?>" data-resume-text="<?php echo $this->tour->resumebutton_text ?>"><?php echo $this->tour->pausebutton_text ?></button><?php } ?> </div> <?php if($this->tour->showendbutton) { ?><button class="btn btn-sm btn-default" data-role="end"><?php echo $this->tour->endbutton_text ?></button><?php } ?> </div> </div>',
  steps: [
    <?php foreach($this->contents as $content) { ?>
      <?php if($content->backdrop == 'false') { $backdrop = ""; } else { $backdrop = "true"; } ?>
      {
        placement: "<?php echo $content->placement ?>",
        path: "<?php echo @$_SERVER['REDIRECT_URL'] ?>",
        element: ".<?php echo $content->classname; ?>",
        title: "<?php echo $this->string()->escapeJavascript($this->translate(strip_tags($content->title))); ?>",
        content: "<?php echo $this->string()->escapeJavascript($this->translate(strip_tags($content->description))); ?>",
        backdropPadding: sestooltipbackdropPadding,
        backdrop: "<?php echo $backdrop; ?>",
      },
      <?php if(!empty($content->url)) { ?>
      {
        path: "<?php echo $content->url ?>",
      },
      <?php } ?>
    <?php } ?>
  ],
});

<?php if(empty($this->userview_id) && $this->tour->automaticopen != 'nostart') { ?>
  sesJqueryObject(document).ready(function(){
    // Initialize the tour
    tour.init();
    // Start the tour
    tour.start();
  });
<?php } ?>

sesJqueryObject(document).on("click", "#sestour_tour", function(e) {
  e.preventDefault();
  tour.restart();
});
</script>