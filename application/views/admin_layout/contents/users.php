<script>
    function createAdminDialog()
    {
        $('#createAccountDialog').modal();
    }
    function changeStatus(id)
    {
        $('#disableDialog').modal();
        $('#userId').val(id);
    }
</script>
<div class="row">

    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#game_users" data-toggle="tab">Game Users</a></li>
                <?php
                if ($this->session->level == "0") {
                    ?>
                    <li><a href="#game_admins" data-toggle="tab">Admin Accounts</a></li>
                    <?php
                }
                ?>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="game_users">
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Points</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                foreach ($users as $user) {
                                    $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user->PlayerName; ?></td>
                                        <td><?php echo $user->Email; ?></td>
                                        <td>
                                            <?php
                                            if ($user->Type == 0) {
                                                echo "Email";
                                            } elseif ($user->type == 1) {
                                                echo "Facebook";
                                            } ?>
                                        </td>
                                        <td><?php echo $user->Points; ?></td>
                                        <td>
                                            <a href='<?php echo base_url() . "index.php/AdminController/userDetailPage/" . $user->PlayerID; ?>'>Details</a>&nbsp;&nbsp;&nbsp;
                                            <?php
                                            if ($user->Status == 0) {
                                                ?>
                                                <a href='<?php echo base_url() . "index.php/AdminController/actionSetUserPermission" . '/' . $user->PlayerID; ?>'>Set Enable</a>&nbsp;&nbsp;&nbsp;
                                                <?php
                                            } else {
                                                ?>
                                                <a href='#' onclick="changeStatus('<?php echo $user->PlayerID; ?>')">Set Disable</a>&nbsp;&nbsp;&nbsp;
                                                <?php
                                            } ?>
                                            <a href='<?php echo base_url() . "index.php/AdminController/actionDeleteUser/" . $user->PlayerID; ?>'>Delete</a>&nbsp;&nbsp;&nbsp;

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane" id="game_admins">
                    <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createAdminDialog()'>Create Admin Account</a>
                        </div>
                    </div>
                    <div class="box-body">
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
                                foreach ($admins as $admin) {
                                    $i++; ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $admin->user; ?></td>
                                        <td>
                                            <a href='<?php echo base_url() . "index.php/AdminController/actionDeleteAdmin/" . $admin->PlayerID; ?>'>Delete</a>&nbsp;&nbsp;&nbsp;

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='disableDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Disable Account</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionSetUserPermission'; ?>'>
                <div class="modal-body">
                    <input type="hidden" name='userId' id='userId' value=''/>
                    <label for="exampleInputEmail1">Duration</label>
                    <input class='form-control' type='number' name='durationDay' id='durationDay' value='0' placeholder='Duration with days'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Disable</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='createAccountDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create Admin Account</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionCreateAdmin'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">ID</label>
                    <input class='form-control' name='adminId' id='adminId' value='' placeholder='ID'/></a>
                    <br>
                    <label for="exampleInputEmail1">Password</label>
                    <input class='form-control' name='adminPassword' id='adminPassword' type='password' value='' placeholder='Password'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
