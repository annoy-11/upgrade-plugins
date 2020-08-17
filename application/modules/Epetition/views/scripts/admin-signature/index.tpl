<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH . '/application/modules/Epetition/views/scripts/dismiss_message.tpl'; ?>
<h3>Petition Signature</h3>
<div class='admin_search sesbasic_search_form'>
    <?php echo $this->formFilter->render($this); ?>
</div>


    <script type="text/javascript">

        function multiDelete()
        {
            return confirm("<?php echo $this->translate('Are you sure you want to delete the selected blog entries?');?>");
        }

        function selectAll()
        {
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



    <br />
    <br />

    <?php if( count($this->paginator) ): ?>
    <form id='multidelete_form' method="post" action="<?php echo $this->url();?>" onSubmit="return multiDelete()">
        <table class='admin_table' style="width: 100%">
            <thead>
            <tr>
                <th class='admin_table_short'><input onclick='selectAll();' type='checkbox' class='checkbox' /></th>
                <th><?php echo $this->translate("Name"); ?></th>
                <th><?php echo $this->translate("Petition Title"); ?></th>
                <th><?php echo $this->translate("Support Statement"); ?></th>
                <th><?php echo $this->translate("Date"); ?></th>
                <th><?php echo $this->translate("Action"); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $c=0; foreach ($this->paginator as $item): ?>
            <tr id="signature<?php echo $item->signature_id; ?>">
                <?php $user = Engine_Api::_()->getItem('user', $item->owner_id); ?>
                <td><input type='checkbox' class='checkbox' name='delete_<?php echo $item->signature_id; ?>' value="<?php echo $item->signature_id; ?>" /></td>
                <td><?php echo isset($item->owner_id) && $item->owner_id>0 ?  "<a href=".$user->getHref().">".$this->translate($user->getTitle())."</a>" : $item->first_name." ".$item->last_name; ?></td>
               <td><?php echo $this->translate(Engine_Api::_()->getDbtable('epetitions', 'epetition')->getPetitionTitle($item->epetition_id)); ?></td>
                <td><?php  echo  $this->translate($item->support_statement); ?></td>
                <td><?php echo $this->translate(date("d/m/Y h:i A",strtotime($item->creation_date)));  ?></td>
                <td>
                    <a class='smoothbox' href='<?php echo $this->url(array('action' => 'view-dashboard-signature', 'id' => $item->signature_id));?>'>
                        <?php echo $this->translate("view"); ?>
                    </a>
                    |
                    <a href='javaScript:void(0);' onclick='redirectfordelete("<?php echo $this->url(array('action' => 'delete-dashboard-signature'));?>","<?php echo $item->signature_id;?>")'>
                        <?php echo $this->translate("Delete"); ?>
                    </a>
                </td>

            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <br />

        <div class='buttons'>
            <button type='submit'><?php echo $this->translate("Delete Selected") ?></button>
        </div>
    </form>

    <br/>
    <div>
        <?php echo $this->paginationControl($this->paginator); ?>
    </div>

    <?php else: ?>
    <div class="tip">
    <span>
      <?php echo $this->translate("There are no signaturere entries from this user.") ?>
    </span>
    </div>
    <?php endif; ?>
    <script>
        function redirectfordelete(url,id)
        {
            if(confirm('Are you sure to delete?'))
            {
                sesJqueryObject.ajax({
                    url: url,
                    type: "POST",
                    data: {id : id},
                    dataType: "json",
                    success: function(html) {
                        if (html['status']) {
                            sesJqueryObject("#signature"+id).remove();
                            alert(html['msg']);
                        }
                        else
                        {
                            alert(html['msg']);
                        }
                    }
                });
            }
        }
    </script>
