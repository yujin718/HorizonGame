<script>
    function changePassword()
    {
        var oldpw = document.getElementById('old_pw');
        var newpw = document.getElementById('new_pw');
        var formEle = document.getElementById('changePassword');
        if ((oldpw.value == '') || (newpw.val == ''))
        {
            swal('Please fill input', '', 'error');
            return;
        }
        formEle.submit();
    }
    function createInventoryDialog()
    {
        $('#inventoryDialog').modal();
    }
    function editInventoryDialog(no, name)
    {
        $('#edit_inventoryName').val(name);
        $('#iid').val(no);
        $('#inventoryEditDialog').modal();
    }
    
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inventory" data-toggle="tab">Inventory</a></li>
                <li><a href="#password" data-toggle="tab">Password Setting</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="inventory">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createInventoryDialog()'>Add Inventory</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($inventorys as $inventory) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $inventory->name; ?></td>
                                    <td>
                                        <a href='#' onclick='editInventoryDialog("<?php echo $inventory->no; ?>", "<?php echo $inventory->name; ?>")'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/SettingController/actionDeleteInventory/' . $inventory->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="password">
                    <div class="row" style="margin-bottom: 10px">
                        <form role="form" method="post" enctype="multipart/form-data" id="changePassword" action='<?php echo base_url() . 'index.php/AdminController/changeAdminPassword'; ?>'>
                            <input type='hidden' name='adminId' value='<?php echo $this->session->adminId; ?>'>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row" style="margin-left: 0px;" >
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">Old Password</label>
                                            <input type="password" class="form-control" id="old_pw" name="old_pw" placeholder="">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1">New Password</label>
                                            <input type="password" class="form-control" id="new_pw" name="new_pw" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2" >
                                    <a href='#' class="btn btn-block btn-success" onclick='changePassword()'>Change Password</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id='inventoryDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Inventory</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/SettingController/actionCreateInventory'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='inventoryName' id='inventoryName' value='' placeholder='Name'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_77"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='inventoryEditDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Inventory</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/SettingController/actionEditInventory'; ?>'>
                <div class="modal-body">
                    <input type='hidden' name='iid' id='iid' value='' />
                    <label for="exampleInputEmail1"><?php echo lang("text_13"); ?></label>
                    <input class='form-control' name='edit_inventoryName' id='edit_inventoryName' value='' placeholder='Name'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_27"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id='currencyDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Currency</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/SettingController/actionCreateCurrency'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='currencyName' id='currencyName' value='' placeholder='Name'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_77"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id='currencyEditDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Currency</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/SettingController/actionEditCurrency'; ?>'>
                <div class="modal-body">
                    <input type='hidden' name='cid' id='cid' value='' />
                    <label for="exampleInputEmail1"><?php echo lang("text_13"); ?></label>
                    <input class='form-control' name='edit_currencyName' id='edit_currencyName' value='' placeholder='Name'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_27"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
