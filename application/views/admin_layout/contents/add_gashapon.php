<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#gashapon" data-toggle="tab">Gashapon</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="gashapon">
                    <form method='post' action='<?php echo base_url() . 'index.php/GashaController/actionCreateGashapon'; ?>'>
                        <div class="modal-body">
                            <input type='hidden' name='gashaIDType' id='gashaIDType' value='<?php echo $type;?>'/>
                            <label for="exampleInputEmail1">ItemID</label>
                            <select class='form-control' name='gashaItemID' id='gashaItemID'>
                                <?php
                                foreach($items as $item)
                                {
                                  if ($type == "basic")
                                  {
                                    ?>
                                        <option value='<?php echo $item->ItemID;?>'><?php echo $item->ItemID;?></option>
                                    <?php
                                  }
                                  else if ($type == "character")
                                  {
                                    ?>
                                        <option value='<?php echo $item->CharacterStatsID;?>'><?php echo $item->CharacterStatsID;?></option>
                                    <?php
                                  }
                                  else if ($type == "equipment")
                                  {
                                    ?>
                                        <option value='<?php echo $item->EquipmentStatsID;?>'><?php echo $item->EquipmentStatsID;?></option>
                                    <?php
                                  }
                                  else if ($type == "premium")
                                  {
                                    ?>
                                        <option value='<?php echo $item->ItemID;?>'><?php echo $item->ItemID;?></option>
                                    <?php
                                  }
                                }
                                ?>
                            </select>
                            <br>
                            <label for="exampleInputEmail1">Type</label>
                            <input class='form-control' name='gashaType' id='gashaType' value='' type='text' placeholder='Type'/>
                            <br>
                            <label for="exampleInputEmail1">Quantity</label>
                            <input class='form-control' name='gashaQuantity' id='gashaQuantity' value='' type='number' placeholder='Quantity'/>
                            <br>
                            <label for="exampleInputEmail1">Tier</label>
                            <input class='form-control' name='gashaTier' id='gashaTier' value='' type='number' placeholder='Tier'/>
                            <br>
                            <label for="exampleInputEmail1">Weight</label>
                            <input class='form-control' name='gashaWeight' id='gashaWeight' value='' type='number' placeholder='Weight'/>
                        </div>
                        <div class="modal-footer">
                            <a href='<?php echo base_url()."/index.php/AdminController/gashaponPage"?>' class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
