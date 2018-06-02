<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#goods" data-toggle="tab"><?php echo lang("text_61"); ?></a></li>
                <li><a href="#users" data-toggle="tab"><?php echo lang("text_62"); ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="goods">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang("text_12"); ?></th>
                                <th><?php echo lang("text_20"); ?></th>
                                <th><?php echo lang("text_13"); ?></th>
                                <th><?php echo lang("text_14"); ?></th>
                                <th><?php echo lang("text_15"); ?></th>
                                <th><?php echo lang("text_16"); ?></th>
                                <th><?php echo lang("text_63"); ?></th>
                                <th><?php echo lang("text_64"); ?></th>
                                <th><?php echo lang("text_17"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($goods_history as $good) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $good->good_id; ?></td>
                                    <td><?php echo $good->name; ?></td>
                                    <td><?php echo $good->price; ?></td>
                                    <td><?php echo $good->amount; ?></td>
                                    <td><?php echo $good->remain_amount; ?></td>
                                    <td><?php echo $good->sell; ?></td>
                                    <td><?php echo $good->sell_amount; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . ADMIN_PAGE_VIEW_GOODCHART . "/" . $good->no; ?>'><?php echo lang("text_65"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="users">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang("text_12"); ?></th>
                                <th><?php echo lang("text_13"); ?></th>
                                <th><?php echo lang("text_66"); ?></th>
                                <th><?php echo lang("text_67"); ?></th>
                                <th><?php echo lang("text_68"); ?></th>
                                <th><?php echo lang("text_69"); ?></th>
                                <th><?php echo lang("text_17"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($users_history as $user) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $user->name; ?></td>
                                    <td><?php echo $user->funds; ?></td>
                                    <td><?php echo $user->total_funds; ?></td>
                                    <td>
                                        <?php
                                        $lv = "None";
                                foreach ($levels as $level) {
                                    if ($level->price < $user->total_funds) {
                                        $lv = $level->name;
                                    }
                                }
                                echo $lv; ?>
                                    </td>
                                    <td>
                                        <?php echo $user->total_funds - $user->funds; ?>
                                    </td>
                                    <td>
                                        <a href='<?php echo base_url() . ADMIN_PAGE_VIEW_USERHISTORY . "/" . $user->no; ?>'><?php echo lang("text_65"); ?></a>&nbsp;&nbsp;&nbsp;
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
