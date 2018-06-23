<script>
    function editEquipInfo()
    {
        $('#editEqInfo').submit();
    }
    function editEquipSkill()
    {
        $('#editEquipSkill').submit();
    }
    function createStarStad(type)
    {
        $('#ch_star_type').val(type);
        $('#starStatDialog').modal();
    }
    function createRune()
    {
        $('#runeDialog').modal();
    }
    function editRuneDialog(runeInfo)
    {
        var rInfo = JSON.parse(runeInfo);
        $('#edit_rune_id').val(rInfo.RuneID);
        $('#edit_rune_quantity').val(rInfo.Quantity);
        $('#edit_rune_eq_no').val(rInfo.no);
        $('#editRuneDialog').modal();
    }
    function editStatsDialog(type, stInfo, cid)
    {
        var statInfo = JSON.parse(stInfo);
        $('#ch_edit_star_hp').val(statInfo.HP);
        $('#ch_edit_star_damage').val(statInfo.Damage);
        $('#ch_edit_star_power').val(statInfo.Power);
        $('#ch_edit_star_armor').val(statInfo.Armor);
        $('#ch_edit_star_speed').val(statInfo.Speed);
        $('#ch_edit_star_fire').val(statInfo.ResistFire);
        $('#ch_edit_star_water').val(statInfo.ResistWater);
        $('#ch_edit_star_light').val(statInfo.ResistLight);
        $('#ch_edit_star_dark').val(statInfo.ResistDark);
        $('#ch_edit_star_earth').val(statInfo.ResistEarth);
        $('#ch_edit_star_sid').val(statInfo.no);
        $('#ch_edit_star_id').val(cid);
        $('#ch_edit_star_type').val(type);
        $('#editStarStatDialog').modal();
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#summary" data-toggle="tab">Summary</a></li>
                <li class=""><a href="#stats" data-toggle="tab">Stats Infos</a></li>
                <li class=""><a href="#skill" data-toggle="tab">Skills</a></li>
                <li class=""><a href="#rune" data-toggle="tab">Rune Requirements</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="summary">
                    <form id='editEqInfo' name='editEqInfo' method='POST' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditEquipInfo'; ?>'>
                        <input type='hidden' name="eqId" value='<?php echo $eqInfo->EquipmentStateID; ?>'/>
                        <div class="row" style="margin-left:10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Name</label>
                                        <input type='text' name="eqName" class='form-control' value='<?php echo $eqInfo->Name; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Cost</label>
                                        <input type='text' name="eqCost" class='form-control' value='<?php echo $eqInfo->Cost; ?>'/>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;margin-right: 10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        <textarea class='form-control' name="eqDesc"><?php echo $eqInfo->Description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;margin-right: 10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Skill Description</label>
                                        <textarea class='form-control' name="eqSkillDesc"><?php echo $eqInfo->SkillDescription; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left: -5px">
                            <div class="col-md-2" >
                                <button class="btn btn-block btn-success" onclick='editEquipInfo()'>Update</button>
                            </div>
                            <div class="col-md-2" >
                                <a href='<?php echo base_url() . "index.php/AdminController/serverDataPage"; ?>' class="btn btn-block btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="stats">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <button class="btn btn-block btn-success" onclick='createStarStad(1)'>Add StarStat</button>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Hp</th>
                                <th>Damage</th>
                                <th>Power</th>
                                <th>Armor</th>
                                <th>Speed</th>
                                <th>Resist Fire</th>
                                <th>Resist Water</th>
                                <th>Resist Earth</th>
                                <th>Resist Light</th>
                                <th>Resist Dark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($statInfos as $stInfo) {
                                $i++; ?>
                                <tr>
                                    <td>
                                        <?php
                                        if ($stInfo['type'] == 0) {
                                            echo "BaseStats";
                                        } elseif ($stInfo['type'] == 1) {
                                            echo "BaseStatsGrow";
                                        } else {
                                            echo "StarStats";
                                        } ?>
                                    </td>
                                    <td><?php echo $stInfo['data']->HP; ?></td>
                                    <td><?php echo $stInfo['data']->Damage; ?></td>
                                    <td><?php echo $stInfo['data']->Power; ?></td>
                                    <td><?php echo $stInfo['data']->Armor; ?></td>
                                    <td><?php echo $stInfo['data']->Speed; ?></td>
                                    <td><?php echo $stInfo['data']->ResistFire; ?></td>
                                    <td><?php echo $stInfo['data']->ResistWater; ?></td>
                                    <td><?php echo $stInfo['data']->ResistEarth; ?></td>
                                    <td><?php echo $stInfo['data']->ResistLight; ?></td>
                                    <td><?php echo $stInfo['data']->ResistDark; ?></td>
                                    <td>
                                        <a href='#' onclick="editStatsDialog('<?php echo $stInfo['type']; ?>', '<?php echo htmlspecialchars(json_encode($stInfo['data'])); ?>', '<?php echo $eqInfo->EquipmentStateID; ?>')">Edit</a>&nbsp;&nbsp;&nbsp;
                                        <?php
                                        if ($stInfo['type'] == 2) {
                                            ?>

                                            <a href='<?php echo base_url() . "index.php/ServerDataController/actionDeleteStats/" . $stInfo['data']->no; ?>'>Delete</a>&nbsp;&nbsp;&nbsp;
                                            <?php
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="skill">
                    <form id='editEquipSkill' name='editEquipSkill' method='POST' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditEquipSkill'; ?>'>
                        <input type='hidden' name="eqIdSkill" value='<?php echo $eqInfo->EquipmentStateID; ?>'/>
                        <div class="row" style="margin-left:10px;margin-right: 10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Skill</label>
                                        <textarea class='form-control' name="eqSkill"><?php echo $eqInfo->Skill; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left: -5px">
                            <div class="col-md-2" >
                                <button class="btn btn-block btn-success" onclick='editEquipSkill()'>Update</button>
                            </div>
                            <div class="col-md-2" >
                                <a href='<?php echo base_url() . "index.php/AdminController/serverDataPage"; ?>' class="btn btn-block btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="rune">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <button class="btn btn-block btn-success" onclick='createRune()'>Add Rune</button>
                        </div>
                    </div>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Rune ID</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($runeInfos as $runeInfo) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $runeInfo->RuneID; ?></td>
                                    <td><?php echo $runeInfo->Quantity; ?></td>
                                    <td>
                                        <a href='#' onclick="editRuneDialog('<?php echo htmlspecialchars(json_encode($runeInfo)); ?>')">Edit</a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . "index.php/ServerDataController/actionDeleteRune/" . $runeInfo->RuneID; ?>'>Delete</a>&nbsp;&nbsp;&nbsp;
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



<div class="modal fade" tabindex="-1" role="dialog" id='editStarStatDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit a Starstat</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditStarstats'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Hp</label>
                    <input class='form-control' type='text' name='ch_edit_star_hp' id='ch_edit_star_hp' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Damage</label>
                    <input class='form-control' type='text' name='ch_edit_star_damage' id='ch_edit_star_damage' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Power</label>
                    <input class='form-control' type='text' name='ch_edit_star_power' id='ch_edit_star_power' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Armor</label>
                    <input class='form-control' type='text' name='ch_edit_star_armor' id='ch_edit_star_armor' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Speed</label>
                    <input class='form-control' type='text' name='ch_edit_star_speed' id='ch_edit_star_speed' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Fire</label>
                    <input class='form-control' type='text' name='ch_edit_star_fire' id='ch_edit_star_fire' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Water</label>
                    <input class='form-control' type='text' name='ch_edit_star_water' id='ch_edit_star_water' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Earth</label>
                    <input class='form-control' type='text' name='ch_edit_star_earth' id='ch_edit_star_earth' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Light</label>
                    <input class='form-control' type='text' name='ch_edit_star_light' id='ch_edit_star_light' placeholder='Value' value=''/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Dark</label>
                    <input class='form-control' type='text' name='ch_edit_star_dark' id='ch_edit_star_dark' placeholder='Value' value=''/></a>

                    <input type='hidden' name='ch_edit_star_id' id='ch_edit_star_id' value=''/></a>
                    <input type='hidden' name='ch_edit_star_sid' id='ch_edit_star_sid' value=''/></a>
                    <input type='hidden' name='ch_edit_star_type' id='ch_edit_star_type' value=''/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='starStatDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create a Starstat</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionAddStarstat'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Hp</label>
                    <input class='form-control' type='text' name='ch_star_hp' id='ch_star_hp' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Damage</label>
                    <input class='form-control' type='text' name='ch_star_damage' id='ch_star_damage' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Power</label>
                    <input class='form-control' type='text' name='ch_star_power' id='ch_star_value' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Armor</label>
                    <input class='form-control' type='text' name='ch_star_armor' id='ch_star_armor' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Speed</label>
                    <input class='form-control' type='text' name='ch_star_speed' id='ch_star_speed' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Fire</label>
                    <input class='form-control' type='text' name='ch_star_fire' id='ch_star_fire' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Water</label>
                    <input class='form-control' type='text' name='ch_star_water' id='ch_star_water' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Earth</label>
                    <input class='form-control' type='text' name='ch_star_earth' id='ch_star_earth' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Light</label>
                    <input class='form-control' type='text' name='ch_star_light' id='ch_star_light' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Resist Dark</label>
                    <input class='form-control' type='text' name='ch_star_dark' id='ch_star_dark' placeholder='Value'/></a>

                    <input type='hidden' name='ch_star_id' id='ch_star_id' value='<?php echo $eqInfo->EquipmentStateID; ?>'/></a>
                    <input type='hidden' name='ch_star_type' id='ch_star_type' value='1'/>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" tabindex="-1" role="dialog" id='editRuneDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit a Rune</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditRune'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Rune ID</label>
                    <input class='form-control' type='text' name='edit_rune_id' id='edit_rune_id' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Quantity</label>
                    <input class='form-control' type='number' name='edit_rune_quantity' id='edit_rune_quantity' placeholder='Value'/></a>

                    <input type='hidden' name='edit_rune_eq_id' id='edit_rune_eq_id' value='<?php echo $eqInfo->EquipmentStateID; ?>'/></a>
                    <input type='hidden' name='edit_rune_eq_no' id='edit_rune_eq_no' value=''/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id='runeDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create a Rune</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionAddRune'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Rune ID</label>
                    <input class='form-control' type='text' name='rune_id' id='rune_id' placeholder='Value'/></a>
                    <br>
                    <label for="exampleInputEmail1">Quantity</label>
                    <input class='form-control' type='number' name='rune_quantity' id='rune_quantity' placeholder='Value'/></a>

                    <input type='hidden' name='rune_eq_id' id='rune_eq_id' value='<?php echo $eqInfo->EquipmentStateID; ?>'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
