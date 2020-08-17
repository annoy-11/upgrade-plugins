<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: petition-decisionmaker.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if (!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
}
?>
<style>
    .error {
        color: #FF0000;
    }
</style>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<button id="add_new_decision_maker"><?php  echo $this->translate('Add New Decision Maker'); ?></button>
<br />
<br />
<div class='admin_search sesbasic_search_form'>
  <?php //echo $this->formFilter->render($this); ?>
</div>


<script type="text/javascript">

    function multiDelete() {
        return confirm("<?php echo $this->translate('Are you sure you want to delete the selected petition entries?');?>");
    }

    function selectAll() {
        var i;
        var multidelete_form = $('multidelete_form');
        var inputs = multidelete_form.elements;
        for (i = 1; i < inputs.length; i++) {
            if (!inputs[i].disabled) {
                inputs[i].checked = inputs[0].checked;
            }
        }
    }
</script>
<?php if (count($this->paginator)): ?>
    <form id='multidelete_form' method="post" action="<?php echo $this->url(); ?>" onSubmit="return multiDelete()">
      <div class="epetition_dashboard_table">
        <table class='admin_table'>
            <thead>
            <tr>
                <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox'/></th>
                <th><?php echo $this->translate("S.No."); ?></th>
                <th><?php echo $this->translate("Name"); ?></th>
                <th><?php echo $this->translate("Date"); ?></th>
                <th align="center"><?php echo $this->translate("Status"); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $c = 0;
            foreach ($this->paginator as $item): ?>
                <tr id="admindecisionmaker<?php echo $item->decisionmaker_id; ?>">
                  <?php $user = Engine_Api::_()->getItem('user', $item->user_id); ?>
                    <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->decisionmaker_id; ?>'
                               value="<?php echo $item->decisionmaker_id; ?>"/></td>
                    <td><?php echo ++$c; ?></td>
                    <td><?php echo "<a href=" . $user->getHref() . ">" . $this->translate($user->getTitle()) . "</a>"; ?></td>
                    <td><?php echo date("d/m/Y h:i A", strtotime($item->created_date)); ?></td>
                    <td align="center" id="d<?php echo $item->decisionmaker_id; ?>"><?php if ($item->enabled) {
                        echo "<a onclick='changeenabled(" . $item->decisionmaker_id . ",0)' href='JavaScript:void(0)'><img title='Enable' src='" . $baseURL . "application/modules/Sesbasic/externals/images/icons/check.png'/></a>";
                      } else {
                        echo "<a onclick='changeenabled(" . $item->decisionmaker_id . ",1)' href='JavaScript:void(0)'><img title='Disable' src='" . $baseURL . "application/modules/Sesbasic/externals/images/icons/error.png'/></a>";
                      } ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
      </div>

        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
    </form>

    <div>
      <?php echo $this->paginationControl($this->paginator); ?>
    </div>

<?php else: ?>
    <div class="tip">
    <span>
      <?php echo $this->translate("There are no signaturere entries for this petition.") ?>
    </span>
    </div>
<?php endif; ?>
</div>
<script type="application/javascript">
    // for chagne status by ajax
    function changeenabled(id, type) {
        if (confirm("Are you sure ?") && parseInt(id) > 0 && parseInt(type) == 1 || parseInt(type) == 0) {
            sesJqueryObject.ajax({
                url: "<?php echo $this->url(array('action' => 'change-enable-deision-maker'));?>",
                type: "POST",
                data: {id: id, type: type},
                success: function (html) {
                    if (html) {
                        sesJqueryObject("#d" + id).empty();
                        var appendtype = 1;
                        var image = '<?php echo $baseURL . "application/modules/Sesbasic/externals/images/icons/error.png"; ?>';
                        var title="Disable";
                        if (parseInt(type) == 1) {
                            appendtype = 0;
                            image = '<?php echo $baseURL . "application/modules/Sesbasic/externals/images/icons/check.png"; ?>';
                            var title="Enable";
                        }
                        sesJqueryObject("#d" + id).empty();
                        sesJqueryObject("#d" + id).append('<a href="JavaScript:void(0)" onclick="changeenabled(' + id + ',' + appendtype + ')"><img title="'+title+'" src="' + image + '"><a>');
                    }
                }
            });
        }
    }

    function redirectfordelete(url, id) {
        if (confirm('Are you sure to delete?')) {
            sesJqueryObject.ajax({
                url: url,
                type: "POST",
                data: {id: id},
                dataType: "json",
                success: function (html) {
                    if (html['status']) {
                        sesJqueryObject("#signature" + id).remove();
                        alert(html['msg']);
                    } else {
                        alert(html['msg']);
                    }
                }
            });
        }
    }

    sesJqueryObject("#add_new_decision_maker").click(function () {
        var url = "<?php echo $this->url(array('module' => 'epetition', 'controller' => 'dashboard', 'action' => 'add-decision-maker','epetition_id'=>$this->slug),'epetition_dashboard',true); ?>";
        opensmoothboxurl(url);
    });
</script>