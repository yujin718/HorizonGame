<script>
    function createInventoryDialog()
    {
        $('#inventoryDialog').modal();
    }
    function createCharacterDialog()
    {
        $('#characterDialog').modal();
    }
    function createEquipDialog()
    {
        $('#equipDialog').modal();
    }
    function createStoryLevelDialog()
    {
        $('#storylevelDialog').modal();
    }
    function createStoryRewardDialog()
    {
        $('#storyrewardDialog').modal();
    }
    function createPvpDialog()
    {
        $('#pvpDialog').modal();
    }
    function editPlayerNameDialog()
    {
        $('#playerEditDialog').modal();
    }
    function editInventoryDialog(no, inventory, quantity)
    {
        $('#iv_edit_quantity').val(quantity);
        $('#iv_edit_iid').val(no);
        $("#iv_edit_name").val(inventory);
        $('#inventoryEditDialog').modal();
    }
    function editEquipDialog(data)
    {
        var eqInfo = JSON.parse(data);
        $('#eq_edit_eid').val(eqInfo.EquipmentID);
        $('#eq_edit_name').val(eqInfo.EquipmentStatsID);
        $("#eq_edit_exp").val(eqInfo.CurrentExp);
        $("#eq_edit_level").val(eqInfo.Level);
        $("#eq_edit_star").val(eqInfo.Star);
        $("#eq_edit_total_exp").val(eqInfo.TotalExp);
        $("#eq_edit_skill_level").val(eqInfo.SkillLevel);
        $('#equipEditDialog').modal();
    }
    function editCharacterDialog(data)
    {
        var chInfo = JSON.parse(data);
        $('#ch_edit_cid').val(chInfo.CharacterID);
        $('#ch_edit_name').val(chInfo.CharacterStatsID);
        $("#ch_edit_exp").val(chInfo.CurrentExp);
        $("#ch_edit_star").val(chInfo.Star);
        $("#ch_edit_border").val(chInfo.Border);
        $("#ch_edit_equip1").val(chInfo.Equipment1);
        $("#ch_edit_equip2").val(chInfo.Equipment2);
        $("#ch_edit_equip3").val(chInfo.Equipment3);
        $("#ch_edit_total_exp").val(chInfo.TotalExp);
        $("#ch_edit_level").val(chInfo.Level);
        $('#characterEditDialog').modal();
    }
    function editStagelevelDialog(no, stage_id, clear_status, stage_star)
    {
        $('#st_edit_name').val(stage_id);
        $('#st_edit_sid').val(no);
        $("#st_edit_clear_status").val(clear_status);
        $("#st_edit_stage_star").val(stage_star);
        $('#storylevelEditDialog').modal();

    }
    function editStagerewardDialog(no, reward_id, claim_status)
    {
        $('#str_edit_rid').val(no);
        $('#str_edit_name').val(reward_id);
        $("#str_edit_claim_status").val(claim_status);
        $('#storyrewardEditDialog').modal();
    }
    function editPvpDialog(no, group_id, rating, highscore, leader_rank, win_ratio, history, reward_history)
    {
        $('#pvp_edit_group_id').val(group_id);
        $('#pvp_edit_rating').val(rating);
        $('#pvp_edit_rating_highscore').val(highscore);
        $('#pvp_edit_leader_rank').val(leader_rank);
        $('#pvp_edit_win_ratio').val(win_ratio);
        $('#pvp_edit_match_history').val(history);
        $('#pvp_edit_reward_history').val(reward_history);
        $('#pvp_edit_pid').val(no);
        $('#pvpEditDialog').modal();
    }
    function editCurrencyDialog()
    {
        $('#currencyEditDialog').modal();
    }
    function uploadPlayerJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadPlayer').click();
        }
    }
    function uploadCurrencyJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadCurrency').click();
        }
    }
    function uploadCharacterJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadCharacter').click();
        }
    }
    function uploadEquipJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadEquip').click();
        }
    }
    function fetchEquipDataJSON()
    {
      var file = document.getElementById('uploadEquip').files[0]; //sames as here
      var reader = new FileReader();
      var fileElement = document.getElementById("fromAddFileEquip");
      var data = new FormData(fileElement);
      reader.onloadend = function() {
          //formElement.submit();
          $('#loadingEquip').show();
          $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              processData: false, // Important!
              contentType: false,
              url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadEquipDataJson' ?>',
              data: data, // serializes the form's elements.
              success: function(data)
              {
                  $('#loadingEquip').hide();
                  var jsonData = JSON.parse(data);
                  if (jsonData.result == 200)
                  {
                      location.href = '<?php echo base_url() . 'index.php/AdminController/userDetailPage/' . $userInfo->PlayerID ?>';
                  }
                  else
                  {
                      swal('Json file invalid format', '', 'error');
                      return;
                  }
              }
          });
      };
      if (file) {
          reader.readAsDataURL(file); //reads the data as a URL
      }
    }
    function fetchCharacterDataJSON()
    {
      var file = document.getElementById('uploadCharacter').files[0]; //sames as here
      var reader = new FileReader();
      var fileElement = document.getElementById("fromAddFileCharacter");
      var data = new FormData(fileElement);
      reader.onloadend = function() {
          //formElement.submit();
          $('#loadingCharacter').show();
          $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              processData: false, // Important!
              contentType: false,
              url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadCharacterDataJson' ?>',
              data: data, // serializes the form's elements.
              success: function(data)
              {
                  $('#loadingCharacter').hide();
                  var jsonData = JSON.parse(data);
                  if (jsonData.result == 200)
                  {
                      location.href = '<?php echo base_url() . 'index.php/AdminController/userDetailPage/' . $userInfo->PlayerID ?>';
                  }
                  else
                  {
                      swal('Json file invalid format', '', 'error');
                      return;
                  }
              }
          });
      };
      if (file) {
          reader.readAsDataURL(file); //reads the data as a URL
      }
    }
    function fetchCurrencyDataJSON()
    {
      var file = document.getElementById('uploadCurrency').files[0]; //sames as here
      var reader = new FileReader();
      var fileElement = document.getElementById("fromAddFileCurrency");
      var data = new FormData(fileElement);
      reader.onloadend = function() {
          //formElement.submit();
          $('#loadingCurrency').show();
          $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              processData: false, // Important!
              contentType: false,
              url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadCurrencyJson' ?>',
              data: data, // serializes the form's elements.
              success: function(data)
              {
                  $('#loadingCurrency').hide();
                  var jsonData = JSON.parse(data);
                  if (jsonData.result == 200)
                  {
                      location.href = '<?php echo base_url() . 'index.php/AdminController/userDetailPage/' . $userInfo->PlayerID ?>';
                  }
                  else
                  {
                      swal('Json file invalid format', '', 'error');
                      return;
                  }
              }
          });
      };
      if (file) {
          reader.readAsDataURL(file); //reads the data as a URL
      }
    }
    function fetchPlayerDataJSON()
    {
        var file = document.getElementById('uploadPlayer').files[0]; //sames as here
        var reader = new FileReader();
        var fileElement = document.getElementById("fromAddFilePlayer");
        var data = new FormData(fileElement);
        reader.onloadend = function() {
            //formElement.submit();
            $('#loadingPlayer').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadPlayerJson' ?>',
                data: data, // serializes the form's elements.
                success: function(data)
                {
                    $('#loadingPlayer').hide();
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == 200)
                    {
                        location.href = '<?php echo base_url() . 'index.php/AdminController/userDetailPage/' . $userInfo->PlayerID ?>';
                    }
                    else
                    {
                        swal('Json file invalid format', '', 'error');
                        return;
                    }
                }
            });
        };
        if (file) {
            reader.readAsDataURL(file); //reads the data as a URL
        }
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#summary" data-toggle="tab">Summary</a></li>
                <li><a href="#inventory" data-toggle="tab">Inventory</a></li>
                <li><a href="#currency" data-toggle="tab">Currency</a></li>
                <li><a href="#character" data-toggle="tab">Characters</a></li>
                <li><a href="#equipment" data-toggle="tab">Equipment</a></li>
                <li><a href="#progression" data-toggle="tab">Progression</a></li>
                <li><a href="#pvp" data-toggle="tab">PvP</a></li>
                <li><a href="#social" data-toggle="tab">Social</a></li>
                <li><a href="#mailbox" data-toggle="tab">Mailbox</a></li>
                <li><a href="#analytics" data-toggle="tab">Analytics</a></li>

            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="summary">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                    <div class="row col-md-12" style="margin-bottom:20px;margin-left: -20px;">
                        <div class="form-group">
                            <form id='fromAddFilePlayer' name='fromAddFilePlayer' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadPlayerJson'; ?>' enctype="multipart/form-data">
                                <input type="file" accept=".json" name="uploadPlayer" id="uploadPlayer" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchPlayerDataJSON()">
                                <input type="hidden" name="accountUserId" id="accountUserId" value="<?php echo $userInfo->PlayerID; ?>">
                                <div class="col-md-2" >
                                    <button type="button" class ="btn btn-block btn-success" onclick='uploadPlayerJSON()'>Fetch Data From JSON File</button>
                                </div>
                                <div class="col-md-2" >
                                    <a href="<?php echo base_url() .'player.json'; ?>" download="Player.json" class ="btn btn-block btn-success">Download JSON file</a>
                                </div>
                                <div class="overlay" id="loadingPlayer" style="display:none;">
                                    <i class="fa fa-refresh fa-spin" style="margin-top: 10px;"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                  }
                   ?>
                    <div class="row" style="margin-left:10px;">
                        <div class="col-md-2">
                            <label>ID</label>
                            <p><?php echo $userInfo->PlayerID; ?></p>
                        </div>
                        <div class="col-md-2">
                            <label>Player Name</label>
                            <p><a href="#" onclick="editPlayerNameDialog()"><?php echo $userInfo->PlayerName; ?></a></p>
                        </div>
                        <div class="col-md-2">
                            <label>Player Exp</label>
                            <p><?php echo $userInfo->PlayerCurrentExp; ?></p>
                        </div>
                        <div class="col-md-2">
                            <label>Player Level</label>
                            <p><?php echo $userInfo->PlayerLevel; ?></p>
                        </div>
                    </div>

                    <div class="row" style="margin-left:10px;">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label>Create DateTime</label>
                                <p><?php echo $userInfo->CreationTime; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Email Account</label>
                                <p><?php echo $userInfo->Email; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Last Login</label>
                                <p><?php echo $userInfo->LastLogin; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Account Status</label>
                                <p>
                                    <?php
                                    if ($userInfo->Status == 0) {
                                        $msg = '';
                                        $now = new DateTime();

                                        $timestamp = $now->getTimestamp();

                                        if ($userInfo->LockDuration == 0) {
                                            $msg = '(forever)';
                                            echo "Disabled " . $msg;
                                        } else {
                                            $duration = $userInfo->LockDuration - $timestamp;
                                            if ($duration > 0) {
                                                $mins = ($duration / 60) % 60;
                                                $hours = (int) (($duration / 60) / 60);
                                                $msg = "(" . $hours . " hours " . $mins . " mins left)";
                                                echo "Disabled " . $msg;
                                            } else {
                                                echo "Enabled";
                                            }
                                        }
                                    } else {
                                        echo "Enabled";
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="inventory">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createInventoryDialog()'>Add Inventory</a>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($inventoryInfos as $inventory) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $inventory->name; ?></td>
                                    <td><?php echo $inventory->Quantity; ?></td>
                                    <td>
                                        <a href='#' onclick='editInventoryDialog("<?php echo $inventory->no; ?>", "<?php echo $inventory->InventoryID; ?>", "<?php echo $inventory->Quantity; ?>")'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteInventory/' . $inventory->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="currency">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='editCurrencyDialog()'><?php echo lang("text_25"); ?></a>
                        </div>
                        <?php
                        if ($this->session->level == "0") {
                            ?>
                        <form id='fromAddFileCurrency' name='fromAddFileCurrency' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadCurrencyJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadCurrency" id="uploadCurrency" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchCurrencyDataJSON()">
                            <input type="hidden" name="currencyUserId" id="currencyUserId" value="<?php echo $userInfo->PlayerID; ?>">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadCurrencyJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'currency.json'; ?>" download="Currency.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="overlay" id="loadingCurrency" style="display:none;">
                                <i class="fa fa-refresh fa-spin" style="margin-top: 10px;"></i>
                            </div>
                        </form>
                        <?php
                        }
                       ?>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <tbody>
                            <?php
                            foreach ($currencys as $currency) {
                                ?>
                                <tr>
                                    <td style="width:100px;"><?php echo $currency->name; ?></th>
                                    <td>
                                        <?php
                                        $amount = 0;
                                foreach ($currencyInfos as $cInfo) {
                                    if ($cInfo->cid == $currency->no) {
                                        $amount = $cInfo->amount;
                                    }
                                }
                                echo $amount; ?>
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
                            <a href='#' class="btn btn-block btn-success" onclick='createCharacterDialog()'>Add Character</a>
                        </div>
                        <?php
                        if ($this->session->level == "0") {
                            ?>
                        <form id='fromAddFileCharacter' name='fromAddFileCharacter' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadCharacterJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadCharacter" id="uploadCharacter" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchCharacterDataJSON()">
                            <input type="hidden" name="characterUserId" id="characterUserId" value="<?php echo $userInfo->PlayerID; ?>">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadCharacterJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'character.json'; ?>" download="Character.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="overlay" id="loadingCharacter" style="display:none;">
                                <i class="fa fa-refresh fa-spin" style="margin-top: 10px;"></i>
                            </div>
                        </form>
                        <?php
                        }
                       ?>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Exp</th>
                                <th>Star</th>
                                <th>Border</th>
                                <th>Equip1</th>
                                <th>Equip2</th>
                                <th>Equip3</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($characterInfo as $chInfo) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php
                                        foreach ($characters as $ch) {
                                            if ($ch->CharacterStatsID == $chInfo->CharacterStatsID) {
                                                echo $ch->Name;
                                            }
                                        } ?>
                                    </td>
                                    <td><?php echo $chInfo->CurrentExp; ?></td>
                                    <td><?php echo $chInfo->Star; ?></td>
                                    <td><?php echo $chInfo->Border; ?></td>
                                    <td>
                                        <?php
                                          echo $chInfo->Equipment1; ?>
                                    </td>
                                    <td>
                                      <?php
                                        echo $chInfo->Equipment2; ?>
                                    </td>
                                    <td>
                                      <?php
                                        echo $chInfo->Equipment3; ?>
                                    </td>
                                    <td>
                                        <a href='#' onclick="editCharacterDialog('<?php echo htmlspecialchars(json_encode($chInfo)); ?>')"><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteCharacter/' . $chInfo->CharacterID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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
                            <a href='#' class="btn btn-block btn-success" onclick='createEquipDialog()'>Add Equipment</a>
                        </div>
                        <?php
                        if ($this->session->level == "0") {
                            ?>
                        <form id='fromAddFileEquip' name='fromAddFileEquip' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadEquipDataJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadEquip" id="uploadEquip" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchEquipDataJSON()">
                            <input type="hidden" name="equipUserId" id="equipUserId" value="<?php echo $userInfo->PlayerID; ?>">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadEquipJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'equip.json'; ?>" download="Equip.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="overlay" id="loadingEquip" style="display:none;">
                                <i class="fa fa-refresh fa-spin" style="margin-top: 10px;"></i>
                            </div>
                        </form>
                        <?php
                        }
                       ?>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Exp</th>
                                <th>Level</th>
                                <th>Star</th>
                                <th>Skill_Level</th>
                                <th>Total Exp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($equipInfos as $equip) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <?php
                                foreach ($equips as $eq) {
                                    if ($eq->EquipmentStatsID == $equip->EquipmentStatsID) {
                                        echo $eq->Name;
                                    }
                                } ?>
                                    </td>
                                    <td><?php echo $equip->CurrentExp; ?></td>
                                    <td><?php echo $equip->Level; ?></td>
                                    <td><?php echo $equip->Star; ?></td>
                                    <td><?php echo $equip->SkillLevel; ?></td>
                                    <td><?php echo $equip->TotalExp; ?></td>
                                    <td>
                                        <a href='#' onclick="editEquipDialog('<?php echo htmlspecialchars(json_encode($equip)); ?>')"><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteEquip/' . $equip->EquipmentID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="progression">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#storylevel" data-toggle="tab">Storyline Levels</a></li>
                        <li><a href="#storyreward" data-toggle="tab">Storyline Rewards</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="storylevel">
                            <div class="row" style="margin-bottom: 10px;margin-top:10px;">
                                <div class="col-md-2" >
                                    <a href='#' class="btn btn-block btn-success" onclick='createStoryLevelDialog()'>Add Story Level</a>
                                </div>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Stage ID</th>
                                        <th>Stage Stars</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($stLevelInfo as $level) {
                                        $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $level->name; ?></td>
                                            <td><?php echo $level->stage_star; ?></td>
                                            <td>
                                                <a href='#' onclick='editStagelevelDialog("<?php echo $level->no; ?>", "<?php echo $level->stage_id; ?>", "<?php echo $level->clear_status; ?>", "<?php echo $level->stage_star; ?>")'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                                <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteProgressLevel/' . $equip->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="storyreward">
                            <div class="row" style="margin-bottom: 10px;margin-top:10px;">
                                <div class="col-md-2" >
                                    <a href='#' class="btn btn-block btn-success" onclick='createStoryRewardDialog()'>Add Story Reward</a>
                                </div>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Reward ID</th>
                                        <th>Claimed Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($stRewardInfo as $reward) {
                                        $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $reward->name; ?></td>
                                            <td><?php echo $reward->claim_status; ?></td>
                                            <td>
                                                <a href='#' onclick='editStagerewardDialog("<?php echo $reward->no; ?>", "<?php echo $reward->reward_id; ?>", "<?php echo $reward->claim_status; ?>")'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                                <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteProgressReward/' . $equip->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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
                <div class="tab-pane" id="pvp">
                    <?php
                        if (count($pvpInfo) > 0) {
                            $pvp = $pvpInfo[0]; ?>
                          <div class="row" style="margin-left:10px;">
                              <div class="col-md-2">
                                  <label>Rating</label>
                                  <p><?php echo $pvp->Rating; ?></p>
                              </div>
                              <div class="col-md-2">
                                  <label>Match History</label>
                                  <p><?php echo $pvp->MatchHistory; ?></a></p>
                              </div>
                              <div class="col-md-2">
                                  <label>Win</label>
                                  <p><?php echo $pvp->Win; ?></p>
                              </div>
                          </div>

                          <div class="row" style="margin-left:10px;">
                            <div class="col-md-2">
                                <label>Bracket</label>
                                <p><?php echo $pvp->Bracket; ?></p>
                            </div>
                              <div class="col-md-2">
                                  <label>Lose</label>
                                  <p><?php echo $pvp->Lose; ?></p>
                              </div>
                          </div>

                  <?php
                        }
                   ?>
                </div>
                <div class="tab-pane" id="social">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Friend Name</th>
                                <th>Datetime</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="mailbox">
                    <div class="row col-md-12" style="margin-bottom:20px;margin-left: -20px;">
                        <div class="form-group">
                            <form id='fromAddFilePlayer' name='fromAddFilePlayer' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadPlayerJson'; ?>' enctype="multipart/form-data">
                                <input type="file" accept=".json" name="uploadPlayer" id="uploadPlayer" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchPlayerDataJSON()">
                                <input type="hidden" name="accountUserId" id="accountUserId" value="<?php echo $userInfo->PlayerID; ?>">
                                <div class="col-md-2" >
                                    <a href='<?php echo base_url()."index.php/AdminController/addMailPage/". $userInfo->PlayerID?>' type="button" class ="btn btn-block btn-success">Send Mail</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Attachment1</th>
                                <th>Attachment2</th>
                                <th>Attachment3</th>
                                <th>Attachment4</th>
                                <th>Attachment5</th>
                                <th>DateTime</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                              $itemTypes = ["Currency","SoulShard","Item","Equipment","Character"];
                              foreach($emails as $email)
                              {
                              ?>
                              <td><?php echo $email->MailID;?></td>
                              <td><?php echo $email->Title;?></td>
                              <td><?php echo $email->Message;?></td>
                              <td>
                                <?php
                                  if ($email->ItemType != -1)
                                  {
                                      echo "(".$itemTypes[$email->ItemType].")  ".$email->ItemID."   ".$email->Quantity;
                                  }
                                ?>
                              </td>
                              <td>
                                <?php
                                  if ($email->ItemType2 != -1)
                                  {
                                      echo "(".$itemTypes[$email->ItemType2].")  ".$email->ItemID2."   ".$email->Quantity2;
                                  }
                                ?>
                              </td>
                              <td>
                                <?php
                                  if ($email->ItemType3 != -1)
                                  {
                                      echo "(".$itemTypes[$email->ItemType3].")  ".$email->ItemID3."   ".$email->Quantity3;
                                  }
                                ?>
                              </td>
                              <td>
                                <?php
                                  if ($email->ItemType4 != -1)
                                  {
                                      echo "(".$itemTypes[$email->ItemType4].")  ".$email->ItemID4."   ".$email->Quantity4;
                                  }
                                ?>
                              </td>
                              <td>
                                <?php
                                  if ($email->ItemType5 != -1)
                                  {
                                      echo "(".$itemTypes[$email->ItemType5].")  ".$email->ItemID5."   ".$email->Quantity5;
                                  }
                                ?>
                              </td>
                              <td><?php echo $email->Expiry;?></td>
                              <td>
                                  <a href='<?php echo base_url() . 'index.php/AdminController/actionDeleteMail/' . $email->MailID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                              </td>
                              <?php
                              }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id='playerEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Player Name</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditPlayerName'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <input class='form-control' name='pl_edit_name' id='pl_edit_name' value='<?php echo $userInfo->name; ?>' placeholder='Name'/></a>
                        <br>
                        <input class='form-control' type='hidden' name='pl_edit_uid' id='pl_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='inventoryDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create an Inventory</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddInventory'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='iv_name' id='iv_name'>
                            <?php
                            for ($i = 0; $i < count($inventorys); $i++) {
                                ?>
                                <option value='<?php echo $inventorys[$i]->no; ?>'><?php echo $inventorys[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Quantity</label>
                        <input class='form-control' type='number' name='iv_quantity' id='iv_quantity' value='' placeholder='Quantity'/></a>

                        <input class='form-control' type='hidden' name='iv_uid' id='iv_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
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
                    <h4 class="modal-title">Edit an Inventory</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditInventory'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='iv_edit_name' id='iv_edit_name'>
                            <?php
                            for ($i = 0; $i < count($inventorys); $i++) {
                                ?>
                                <option value='<?php echo $inventorys[$i]->no; ?>'><?php echo $inventorys[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Quantity</label>
                        <input class='form-control' type='number' name='iv_edit_quantity' id='iv_edit_quantity' value='' placeholder='Quantity'/></a>

                        <input class='form-control' type='hidden' name='iv_edit_uid' id='iv_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>
                        <input class='form-control' type='hidden' name='iv_edit_iid' id='iv_edit_iid' value=''/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
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
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditCurrency'; ?>'>
                    <div class="modal-body">
                        <?php
                        foreach ($currencys as $currency) {
                            ?>
                            <label for="exampleInputEmail1"><?php echo $currency->name; ?></label>
                            <?php
                            $amount = 0;
                            foreach ($currencyInfos as $cInfo) {
                                if ($cInfo->cid == $currency->no) {
                                    $amount = $cInfo->amount;
                                }
                            } ?>
                            <input class='form-control' type='number' name='cy_edit_number[]' id='iv_edit_quantity' value='<?php echo $amount; ?>' placeholder='Amount'/></a>
                            <br>
                            <?php
                        }
                        ?>
                        <input class='form-control' type='hidden' name='uid' id='uid' value='<?php echo $userInfo->PlayerID; ?>' />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='equipDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create an Equipment</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddEquipment'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">EquipmentID</label>
                        <input class='form-control' type='text' name='eq_id' id='eq_id' value='' placeholder='Equipment ID'/></a>
                        <br>
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='eq_name' id='eq_name'>
                            <?php
                            for ($i = 0; $i < count($equips); $i++) {
                                ?>
                                <option value='<?php echo $equips[$i]->EquipmentStatsID; ?>'><?php echo $equips[$i]->Name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Exp</label>
                        <input class='form-control' type='number' name='eq_exp' id='eq_exp' value='' placeholder='Exp Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Level</label>
                        <input class='form-control' type='number' name='eq_level' id='eq_level' value='' placeholder='Level Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Star</label>
                        <input class='form-control' type='number' name='eq_star' id='eq_star' value='' placeholder='Star Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Total Exp</label>
                        <input class='form-control' type='number' name='eq_total_exp' id='eq_total_exp' value='' placeholder='Total Exp'/></a>

                        <br>
                        <label for="exampleInputEmail1">Skill Level</label>
                        <input class='form-control' type='number' name='eq_skill_level' id='eq_skill_level' value='' placeholder='Skill Level'/></a>

                        <input class='form-control' type='hidden' name='eq_uid' id='eq_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id='equipEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit an Equipment</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditEquipment'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='eq_edit_name' id='eq_edit_name'>
                            <?php
                            for ($i = 0; $i < count($equips); $i++) {
                                ?>
                                <option value='<?php echo $equips[$i]->EquipmentStatsID; ?>'><?php echo $equips[$i]->Name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Exp</label>
                        <input class='form-control' type='text' name='eq_edit_exp' id='eq_edit_exp' value='' placeholder='Exp Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Level</label>
                        <input class='form-control' type='text' name='eq_edit_level' id='eq_edit_level' value='' placeholder='Level Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Star</label>
                        <input class='form-control' type='text' name='eq_edit_star' id='eq_edit_star' value='' placeholder='Star Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Total Exp</label>
                        <input class='form-control' type='number' name='eq_edit_total_exp' id='eq_edit_total_exp' value='' placeholder='Total Exp'/></a>

                        <br>
                        <label for="exampleInputEmail1">Skill Level</label>
                        <input class='form-control' type='number' name='eq_edit_skill_level' id='eq_edit_skill_level' value='' placeholder='Skill Level'/></a>

                        <input class='form-control' type='hidden' name='eq_edit_uid' id='eq_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>
                        <input class='form-control' type='hidden' name='eq_edit_eid' id='eq_edit_eid' value=''/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='characterDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create a Character</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddCharacter'; ?>'>
                    <div class="modal-body">

                        <label for="exampleInputEmail1">CharacterID</label>
                        <input class='form-control' type='text' name='ch_e_id' id='ch_e_id' value='' placeholder='CharacterID'/></a>
                        <br>

                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='ch_name' id='ch_name'>
                            <?php
                            for ($i = 0; $i < count($characters); $i++) {
                                ?>
                                <option value='<?php echo $characters[$i]->CharacterStatsID; ?>'><?php echo $characters[$i]->Name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Exp</label>
                        <input class='form-control' type='number' name='ch_exp' id='ch_exp' value='' placeholder='Exp Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Star</label>
                        <input class='form-control' type='number' name='ch_star' id='ch_star' value='' placeholder='Star Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Border</label>
                        <input class='form-control' type='number' name='ch_border' id='ch_border' value='' placeholder='Border Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Level</label>
                        <input class='form-control' type='number' name='ch_level' id='ch_level' value='' placeholder='Level Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Total Exp</label>
                        <input class='form-control' type='number' name='ch_total_exp' id='ch_total_exp' value='' placeholder='Total Exp'/></a>

                        <br>
                        <label for="exampleInputEmail1">Equipment1</label>
                        <select class='form-control' name='ch_equip1' id='ch_equip1'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Equipment2</label>
                        <select class='form-control' name='ch_equip2' id='ch_equip2'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Equipment3</label>
                        <select class='form-control' name='ch_equip3' id='ch_equip3'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>

                        <input class='form-control' type='hidden' name='ch_uid' id='ch_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='characterEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit a Character</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditCharacter'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='ch_edit_name' id='ch_edit_name'>
                            <?php
                            for ($i = 0; $i < count($characters); $i++) {
                                ?>
                                <option value='<?php echo $characters[$i]->CharacterStatsID; ?>'><?php echo $characters[$i]->Name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Exp</label>
                        <input class='form-control' type='number' name='ch_edit_exp' id='ch_edit_exp' value='' placeholder='Exp Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Star</label>
                        <input class='form-control' type='number' name='ch_edit_star' id='ch_edit_star' value='' placeholder='Star Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Border</label>
                        <input class='form-control' type='number' name='ch_edit_border' id='ch_edit_border' value='' placeholder='Border Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Level</label>
                        <input class='form-control' type='number' name='ch_edit_level' id='ch_edit_level' value='' placeholder='Level Value'/></a>

                        <br>
                        <label for="exampleInputEmail1">Total Exp</label>
                        <input class='form-control' type='number' name='ch_edit_total_exp' id='ch_edit_total_exp' value='' placeholder='Total Exp'/></a>

                        <br>
                        <label for="exampleInputEmail1">Equipment1</label>
                        <select class='form-control' name='ch_edit_equip1' id='ch_edit_equip1'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Equipment2</label>
                        <select class='form-control' name='ch_edit_equip2' id='ch_edit_equip2'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Equipment3</label>
                        <select class='form-control' name='ch_edit_equip3' id='ch_edit_equip3'>
                            <option value='0'>None</option>
                            <?php
                            for ($i = 0; $i < count($equipInfos); $i++) {
                                ?>
                                <option value='<?php echo $equipInfos[$i]->EquipmentID; ?>'><?php echo $equipInfos[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>

                        <input class='form-control' type='hidden' name='ch_edit_uid' id='ch_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/>
                        <input class='form-control' type='hidden' name='ch_edit_cid' id='ch_edit_cid' value=''/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id='storylevelDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create a Story Level</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddStoryLevel'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='st_name' id='st_name'>
                            <?php
                            for ($i = 0; $i < count($stLevels); $i++) {
                                ?>
                                <option value='<?php echo $stLevels[$i]->no; ?>'><?php echo $stLevels[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Clear Status</label>
                        <input class='form-control' type='number' name='st_clear_status' id='st_clear_status' value='' placeholder='Clear Status'/></a>

                        <br>
                        <label for="exampleInputEmail1">Stage Star</label>
                        <input class='form-control' type='number' name='st_stage_star' id='st_stage_star' value='' placeholder='Stage Star'/></a>

                        <input class='form-control' type='hidden' name='st_uid' id='iv_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='storylevelEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit a Story Level</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditStoryLevel'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='st_edit_name' id='st_edit_name'>
                            <?php
                            for ($i = 0; $i < count($stLevels); $i++) {
                                ?>
                                <option value='<?php echo $stLevels[$i]->no; ?>'><?php echo $stLevels[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Clear Status</label>
                        <input class='form-control' type='number' name='st_edit_clear_status' id='st_edit_clear_status' value='' placeholder='Clear Status'/></a>

                        <br>
                        <label for="exampleInputEmail1">Stage Star</label>
                        <input class='form-control' type='number' name='st_edit_stage_star' id='st_edit_stage_star' value='' placeholder='Stage Star'/></a>

                        <input type='hidden' name='st_edit_uid' id='st_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>
                        <input type='hidden' name='st_edit_sid' id='st_edit_sid' value=''/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='storyrewardDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create a Story Reward</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddStoryReward'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='str_name' id='str_name'>
                            <?php
                            for ($i = 0; $i < count($stRewards); $i++) {
                                ?>
                                <option value='<?php echo $stRewards[$i]->no; ?>'><?php echo $stRewards[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Claim Status</label>
                        <input class='form-control' type='number' name='str_claim_status' id='str_claim_status' value='' placeholder='Claim Status'/></a>

                        <input type='hidden' name='str_uid' id='str_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id='storyrewardEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit a Story Reward</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditStoryReward'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Name</label>
                        <select class='form-control' name='str_edit_name' id='str_edit_name'>
                            <?php
                            for ($i = 0; $i < count($stRewards); $i++) {
                                ?>
                                <option value='<?php echo $stRewards[$i]->no; ?>'><?php echo $stRewards[$i]->name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br>
                        <label for="exampleInputEmail1">Claim Status</label>
                        <input class='form-control' type='number' name='str_edit_claim_status' id='str_edit_claim_status' value='' placeholder='Claim Status'/></a>

                        <input type='hidden' name='str_edit_uid' id='str_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>
                        <input type='hidden' name='str_edit_rid' id='str_edit_rid' value=''/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div class="modal fade" tabindex="-1" role="dialog" id='pvpDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Create a Pvp Info</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionAddPvp'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Group ID</label>
                        <input class='form-control' type='number' name='pvp_group_id' id='pvp_group_id' value='' placeholder='Pvp Group ID'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Rating</label>
                        <input class='form-control' type='number' name='pvp_rating' id='pvp_rating' value='' placeholder='Pvp Rating'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Rating Highscore</label>
                        <input class='form-control' type='number' name='pvp_rating_highscore' id='pvp_rating_highscore' value='' placeholder='Pvp Rating Highscore'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Leader Rank</label>
                        <input class='form-control' type='number' name='pvp_leader_rank' id='pvp_leader_rank' value='' placeholder='Pvp Leader Rank'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Win/Lose Ratio</label>
                        <input class='form-control' type='number' name='pvp_win_ratio' id='pvp_win_ratio' value='' placeholder='Pvp Win/Lose Ratio'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Match History</label>
                        <input class='form-control' type='number' name='pvp_match_history' id='pvp_match_history' value='' placeholder='Pvp Match History'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Reward History</label>
                        <input class='form-control' type='number' name='pvp_reward_history' id='pvp_reward_history' value='' placeholder='Pvp Reward History'/></a>
                        <br>

                        <input type='hidden' name='pvp_uid' id='pvp_uid' value='<?php echo $userInfo->PlayerID; ?>'/></a>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id='pvpEditDialog'>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit a Pvp Info</h4>
                </div>
                <form method='post' action='<?php echo base_url() . 'index.php/AdminController/actionEditPvp'; ?>'>
                    <div class="modal-body">
                        <label for="exampleInputEmail1">Group ID</label>
                        <input class='form-control' type='number' name='pvp_edit_group_id' id='pvp_edit_group_id' value='' placeholder='Pvp Group ID'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Rating</label>
                        <input class='form-control' type='number' name='pvp_edit_rating' id='pvp_edit_rating' value='' placeholder='Pvp Rating'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Rating Highscore</label>
                        <input class='form-control' type='number' name='pvp_edit_rating_highscore' id='pvp_edit_rating_highscore' value='' placeholder='Pvp Rating Highscore'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Leader Rank</label>
                        <input class='form-control' type='number' name='pvp_edit_leader_rank' id='pvp_edit_leader_rank' value='' placeholder='Pvp Leader Rank'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Win/Lose Ratio</label>
                        <input class='form-control' type='number' name='pvp_edit_win_ratio' id='pvp_edit_win_ratio' value='' placeholder='Pvp Win/Lose Ratio'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Match History</label>
                        <input class='form-control' type='number' name='pvp_edit_match_history' id='pvp_edit_match_history' value='' placeholder='Pvp Match History'/></a>
                        <br>
                        <label for="exampleInputEmail1">Pvp Reward History</label>
                        <input class='form-control' type='number' name='pvp_edit_reward_history' id='pvp_edit_reward_history' value='' placeholder='Pvp Reward History'/></a>
                        <br>

                        <input type='hidden' name='pvp_edit_uid' id='pvp_edit_uid' value='<?php echo $userInfo->PlayerID; ?>'/>
                        <input type='hidden' name='pvp_edit_pid' id='pvp_edit_pid' value=''/>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
