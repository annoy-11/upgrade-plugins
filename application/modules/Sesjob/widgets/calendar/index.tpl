<?php/** * SocialEngineSolutions * * @category   Application_Sesjob * @package    Sesjob * @copyright  Copyright 2019-2020 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */  ?>  <?php //$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/bootstrap.min.css'); ?>    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/calander.css'); ?>    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->    <!--[if lt IE 9]>        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>    <![endif]-->      <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/scripts/jquery-2.1.1.min.js'); ?><?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/scripts/bootstrap.min.js'); ?><?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/scripts/moment-with-locales.js'); ?><?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/scripts/bootstrap-datetimepicker.js'); ?><div class="sesbasic_bxs" style="overflow:hidden;">    <div class="form-group">        <div class="row">            <div class="col-md-8">                <div id="datetimepicker12"></div>            </div>        </div>    </div>    <script type="text/javascript">        calenderjs(function () {            calenderjs('#datetimepicker12').datetimepicker({								format: 'DD/MM/YYYY',                inline: true,							<?php if($this->jobdate){ ?>								defaultDate : '<?php echo date('m-d-Y',strtotime($this->jobdate)); ?>',						  <?php } ?>								maxDate: new Date(),                sideBySide: false,            }).on('dp.change', function(event){ 								window.location.href = '<?php echo $this->url(array("action"=>"browse"),"sesjob_general",true)."?date="; ?>'+event.date.format('YYYY-MM-DD');						});;        });    </script>    </div>