<script>
    function createItem()
    {
        $('#createItem').modal();
    }
    function editItem(shopJson)
    {
        var gInfo = JSON.parse(shopJson);
        $('#editShopId').val(gInfo.no);
        $('#editShopName').val(gInfo.name);
        $('#editShopAmount').val(gInfo.amount);
        $('#editShopCost').val(gInfo.cost);
        $('#editShopCurrency').val(gInfo.currency);
        
        $('#editItemDialog').modal();
    }
    
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#shop" data-toggle="tab">Shop</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="shop">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createItem()'>Add Item</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Cost</th>
                                <th>Currency</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($shops as $shop) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $shop->name; ?></td>
                                    <td><?php echo $shop->amount; ?></td>
                                    <td><?php echo $shop->cost; ?></td>
                                    <td>
                                        <?php
                                        foreach($currencys as $cy)
                                        {
                                            if ($cy->no == $shop->currency)
                                            {
                                                echo $cy->name;
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href='#' onclick="editItem('<?php echo htmlspecialchars(json_encode($shop)); ?>')"><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/ShopController/actionDeleteShopItem/' . $shop->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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
<div class="modal fade" tabindex="-1" role="dialog" id='createItem'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Item</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ShopController/actionCreateShopItem'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='shopName' id='shopName' value='' placeholder='Name'/>
                    <br>
                    <label for="exampleInputEmail1">Amount</label>
                    <input class='form-control' name='shopAmount' id='shopAmount' value='' type='number' placeholder='Amount'/>
                    <br>
                    <label for="exampleInputEmail1">Cost</label>
                    <input class='form-control' name='shopCost' id='shopCost' value='' type='number' placeholder='Cost'/>
                    <br>
                    <label for="exampleInputEmail1">Currency</label>
                    <select class='form-control' name='shopCurrency' id='shopCurrency'>
                        <?php
                            foreach($currencys as $cy)
                            {
                                ?>
                                <option value='<?php echo $cy->no;?>'><?php echo $cy->name;?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_77"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='editItemDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Gashapon</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ShopController/actionEditShopItem'; ?>'>
                    <input type='hidden' name='editShopId' id='editShopId'/>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='editShopName' id='editShopName' value='' placeholder='Name'/></a>
                    <br>
                    <label for="exampleInputEmail1">Amount</label>
                    <input class='form-control' name='editShopAmount' id='editShopAmount' value='' type='number' placeholder='Amount'/></a>
                    <br>
                    <label for="exampleInputEmail1">Cost</label>
                    <input class='form-control' name='editShopCost' id='editShopCost' value='' type='number' placeholder='Cost'/></a>
                    <label for="exampleInputEmail1">Currency</label>
                    <select class='form-control' name='editShopCurrency' id='editShopCurrency'>
                        <?php
                            foreach($currencys as $cy)
                            {
                                ?>
                                <option value='<?php echo $cy->no;?>'><?php echo $cy->name;?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->