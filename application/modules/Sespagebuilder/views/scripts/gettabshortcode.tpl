<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: gettabshortcode.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
 <?php 
  /*$languageColumn = '';
  $local_language = $this->locale()->getLocale()->__toString();
  if($local_language != 'en' && $local_language != 'en_US') {
    $languageColumn = $local_language.'_';
  }*/
  
  $languageColumn = '';
  if( 1 !== count($this->languageNameList)) {
    $languageColumn = $_COOKIE['en4_language'].'_';
  }
  
?>
<?php $this->showViewType = $this->tab_type;?>
<?php $this->tabs = $tab = Engine_Api::_()->getItem('sespagebuilder_tab', $this->tab_id);?>

<?php ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php $tabs_count = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12); ?>
<?php if($this->showViewType == 0): ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery-2.1.3.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/scripts/jquery.responsiveTabs.js'); ?>
<style type="text/css">
  #horizontalTab_<?php echo $this->tab_id; ?> {
    background-color: <?php echo $this->tabs->headingBgColor; ?>;
    border-color: <?php echo $this->tabs->headingBgColor; ?>;
    width:<?php echo $this->tabs->width; ?>;
  }
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-nav .r-tabs-tab,
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-accordion-title .r-tabs-anchor{
    background-color: <?php echo $this->tabs->tabBgColor ?>;
  }
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-nav .r-tabs-anchor,
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs .r-tabs-accordion-title .r-tabs-anchor{
    color:<?php echo $this->tabs->tabTextBgColor ?>;
    font-size:<?php echo $this->tabs->tabTextFontSize ?>px;
  }
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-nav .r-tabs-state-active .r-tabs-anchor,
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-accordion-title.r-tabs-state-active .r-tabs-anchor{
    background-color: <?php echo $this->tabs->tabActiveBgColor?>;
    color:<?php echo $this->tabs->tabActiveTextColor ?>;
  }
  #horizontalTab_<?php echo $this->tab_id; ?> .r-tabs-panel{
    background-color: <?php echo $this->tabs->descriptionBgColor?>;
  }
</style>
  <div id="horizontalTab_<?php echo $this->tab_id ?>" class="sesbasic_clearfix sesbasic_bxs sesbd sespagebuilder_r_tabs">
    <ul>
      <?php foreach($tabs_count as $tab): ?>
      <?php $tabName = $languageColumn."tab".$tab."_name";
      $tabBody = $languageColumn."tab".$tab."_body";
      $tab_id = "#tab-" .$tab . "_$this->tab_id"; ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
      <li><a href="<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></a></li>
      <?php endif; ?>
      <?php endforeach; ?>
    </ul>
    <?php foreach($tabs_count as $tab): 
    $tabBody = $languageColumn."tab".$tab."_body";
    $tab_id = "tab-" .$tab . "_$this->tab_id"; 
    $tabName = $languageColumn."tab".$tab."_name";
    ?>
    <?php if(!empty($tabName) && !empty($this->tabs[$tabBody])): ?>
    <div id="<?php echo $tab_id ?>" class="sespagebuilder_page_content">
      <p><?php echo $this->tabs[$tabBody]; ?></p>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <script type="text/javascript">
    fixedPagesSES(document).ready(function() {
      fixedPagesSES("#horizontalTab_<?php echo $this->tab_id ?>").responsiveTabs({
        rotate: false,
        startCollapsed: 'accordion',
        collapsible: 'accordion',
       // setHash: true,
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
        fixedPagesSES("#horizontalTab_<?php echo $this->tab_id ?>").responsiveTabs('startRotation', 1000);
      });
      fixedPagesSES('#stop-rotation').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->tab_id ?>").responsiveTabs('stopRotation');
      });
      fixedPagesSES('#start-rotation').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->tab_id ?>").responsiveTabs('active');
      });
      fixedPagesSES('.select-tab').on('click', function() {
        fixedPagesSES("#horizontalTab_<?php echo $this->tab_id ?>").responsiveTabs('activate', fixedPagesSES(this).val());
      });

    });
  </script> 
<?php elseif($this->showViewType == 1): ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
	<style type="text/css">
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container{
      width:<?php echo $this->tabs->width; ?>;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container label{
      background-color: <?php echo $this->tabs->tabBgColor ?>;
      color:<?php echo $this->tabs->tabTextBgColor ?>;
      font-size:<?php echo $this->tabs->tabTextFontSize ?>px;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container input:checked + label{
      background-color: <?php echo $this->tabs->tabActiveBgColor?>;
      color:<?php echo $this->tabs->tabActiveTextColor ?>;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container article{
      background-color: <?php echo $this->tabs->descriptionBgColor?>;
    }
    .sespagebuilder_ac_container input:checked ~ article{
     height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;
    }
  </style>
  <div class="container_<?php echo $this->tab_id ?>">
    <section class="sespagebuilder_ac_container sesbasic_bxs sesbasic_clearfix sesbm">
      <?php $count = 1;?>
      <?php foreach($tabs_count as $tab): 
        $tabBody = $languageColumn."tab".$tab."_body";
        $tab_id = "tab-" .$tab . "_$this->tab_id"; 
        $tabName = $languageColumn."tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
        <div class=""sesbm sesbasic_clearfix">
          <input id="ac-<?php echo $tab_id ?>" name="accordion-1" type="radio" <?php if($count == 1):?> checked<?php endif;?> />
          <label for="ac-<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></label>
          <article class="ac-medium sesbasic_custom_scroll sespagebuilder_page_content">
            <p><?php echo $this->tabs[$tabBody]; ?></p>
          </article>
        </div>
      <?php endif; ?>
      <?php $count++;?>
      <?php endforeach; ?>
    </section>
  </div>
<?php elseif($this->showViewType == 2): ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
	<style type="text/css">
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container{
      width:<?php echo $this->tabs->width; ?>;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container label{
      background-color: <?php echo $this->tabs->tabBgColor ?>;
      color:<?php echo $this->tabs->tabTextBgColor ?>;
      font-size:<?php echo $this->tabs->tabTextFontSize ?>px;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container input:checked + label{
      background-color: <?php echo $this->tabs->tabActiveBgColor?>;
      color:<?php echo $this->tabs->tabActiveTextColor ?>;
    }
    .container_<?php echo $this->tab_id ?> .sespagebuilder_ac_container article{
      background-color: <?php echo $this->tabs->descriptionBgColor?>;
    }
  </style>
  <div class="container_<?php echo $this->tab_id ?>">
    <section class="sespagebuilder_ac_container sesbasic_bxs sesbasic_clearfix sesbm">
      <?php foreach($tabs_count as $tab): 
        $tabBody = $languageColumn."tab".$tab."_body";
        $tab_id = "tab-" .$tab . "_$this->tab_id"; 
        $tabName = $languageColumn."tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
      <div class="sesbm sesbasic_clearfix">
        <input id="ac-<?php echo $tab_id ?>" name="accordion-1" type="checkbox" />
        <label for="ac-<?php echo $tab_id ?>"><?php echo $this->translate($this->tabs[$tabName]); ?></label>
        <article class="ac-medium sesbasic_custom_scroll sespagebuilder_page_content">
          <p><?php echo $this->tabs[$tabBody]; ?></p>
        </article>
      </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </section>
  </div>
<?php elseif($this->showViewType == 3): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/tabModule.css'); ?>
  <script type="text/javascript">
    $(document).ready(function() {
      tabModule.init();
    });
  </script>
<style type="text/css">
  .container_<?php echo $this->tab_id ?> .ac-container{
    width:<?php echo $this->tabs->width; ?>;
  }
  .demo_<?php echo $this->tab_id ?> .tab-vert .tab-legend > li{
    background-color: <?php echo $this->tabs->tabBgColor ?>;
    border-color: <?php echo $this->tabs->headingBgColor; ?>;
    color:<?php echo $this->tabs->tabTextBgColor ?>;
    font-size:<?php echo $this->tabs->tabTextFontSize ?>px;
  }
  .demo_<?php echo $this->tab_id ?> .tab.tab-vert .tab-legend .active{
    background-color: <?php echo $this->tabs->tabActiveBgColor?>;
    color:<?php echo $this->tabs->tabActiveTextColor ?>;
  }
  .demo_<?php echo $this->tab_id ?> .tab .tab-content > li h4{
    border-color: <?php echo $this->tabs->headingBgColor; ?>;
    background-color: <?php echo $this->tabs->descriptionBgColor?>;
  }
</style>

  <div class="demo_<?php echo $this->tab_id ?>">
    <div class="tab tab-vert">
      <ul class="tab-legend">
      <?php foreach($tabs_count as $tab): 
      $tabBody = $languageColumn."tab".$tab."_body";
      $tab_id = "tab-" .$tab . "_$this->tab_id"; 
      $tabName = $languageColumn."tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
        <li class=""><?php echo $this->translate($this->tabs[$tabName]); ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
      </ul>
      <ul class="tab-content">
      <?php foreach($tabs_count as $tab): 
      $tabBody = $languageColumn."tab".$tab."_body";
      $tab_id = "tab-" .$tab . "_$this->tab_id"; 
      $tabName = $languageColumn."tab".$tab."_name";    
      ?>
      <?php if(!empty($this->tabs[$tabName]) && !empty($this->tabs[$tabBody])): ?>
        <li><h4><?php echo $this->tabs[$tabBody]; ?></h4></li>
        <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
<?php endif; ?>