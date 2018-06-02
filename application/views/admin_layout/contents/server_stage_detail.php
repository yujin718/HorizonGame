<script>
    function editStageInfo()
    {
        $('#editStageInfo').submit();
    }
</script>
<div class="row">
    <div class="col-md-12" style="margin: 10px; padding-right:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#summary" data-toggle="tab">Summary</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="summary">
                    <form id='editStageInfo' name='editStageInfo' method='POST' action='<?php echo base_url() . 'index.php/ServerDataController/actionEditStageInfo'; ?>'>
                        <input type='hidden' name="stageId" value='<?php echo $stageInfo->StageID; ?>'/>
                        <div class="row" style="margin-left:10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>StageRequirement</label>
                                        <input type='text' name="stageRequirement" class='form-control' value='<?php echo $stageInfo->StageRequirement; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>StageReward</label>
                                        <input type='text' name="stageReward" class='form-control' value='<?php echo $stageInfo->StageReward; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>MeatRequirement</label>
                                        <input type='text' name="stageMeat" class='form-control' value='<?php echo $stageInfo->MeatRequirement; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Tries</label>
                                        <input type='text' name="tries" class='form-control' value='<?php echo $stageInfo->Tries; ?>'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>FirstTimeReward</label>
                                        <input type='text' name="firstTimeReward" class='form-control' value='<?php echo $stageInfo->FirstTimeReward; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>GoldReward</label>
                                        <input type='text' name="goldreward" class='form-control' value='<?php echo $stageInfo->GoldReward; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>PlayerExpReward</label>
                                        <input type='text' name="playerExpReward" class='form-control' value='<?php echo $stageInfo->PlayerExpReward; ?>'/>
                                    </div>
                                    <div class="col-md-2">
                                        <label>CharacterExpReward</label>
                                        <input type='text' name="characterExpReward" class='form-control' value='<?php echo $stageInfo->CharacterExpReward; ?>'/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left:10px;margin-right: 10px;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>EnemyWavesDetail</label>
                                        <textarea class='form-control' name="stageEnemyWave"><?php echo $stageInfo->EnemyWavesDetail; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-left: -5px">
                            <div class="col-md-2" >
                                <button class="btn btn-block btn-success" onclick='editStageInfo()'>Update</button>
                            </div>
                            <div class="col-md-2" >
                                <a href='<?php echo base_url() . "index.php/AdminController/serverDataPage"; ?>' class="btn btn-block btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
