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
  /*$languageColumn = '';
  $local_language = $this->locale()->getLocale()->__toString();
  if( 1 !== count($this->languageNameList)) {
    $languageColumn = $local_language.'_';
  }*/
   $languageColumn = '';
  if( 1 !== count($this->languageNameList)) {
    $languageColumn = $_COOKIE['en4_language'].'_';
  }
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $tabs_count = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12); ?>
<?php if($this->showViewType == 0): ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-2.1.3.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery.responsiveTabs.js'); ?>
  <style type="text/css">

    #horizontalTab_<?php echo $this->identity; ?> {
      width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;
    }
    <?php if($this->customcolor):?>
			#horizontalTab_<?php echo $this->identity; ?> {
				background-color: #<?php echo $this->headingBgColor; ?>;
				border-color: #<?php echo $this->headingBgColor; ?>;
			}
			
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-nav .r-tabs-tab a,
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-accordion-title .r-tabs-anchor a{
				background-color: #<?php echo $this->tabBgColor ?>;
				color:#<?php echo $this->tabTextBgColor ?>;
				font-size:<?php echo $this->tabTextFontSize ?>px;
			}
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-nav .r-tabs-tab a:hover,
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-accordion-title .r-tabs-anchor a:hover,
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-nav .r-tabs-state-active .r-tabs-anchor,
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-accordion-title.r-tabs-state-active .r-tabs-anchor{
				background-color: #<?php echo $this->tabActiveBgColor?>;
				color:#<?php echo $this->tabActiveTextColor ?>;
			}
			#horizontalTab_<?php echo $this->identity; ?> .r-tabs-panel{
				background-color: #<?php echo $this->descriptionBgColor?>;
			}
    <?php endif;?>
  </style>
  
  
  <div id="horizontalTab_<?php echo $this->identity ?>" class="sesbasic_clearfix sesbasic_bxs sesbd sespagebuilder_r_tabs">
    <ul>
      <?php foreach($tabs_count as $tab): ?>
	<?php 
	$tabBody = $languageColumn.'tab'.$tab.'_body';
        $tabName = $languageColumn.'tab'.$tab.'_name';
	//$tabName = "tab".$tab."_name";
	//$tabBody = "tab".$tab."_body";
  
  
	$tab_id = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)."#tab-" .$tab . "_$this->identity"; ?>
	<?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
	  <li><a href="<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></a></li>
	<?php endif; ?>
      <?php endforeach; ?>
    </ul>
    <?php foreach($tabs_count as $tab): 
     $tabBody = $languageColumn.'tab'.$tab.'_body';
     $tabName = $languageColumn.'tab'.$tab.'_name';
   // $tabBody = "tab".$tab."_body";
    $tab_id = "tab-" .$tab . "_$this->identity"; 
   // $tabName = "tab".$tab."_name";
    ?>
    <?php if(!empty($tabName) && !empty($this->tabs[$tabBody])): ?>
    <div id="<?php echo $tab_id ?>" class="sespagebuilder_page_content" style="max-height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;overflow:auto;">
      <p><?php echo $this->tabs[$tabBody]; ?></p>
    </div>
    <?php endif; ?>
    <?php endforeach;  ?>
  </div>
  <script type="text/javascript">
    fixedPagesSES(document).ready(function() {
      fixedPagesSES("#horizontalTab_<?php echo $this->identity ?>").responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
        setHash: true,
        // disabled: [3,4],
        activate: function(e, tab) {
          fixedPagesSES('.info').html('Tab <strong>' + tab.id + '</strong> activated!');
        },
        activateState: function(e, state) {
          //console.log(state);
          fixedPagesSES('.info').html('Switched from <strong>' + state.oldState + '</strong> state to <strong>' + state.newState + '</strong> state!');
        }
      });

      fixedPagesSES('#start-rotation').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->identity ?>").responsiveTabs('startRotation', 1000);
      });
      fixedPagesSES('#stop-rotation').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->identity ?>").responsiveTabs('stopRotation');
      });
      fixedPagesSES('#start-rotation').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->identity ?>").responsiveTabs('active');
      });
      fixedPagesSES('.select-tab').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->identity ?>").responsiveTabs('activate', fixedPagesSES(this).val());
      });

    });
  </script> 
<?php elseif($this->showViewType == 1): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
  <style type="text/css">
    .container_<?php echo $this->identity ?> .sespagebuilder_ac_container{
      width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;
    }
    .sespagebuilder_ac_container input:checked ~ article{
     height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;
    }
    <?php if($this->customcolor):?>
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container label{
				background-color: #<?php echo $this->tabBgColor ?>;
				color:#<?php echo $this->tabTextBgColor ?>;
				font-size:<?php echo $this->tabTextFontSize ?>px;
			}
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container label:hover,
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container input:checked + label{
				background-color: #<?php echo $this->tabActiveBgColor?>;
				color:#<?php echo $this->tabActiveTextColor ?>;
			}
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container article{
				background-color: #<?php echo $this->descriptionBgColor?>;
			}
    <?php endif;?>
  </style>
  <div class="container_<?php echo $this->identity ?>">
    <section class="sespagebuilder_ac_container sesbasic_bxs sesbasic_clearfix sesbm">
      <?php foreach($tabs_count as $tab): 
        $tabBody = $languageColumn.'tab'.$tab.'_body';
        $tabName = $languageColumn.'tab'.$tab.'_name';
       // $tabBody = "tab".$tab."_body";
        $tab_id = "tab-" .$tab . "_$this->identity"; 
      //  $tabName = "tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
        <div class=""sesbm sesbasic_clearfix">
          <input id="ac-<?php echo $tab_id ?>" name="accordion-1" type="radio" checked />
          <label for="ac-<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></label>
          <article class="sesbasic_custom_scroll sespagebuilder_page_content">
            <p><?php echo $this->tabs[$tabBody]; ?></p>
          </article>
        </div>
      <?php endif; ?>
      <?php endforeach; ?>
    </section>
  </div>
<?php elseif($this->showViewType == 2): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
	<style type="text/css">
    .container_<?php echo $this->identity ?> .sespagebuilder_ac_container{
      width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;
    }
    .sespagebuilder_ac_container input:checked ~ article{
     height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;
    }
    <?php if($this->customcolor):?>
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container label{
				background-color: #<?php echo $this->tabBgColor ?>;
				color:#<?php echo $this->tabTextBgColor ?>;
				font-size:<?php echo $this->tabTextFontSize ?>px;
			}
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container label:hover,
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container input:checked + label{
				background-color: #<?php echo $this->tabActiveBgColor?>;
				color:#<?php echo $this->tabActiveTextColor ?>;
			}
			.container_<?php echo $this->identity ?> .sespagebuilder_ac_container article{
				background-color: #<?php echo $this->descriptionBgColor?>;
			}
    <?php endif;?>
  </style>
  <div class="container_<?php echo $this->identity ?>">
    <section class="sespagebuilder_ac_container sesbasic_bxs sesbasic_clearfix sesbm">
      <?php foreach($tabs_count as $tab): 
        $tabBody = $languageColumn.'tab'.$tab.'_body';
        $tabName = $languageColumn.'tab'.$tab.'_name'; 
       // $tabBody = "tab".$tab."_body";
        $tab_id = "tab-" .$tab . "_$this->identity"; 
       // $tabName = "tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
      <div class="sesbm sesbasic_clearfix">
        <input id="ac-<?php echo $tab_id ?>" name="accordion-1" type="checkbox" />
        <label for="ac-<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></label>
        <article class="sesbasic_custom_scroll sespagebuilder_page_content">
          <p><?php echo $this->tabs[$tabBody]; ?></p>
        </article>
      </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </section>
  </div>
<?php endif; ?>