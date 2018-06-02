<script>
    function createGahsapon()
    {
        $('#gashaponDialog').modal();
    }
    function editGashapon(gashaJson)
    {
        var gInfo = JSON.parse(gashaJson);
        $('#editGashaId').val(gInfo.no);
        $('#editGashaName').val(gInfo.name);
        $('#editGashaAmount').val(gInfo.amount);
        $('#editGashaCost').val(gInfo.cost);
        $('#editGashaMin').val(gInfo.range_min);
        $('#editGashaMax').val(gInfo.range_max);
        $('#editGashaType').val(gInfo.type);
        
        $('#editGashaponDialog').modal();
    }
    
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#gashapon" data-toggle="tab">Gashapons</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="gashapon">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createGahsapon()'>Add Gashapon</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Cost</th>
                                <th>Range</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($gashapons as $gashapon) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $gashapon->name; ?></td>
                                    <td><?php echo $gashapon->amount; ?></td>
                                    <td><?php echo $gashapon->cost; ?></td>
                                    <td><?php echo $gashapon->range_min." ~ ".$gashapon->range_max; ?></td>
                                    <td>
                                        <?php
                                        if ($gashapon->type == 0)
                                        {
                                            echo "Basic";
                                        }
                                        else 
                                        {
                                            echo "Premium";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href='#' onclick="editGashapon('<?php echo htmlspecialchars(json_encode($gashapon)); ?>')"><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/GashaController/actionDeleteGashapon/' . $gashapon->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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
<div class="modal fade" tabindex="-1" role="dialog" id='gashaponDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Gashapon</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/GashaController/actionCreateGashapon'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='gashaName' id='gashaName' value='' placeholder='Name'/>
                    <br>
                    <label for="exampleInputEmail1">Amount</label>
                    <input class='form-control' name='gashaAmount' id='gashaAmount' value='' type='number' placeholder='Amount'/>
                    <br>
                    <label for="exampleInputEmail1">Cost</label>
                    <input class='form-control' name='gashaCost' id='gashaCost' value='' type='number' placeholder='Cost'/>
                    <br>
                    <label for="exampleInputEmail1">Min</label>
                    <input class='form-control' name='gashaMin' id='gashaMin' value='' type='number' placeholder='Min'/>
                    <br>
                    <label for="exampleInputEmail1">Max</label>
                    <input class='form-control' name='gashaMax' id='gashaMax' value='' type='number' placeholder='Max'/>
                    <br>
                    <label for="exampleInputEmail1">Type</label>
                    <select class='form-control' name='gashaType' id='gashaType'>
                        <option value='0'>Basic Gashapon</option>
                        <option value='1'>Premium Gashapon</option>
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


<div class="modal fade" tabindex="-1" role="dialog" id='editGashaponDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create an Gashapon</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/GashaController/actionEditGashapon'; ?>'>
                    <input type='hidden' name='editGahsaId' id='editGashaId'/>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Name</label>
                    <input class='form-control' name='editGashaName' id='editGashaName' value='' placeholder='Name'/></a>
                    <br>
                    <label for="exampleInputEmail1">Amount</label>
                    <input class='form-control' name='editGashaAmount' id='editGashaAmount' value='' type='number' placeholder='Amount'/></a>
                    <br>
                    <label for="exampleInputEmail1">Cost</label>
                    <input class='form-control' name='editGashaCost' id='editGashaCost' value='' type='number' placeholder='Cost'/></a>
                    <br>
                    <label for="exampleInputEmail1">Min</label>
                    <input class='form-control' name='editGashaMin' id='editGashaMin' value='' type='number' placeholder='Min'/></a>
                    <br>
                    <label for="exampleInputEmail1">Max</label>
                    <input class='form-control' name='editGashaMax' id='editGashaMax' value='' type='number' placeholder='Max'/></a>
                    <br>
                    <label for="exampleInputEmail1">Type</label>
                    <select class='form-control' name='editGashaType' id='editGashaType'>
                        <option value='0'>Basic Gashapon</option>
                        <option value='1'>Premium Gashapon</option>
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