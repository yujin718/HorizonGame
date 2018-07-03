<script>
    function createGahsapon()
    {
        $('#gashaponDialog').modal();
    }
    function editRequirement(gashaJson)
    {
        var gInfo = JSON.parse(gashaJson);
        $('#gashaReqKey').val(gInfo.GashaponID);
        $('#gashaReqId').val(gInfo.GashaponID);
        $('#gashaReqActive').val(gInfo.IsActive);
        $('#gashaReqCurrency').val(gInfo.cid);
        $('#gashaReqQuantity').val(gInfo.Quantity);
        $('#gashaReqGuarentee').val(gInfo.GuaranteedTier);
        $('#gashaReqRoll').val(gInfo.TotalRoll);
        $('#gashaReqCooldown').val(gInfo.Cooldown);
        $('#gashaReqTable').val(gInfo.TableReference);

        $('#editRequirementDialog').modal();
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#req" data-toggle="tab">Requirements</a></li>
                <li><a href="#basic" data-toggle="tab">Basic</a></li>
                <li><a href="#character" data-toggle="tab">Character</a></li>
                <li><a href="#equipment" data-toggle="tab">Equipment</a></li>
                <li><a href="#premium" data-toggle="tab">Premium</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="req">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>GashaponID</th>
                                <th>IsActive</th>
                                <th>Currency</th>
                                <th>Quantity</th>
                                <th>GuaranteedTier</th>
                                <th>TotalRoll</th>
                                <th>Cooldown</th>
                                <th>TableReference</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($reqs as $req) {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $req->GashaponID; ?></td>
                                    <td><?php echo $req->IsActive; ?></td>
                                    <td>
                                      <?php
                                      foreach($currencys as $currency)
                                      {
                                        if ($currency->no == $req->cid)
                                            echo $currency->name;
                                      }
                                      ?>
                                    </td>
                                    <td><?php echo $req->Quantity; ?></td>
                                    <td><?php echo $req->GuaranteedTier; ?></td>
                                    <td><?php echo $req->TotalRoll; ?></td>
                                    <td><?php echo $req->Cooldown; ?></td>
                                    <td><?php echo $req->TableReference; ?></td>
                                    <td>
                                        <a href='#' onclick="editRequirement('<?php echo htmlspecialchars(json_encode($req)); ?>')"><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="basic">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='<?php echo base_url();?>index.php/GashaController/addGashapon/basic' class="btn btn-block btn-success">Add Gashapon</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ItemID</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Tier</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($basics as $basic) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $basic->ItemID; ?></td>
                                    <td><?php echo $basic->Type; ?></td>
                                    <td><?php echo $basic->Quantity; ?></td>
                                    <td><?php echo $basic->Tier; ?></td>
                                    <td><?php echo $basic->Weight; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/GashaController/editGashapon/basic/' . $basic->no; ?>'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/GashaController/actionDeleteGashapon/basic/' . $basic->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="character">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='<?php echo base_url();?>index.php/GashaController/addGashapon/character' class="btn btn-block btn-success">Add Gashapon</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ItemID</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Tier</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($characters as $character) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $character->ItemID; ?></td>
                                    <td><?php echo $character->Type; ?></td>
                                    <td><?php echo $character->Quantity; ?></td>
                                    <td><?php echo $character->Tier; ?></td>
                                    <td><?php echo $character->Weight; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/GashaController/editGashapon/character/' . $character->no; ?>'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/GashaController/actionDeleteGashapon/character/' . $character->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="equipment">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='<?php echo base_url();?>index.php/GashaController/addGashapon/equipment' class="btn btn-block btn-success">Add Gashapon</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ItemID</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Tier</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($equips as $equip) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $equip->ItemID; ?></td>
                                    <td><?php echo $equip->Type; ?></td>
                                    <td><?php echo $equip->Quantity; ?></td>
                                    <td><?php echo $equip->Tier; ?></td>
                                    <td><?php echo $equip->Weight; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/GashaController/editGashapon/equipment/' . $equip->no; ?>'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/GashaController/actionDeleteGashapon/equipment/' . $equip->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="premium">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='<?php echo base_url();?>index.php/GashaController/addGashapon/premium' class="btn btn-block btn-success">Add Gashapon</a>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ItemID</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Tier</th>
                                <th>Weight</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($premiums as $premium) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $premium->ItemID; ?></td>
                                    <td><?php echo $premium->Type; ?></td>
                                    <td><?php echo $premium->Quantity; ?></td>
                                    <td><?php echo $premium->Tier; ?></td>
                                    <td><?php echo $premium->Weight; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/GashaController/editGashapon/premium/' . $premium->no; ?>'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/GashaController/actionDeleteGashapon/premium/' . $premium->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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
<div class="modal fade" tabindex="-1" role="dialog" id='editRequirementDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit an Requirement</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/GashaController/actionEditRequirement'; ?>'>
                <div class="modal-body">
                    <input class='form-control' name='gashaReqKey' id='gashaReqKey' type='hidden'/>
                    <label for="exampleInputEmail1">GashaponID</label>
                    <input disabled class='form-control' name='gashaReqId' id='gashaReqId' value='' placeholder='ID'/>
                    <br>
                    <label for="exampleInputEmail1">IsActive</label>
                    <select class='form-control' name='gashaReqActive' id='gashaReqActive'>
                        <option value='0'>InActive</option>
                        <option value='1'>Active</option>
                    </select>
                    <br>
                    <label for="exampleInputEmail1">Currency</label>
                    <select class='form-control' name='gashaReqCurrency' id='gashaReqCurrency'>
                        <?php
                        foreach($currencys as $currency)
                        {
                          ?>
                          <option value='<?php echo $currency->no;?>'><?php echo $currency->name;?></option>
                          <?php
                        }
                         ?>
                    </select>
                    <br>
                    <label for="exampleInputEmail1">Quantity</label>
                    <input class='form-control' name='gashaReqQuantity' id='gashaReqQuantity' value='' type='number' placeholder='Quantity'/>
                    <br>
                    <label for="exampleInputEmail1">GuaranteedTier</label>
                    <input class='form-control' name='gashaReqGuarentee' id='gashaReqGuarentee' value='' type='number' placeholder='GuaranteedTier'/>
                    <br>
                    <label for="exampleInputEmail1">TotalRoll</label>
                    <input class='form-control' name='gashaReqRoll' id='gashaReqRoll' value='' type='number' placeholder='TotalRoll'/>
                    <br>
                    <label for="exampleInputEmail1">Cooldown</label>
                    <input class='form-control' name='gashaReqCooldown' id='gashaReqCooldown' value='' type='number' placeholder='Cooldown'/>
                    <br>
                    <label for="exampleInputEmail1">Table</label>
                    <input class='form-control' name='gashaReqTable' id='gashaReqTable' value='' type='text' placeholder='Table Name'/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='gashaponDialog'>
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
