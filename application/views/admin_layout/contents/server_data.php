
<script>
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
    function uploadStageJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadStage').click();
        }
    }
    function uploadMonsterJSON()
    {
        if (confirm('Are you sure you want to upload json file?')) {
            document.getElementById('uploadMonster').click();
        }
    }
    function uploadGlobalJSON()
    {
      if (confirm('Are you sure you want to upload json file?')) {
          document.getElementById('uploadGlobal').click();
      }
    }
    function createCurrencyDialog()
    {
        $('#currencyDialog').modal();
    }
    function clearDatabase(link)
    {
        if (confirm('Are you sure you want to clear server data?')) {
            location.href = link;
        }
    }
    function editCurrencyDialog(no,name)
    {
        $('#edit_currencyName').val(name);
        $('#cid').val(no);
        $('#currencyEditDialog').modal();
    }
    function editGlobalData(gData)
    {
      var gInfo = JSON.parse(gData);
      $('#edit_global_sversion').val(gInfo.ServerVersion);
      $('#edit_global_cversion').val(gInfo.ClientVersion);
      $('#edit_global_dailyreset').val(gInfo.DailyServerReset);
      $('#edit_global_meatrate').val(gInfo.MeatRechargeRate);
      $('#edit_global_pvp').val(gInfo.BasePvPTicketCap);
      $('#edit_global_playerexp').val(gInfo.PlayerExpTNL);
      $('#edit_global_pvpreset').val(gInfo.PvPReset);
      $('#edit_global_levelcap').val(gInfo.PlayerLevelCap);
      $('#edit_global_clevelcap').val(gInfo.CharacterLevelCap);
      $('#edit_global_glevelcap').val(gInfo.GulidLevelCap);
      $('#edit_global_base_gashareset').val(gInfo.FreeBasicGashaReset);
      $('#edit_global_pre_gashareset').val(gInfo.FreePremiumGashaReset);

      $('#globalEditDialog').modal();
    }
    function fetchMonsterDataJSON()
    {
        if (!confirm('Are you sure you want to import this json file?')) {
            return;
        }

        var file = document.getElementById('uploadMonster').files[0]; //sames as here
        var reader = new FileReader();
        var fileElement = document.getElementById("fromAddFileMonster");
        var data = new FormData(fileElement);
        reader.onloadend = function() {
            //formElement.submit();
            $('#loadingMonster').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadMonsterJson' ?>',
                data: data, // serializes the form's elements.
                success: function(data)
                {
                    $('#loadingMonster').hide();
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == 200)
                    {
                        location.href = '<?php echo base_url() . 'index.php/AdminController/serverDataPage' ?>';
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

    function fetchStageDataJSON()
    {
        var file = document.getElementById('uploadStage').files[0]; //sames as here
        var reader = new FileReader();
        var fileElement = document.getElementById("fromAddFileStage");
        var data = new FormData(fileElement);
        reader.onloadend = function() {
            //formElement.submit();
            $('#loadingEquip').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadStageJson' ?>',
                data: data, // serializes the form's elements.
                success: function(data)
                {
                    $('#loadingStage').hide();
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == 200)
                    {
                        location.href = '<?php echo base_url() . 'index.php/AdminController/serverDataPage' ?>';
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
    function fetchEqDataJSON()
    {
        var file = document.getElementById('uploadEquip').files[0]; //sames as here
        var reader = new FileReader();
        var fileElement = document.getElementById("fromAddFileEq");
        var data = new FormData(fileElement);
        reader.onloadend = function() {
            //formElement.submit();
            $('#loadingEquip').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadEquipJson' ?>',
                data: data, // serializes the form's elements.
                success: function(data)
                {
                    $('#loadingEquip').hide();
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == 200)
                    {
                        location.href = '<?php echo base_url() . 'index.php/AdminController/serverDataPage' ?>';
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
    function fetchGlobalDataJSON()
    {
      var file = document.getElementById('uploadGlobal').files[0]; //sames as here
      var reader = new FileReader();
      var fileElement = document.getElementById("fromAddGlobal");
      var data = new FormData(fileElement);
      reader.onloadend = function() {
          //formElement.submit();
          $('#loadingGlobal').show();
          $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              processData: false, // Important!
              contentType: false,
              url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadGlobalJson' ?>',
              data: data, // serializes the form's elements.
              success: function(data)
              {
                  $('#loadingGlobal').hide();
                  var jsonData = JSON.parse(data);
                  if (jsonData.result == 200)
                  {
                      location.href = '<?php echo base_url() . 'index.php/AdminController/serverDataPage' ?>';
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
    function fetchDataJSON()
    {
        var file = document.getElementById('uploadCharacter').files[0]; //sames as here
        var reader = new FileReader();
        var fileElement = document.getElementById("fromAddFile");
        var data = new FormData(fileElement);
        reader.onloadend = function() {
            //formElement.submit();
            $('#loadingCharacter').show();
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                url: '<?php echo base_url() . 'index.php/ServerDataController/actionUploadCharacterJson' ?>',
                data: data, // serializes the form's elements.
                success: function(data)
                {
                    $('#loadingCharacter').hide();
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == 200)
                    {
                        location.href = '<?php echo base_url() . 'index.php/AdminController/serverDataPage' ?>';
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
                <li class="active"><a href="#global" data-toggle="tab">Global</a></li>
                <li><a href="#character" data-toggle="tab">Character</a></li>
                <li><a href="#equipment" data-toggle="tab">Equipment</a></li>
                <li><a href="#stage" data-toggle="tab">Stage</a></li>
                <li><a href="#monster" data-toggle="tab">Monster</a></li>
                <li><a href="#currency" data-toggle="tab">Currency</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane box" id="global" style="border-top-color:#fff;">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                    <div class="row" style="margin-bottom: 10px">
                        <form id='fromAddGlobal' name='fromAddGlobal' method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionUploadGlobalJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadGlobal" id="uploadGlobal" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchGlobalDataJSON()">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadGlobalJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'globals.json'; ?>" download="Global.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <?php
                              if (count($globals) > 0) {
                                  $gInfo = $globals[0]; ?>
                                  <div class="col-md-1" >
                                      <a href='#' class ="btn btn-block btn-primary" onclick="editGlobalData('<?php echo htmlspecialchars(json_encode($gInfo)); ?>')">Edit</a>
                                  </div>
                                <?php
                              } ?>
                        </form>
                    </div>
                    <?php
                  }
                ?>
                    <?php
                      if (count($globals) > 0) {
                          $gInfo = $globals[0]; ?>
                        <div class="row" style="margin-left:10px;">
                            <div class="col-md-2">
                                <label>Server Version</label>
                                <p><?php echo $gInfo->ServerVersion; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Client Version</label>
                                <p><?php echo $gInfo->ClientVersion; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Daily Server Reset</label>
                                <p><?php echo $gInfo->DailyServerReset; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>Meat Recharge Rate</label>
                                <p><?php echo $gInfo->MeatRechargeRate; ?></p>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;">
                            <div class="col-md-2">
                                <label>BasePvpTicket</label>
                                <p><?php echo $gInfo->BasePvPTicketCap; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>PvPReset</label>
                                <p><?php echo $gInfo->PvPReset; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>PlayerLevelCap</label>
                                <p><?php echo $gInfo->PlayerLevelCap; ?></p>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;">
                            <div class="col-md-2">
                                <label>CharacterLevelCap</label>
                                <p><?php echo $gInfo->CharacterLevelCap; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>GulidLevelCap</label>
                                <p><?php echo $gInfo->GulidLevelCap; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>FreeBasicGashaReset</label>
                                <p><?php echo $gInfo->FreeBasicGashaReset; ?></p>
                            </div>
                            <div class="col-md-2">
                                <label>FreePremiumGashaReset</label>
                                <p><?php echo $gInfo->FreePremiumGashaReset; ?></p>
                            </div>
                        </div>
                    <?php
                      }
                  ?>
                  <div class="overlay" id="loadingGlobal" style="display: none;">
                      <i class="fa fa-refresh fa-spin"></i>
                  </div>
                </div>
                <div class="tab-pane box" id="character" style="border-top-color: #fff;">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                    <div class="row" style="margin-bottom: 10px">
                        <form id='fromAddFile' name='fromAddFile' method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionUploadCharacterJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadCharacter" id="uploadCharacter" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchDataJSON()">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadCharacterJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'character_serverdata.json'; ?>" download="CharacterServerData.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="col-md-2" >
                                <a href='#' onclick="clearDatabase('<?php echo base_url() . 'index.php/ServerDataController/actionClearCharacterData'; ?>')" class ="btn btn-block btn-danger">Clear All Datas</a>
                            </div>
                        </form>
                    </div>
                    <?php
                  }
                   ?>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Role</th>
                                <th>SoulshardsTNL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($characters as $ch) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $ch->CharacterStatsID; ?></td>
                                    <td><?php echo $ch->Name; ?></td>
                                    <td><?php echo $ch->Description; ?></td>
                                    <td><?php echo $ch->Role; ?></td>
                                    <td><?php echo $ch->SoulshardTNL; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/detailCharacterPage/' . $ch->CharacterStatsID; ?>'>Detail</a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/actionDeleteCharacter/' . $ch->CharacterStatsID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="overlay" id="loadingCharacter" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>

                <div class="tab-pane box" id="equipment" style="border-top-color: #fff;">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                      <div class="row" style="margin-bottom: 10px">
                          <form id='fromAddFileEq' name='fromAddFileEq' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadEquipJson'; ?>' enctype="multipart/form-data">
                              <input type="file" accept=".json" name="uploadEquip" id="uploadEquip" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchEqDataJSON()">
                              <div class="col-md-2" >
                                  <button type="button" class ="btn btn-block btn-success" onclick='uploadEquipJSON()'>Fetch Data From JSON File</button>
                              </div>
                              <div class="col-md-2" >
                                  <a href="<?php echo base_url() .'equip_serverdata.json'; ?>" download="EquipServerData.json" class ="btn btn-block btn-success">Download JSON file</a>
                              </div>
                              <div class="col-md-2" >
                                  <a href='#' onclick="clearDatabase('<?php echo base_url() . 'index.php/ServerDataController/actionClearEquipData'; ?>')" class ="btn btn-block btn-danger">Clear All Datas</a>
                              </div>
                          </form>
                      </div>
                    <?php
                  }
                   ?>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($equips as $eq) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $eq->EquipmentStateID; ?></td>
                                    <td><?php echo $eq->Name; ?></td>
                                    <td><?php echo $eq->Cost; ?></td>
                                    <td><?php echo $eq->Description; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/detailEquipPage/' . $eq->EquipmentStateID; ?>'>Detail</a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/actionDeleteEquipment/' . $eq->EquipmentStateID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="overlay" id="loadingEquip" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>

                <div class="tab-pane box" id="stage" style="border-top-color: #fff;">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                    <div class="row" style="margin-bottom: 10px">
                        <form id='fromAddFileStage' name='fromAddFileStage' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadStageJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadStage" id="uploadStage" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchStageDataJSON()">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadStageJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'stage_serverdata.json'; ?>" download="StageServerData.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="col-md-2" >
                                <a href='#' onclick="clearDatabase('<?php echo base_url() . 'index.php/ServerDataController/actionClearStageData '; ?>')" class ="btn btn-block btn-danger">Clear All Datas</a>
                            </div>
                        </form>
                    </div>
                    <?php
                  }
                   ?>
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Stage Requirement</th>
                                <th>Stage Reward</th>
                                <th>Meat Requirement</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($stages as $stage) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $stage->StageID; ?></td>
                                    <td><?php echo $stage->StageRequirement; ?></td>
                                    <td><?php echo $stage->StageReward; ?></td>
                                    <td><?php echo $stage->MeatRequirement; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/detailStagePage/' . $stage->StageID; ?>'>Detail</a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/actionDeleteStage/' . $stage->StageID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="overlay" id="loadingStage" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>

                <div class="tab-pane box" id="monster" style="border-top-color: #fff;">
                  <?php
                  if ($this->session->level == "0") {
                      ?>
                    <div class="row" style="margin-bottom: 10px">
                        <form id='fromAddFileMonster' name='fromAddFileMonster' method='post' action='<?php echo base_url() . 'index.php/AdminController/actionUploadMonsterJson'; ?>' enctype="multipart/form-data">
                            <input type="file" accept=".json" name="uploadMonster" id="uploadMonster" style="visibility: hidden; width: 1px; height: 1px" multiple onchange="fetchMonsterDataJSON()">
                            <div class="col-md-2" >
                                <button type="button" class ="btn btn-block btn-success" onclick='uploadMonsterJSON()'>Fetch Data From JSON File</button>
                            </div>
                            <div class="col-md-2" >
                                <a href="<?php echo base_url() .'monster_serverdata.json'; ?>" download="MonsterServerData.json" class ="btn btn-block btn-success">Download JSON file</a>
                            </div>
                            <div class="col-md-2" >
                                <a href='#' onclick="clearDatabase('<?php echo base_url() . 'index.php/ServerDataController/actionClearMonsterData '; ?>')" class ="btn btn-block btn-danger">Clear All Datas</a>
                            </div>
                        </form>
                    </div>
                    <?php
                  }
                   ?>
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($monsters as $monster) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $monster->MonsterID; ?></td>
                                    <td><?php echo $monster->Name; ?></td>
                                    <td><?php echo $monster->Type; ?></td>
                                    <td>
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/detailMonsterPage/' . $monster->MonsterID; ?>'>Detail</a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/ServerDataController/actionDeleteMonster/' . $monster->MonsterID; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="overlay" id="loadingMonster" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>

                <div class="tab-pane" id="currency">
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2" >
                            <a href='#' class="btn btn-block btn-success" onclick='createCurrencyDialog()'>Add Currency</a>
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
                            foreach ($currencys as $currency) {
                                $i++; ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $currency->name; ?></td>
                                    <td>
                                        <a href='#' onclick='editCurrencyDialog("<?php echo $currency->no; ?>", "<?php echo $currency->name; ?>")'><?php echo lang("text_25"); ?></a>&nbsp;&nbsp;&nbsp;
                                        <a href='<?php echo base_url() . 'index.php/SettingController/actionDeleteCurrency/' . $currency->no; ?>'><?php echo lang("text_26"); ?></a>&nbsp;&nbsp;&nbsp;
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

<div class="modal fade" tabindex="-1" role="dialog" id='globalEditDialog'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Global Data</h4>
            </div>
            <form method='post' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditGlobalData'; ?>'>
                <div class="modal-body">
                    <label for="exampleInputEmail1">Server Version</label>
                    <input class='form-control' name='edit_global_sversion' id='edit_global_sversion' value='' placeholder='Server Version'/></a>
                    <br>
                    <label for="exampleInputEmail1">Client Version</label>
                    <input class='form-control' name='edit_global_cversion' id='edit_global_cversion' value='' placeholder='Client Version'/></a>
                    <br>
                    <label for="exampleInputEmail1">Daily Server Reset</label>
                    <input class='form-control' name='edit_global_dailyreset' id='edit_global_dailyreset' value='' placeholder='Daily Server Reset'/></a>
                    <br>
                    <label for="exampleInputEmail1">Meat Recharge Rate</label>
                    <input class='form-control' name='edit_global_meatrate' id='edit_global_meatrate' value='' placeholder='Meat Recharge Rate'/></a>
                    <br>
                    <label for="exampleInputEmail1">Base PvpTicket</label>
                    <input class='form-control' name='edit_global_pvp' id='edit_global_pvp' value='' placeholder='Base PvpTicket'/></a>
                    <br>
                    <label for="exampleInputEmail1">Player ExpTNL</label>
                    <input class='form-control' name='edit_global_playerexp' id='edit_global_playerexp' value='' placeholder='Player ExpTNL'/></a>
                    <br>
                    <label for="exampleInputEmail1">PvPReset</label>
                    <input class='form-control' name='edit_global_pvpreset' id='edit_global_pvpreset' value='' placeholder='PvPReset'/></a>
                    <br>
                    <label for="exampleInputEmail1">Player LevelCap</label>
                    <input class='form-control' name='edit_global_levelcap' id='edit_global_levelcap' value='' placeholder='Player LevelCap'/></a>
                    <br>
                    <label for="exampleInputEmail1">Character LevelCap</label>
                    <input class='form-control' name='edit_global_clevelcap' id='edit_global_clevelcap' value='' placeholder='Character LevelCap'/></a>
                    <br>
                    <label for="exampleInputEmail1">GulidLevelCap</label>
                    <input class='form-control' name='edit_global_glevelcap' id='edit_global_glevelcap' value='' placeholder='GulidLevelCap'/></a>
                    <br>
                    <label for="exampleInputEmail1">FreeBasicGashaReset</label>
                    <input class='form-control' name='edit_global_base_gashareset' id='edit_global_base_gashareset' value='' placeholder='FreeBasicGashaReset'/></a>
                    <br>
                    <label for="exampleInputEmail1">FreePremiumGashaReset</label>
                    <input class='form-control' name='edit_global_pre_gashareset' id='edit_global_pre_gashareset' value='' placeholder='FreePremiumGashaReset'/></a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang("text_79"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo lang("text_27"); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
