<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class ServerDataController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertStatsGrowTable($statsInfo)
    {
        $field_array = array(
            "HP" => "HP",
            "Damage" => "Damage",
            "Power" => "Power",
            "Armor" => "Armor",
            "Speed" => "Speed",
            "ResistFire" => "ResistFire",
            "ResistLight" => "ResistLight",
            "ResistWater" => "ResistWater",
            "ResistEarth" => "ResistEarth",
            "ResistDark" => "ResistDark",
            "Rng" => "Rng",
            "Movement" => "Movement",
            "HP_P" => "HP_P",
            "Armor_P" => "Armor_P",
            "Damage_P" => "Damage_P",
            "Speed_P" => "Speed_P",
            "Range_P" => "Range_P",
            "Movement_P" => "Movement_P",
            "ResistFire_P" => "ResistFire_P",
            "ResistWater_P" => "ResistWater_P",
            "ResistEarth_P" => "ResistEarth_P",
            "ResistLight_P" => "ResistLight_P",
            "ResistDark_P" => "ResistDark_P",

        );
        $insertFields = array();
        foreach ($field_array as $key => $value) {
            if (array_key_exists($value, $statsInfo)) {
                $insertFields[$key] = $statsInfo[$value];
            }
        }
        $insert_id = $this->sqllibs->insertRow($this->db, 'tbl_base_stats_grow', $insertFields);
        return $insert_id;
    }
    public function insertStatsTable($statsInfo)
    {
        $field_array = array(
            "HP" => "HP",
            "Damage" => "Damage",
            "Power" => "Power",
            "Armor" => "Armor",
            "Speed" => "Speed",
            "ResistFire" => "ResistFire",
            "ResistLight" => "ResistLight",
            "ResistWater" => "ResistWater",
            "ResistEarth" => "ResistEarth",
            "ResistDark" => "ResistDark",
        );
        $insertFields = array();
        foreach ($field_array as $key => $value) {
            if (array_key_exists($value, $statsInfo)) {
                $insertFields[$key] = $statsInfo[$value];
            }
        }
        $insert_id = $this->sqllibs->insertRow($this->db, 'tbl_base_stats', $insertFields);
        return $insert_id;
    }

    public function detailStagePage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("ServerStageDetail", "Admin");
        $data = $this->setMessages($data);
        $data['stageInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_base_stage', array('StageID' => $id));
        $this->load->view('view_admin', $data);
    }

    public function detailEquipPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("ServerEquipDetail", "Admin");
        $data = $this->setMessages($data);
        $data['eqInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_base_equip', array('EquipmentStatsID' => $id));
        $statInfos = array();
        $baseStatsInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['eqInfo']->BaseStats));
        $baseGrowInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['eqInfo']->BaseStatsGrow));

        $statInfos[0] = array("type" => 0, "data" => $baseStatsInfo);
        $statInfos[1] = array("type" => 1, "data" => $baseGrowInfo);
        $starStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('data_id' => $id));
        foreach ($starStats as $stat) {
            $starInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $stat->stats_id));
            $statInfos[] = array("type" => 2, "data" => $starInfo);
        }
        $data['statInfos'] = $statInfos;

        $data['runeInfos'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_rune_requirement', array('eid' => $id));

        $this->load->view('view_admin', $data);
    }
    public function detailMonsterPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("ServerMonsterDetail", "Admin");
        $data = $this->setMessages($data);
        $data['mnInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_base_monster', array('MonsterID' => $id));
        $statInfos = array();
        $baseStatsInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['mnInfo']->BaseStats));
        $baseGrowInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats_grow', array('no' => $data['mnInfo']->BaseStatsGrow));

        $statInfos[0] = array("type" => 0, "data" => $baseStatsInfo);
        $statInfos[1] = array("type" => 1, "data" => $baseGrowInfo);

        $data['statInfos'] = $statInfos;
        $this->load->view('view_admin', $data);
    }
    public function detailCharacterPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("ServerCharacterDetail", "Admin");
        $data = $this->setMessages($data);
        $data['chInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_base_character', array('CharacterStatsID' => $id));
        $statInfos = array();
        $baseStatsInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['chInfo']->BaseStats));
        $baseGrowInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['chInfo']->BaseStatsGrow));
        $borderStatInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $data['chInfo']->BorderStats));

        $statInfos[0] = array("type" => 0, "data" => $baseStatsInfo);
        $statInfos[1] = array("type" => 1, "data" => $baseGrowInfo);
        $statInfos[2] = array("type" => 2, "data" => $borderStatInfo);
        $starStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('data_id' => $id));
        foreach ($starStats as $stat) {
            $starInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $stat->stats_id));
            $statInfos[] = array("type" => 3, "data" => $starInfo);
        }
        $data['statInfos'] = $statInfos;

        $this->load->view('view_admin', $data);
    }

    public function actionEditRune()
    {
        $postVars = $this->utils->inflatePost(array('edit_rune_id', 'edit_rune_quantity', 'edit_rune_eq_id', 'edit_rune_eq_no'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_rune_requirement', array(
            "RuneID" => $postVars['edit_rune_id'],
            "Quantity" => $postVars['edit_rune_quantity'],
            "eid" => $postVars['edit_rune_eq_id']
                ), array(
            "RuneID" => $postVars['edit_rune_id'],
            "eid" => $postVars['edit_rune_eq_id']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditStageInfo()
    {
        $postVars = $this->utils->inflatePost(array('stageRequirement', 'stageReward', 'stageMeat', 'stageEnemyWave', 'stageId','firstTimeReward','goldreward','playerExpReward','characterExpReward','tries'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_stage', array(
            "StageRequirement" => $postVars['stageRequirement'],
            "StageReward" => $postVars['stageReward'],
            "MeatRequirement" => $postVars['stageMeat'],
            "EnemyWavesDetail" => $postVars['stageEnemyWave'],
            "FirstTimeReward" => $postVars['firstTimeReward'],
            "GoldReward" => $postVars['goldreward'],
            "PlayerExpReward" => $postVars['playerExpReward'],
            "CharacterExpReward" => $postVars['characterExpReward'],
            "Tries" => $postVars['tries'],
                ), array(
            "StageID" => $postVars['stageId']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditStarstats()
    {
        $postVars = $this->utils->inflatePost(array('ch_edit_star_hp', 'ch_edit_star_damage', 'ch_edit_star_power', 'ch_edit_star_armor', 'ch_edit_star_speed', 'ch_edit_star_fire',
            'ch_edit_star_water', 'ch_edit_star_earth', 'ch_edit_star_light', 'ch_edit_star_dark', 'ch_edit_star_id', 'ch_edit_star_sid', 'ch_edit_star_type'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_stats', array(
            "HP" => $postVars['ch_edit_star_hp'],
            "Damage" => $postVars['ch_edit_star_damage'],
            "Power" => $postVars['ch_edit_star_power'],
            "Armor" => $postVars['ch_edit_star_armor'],
            "Speed" => $postVars['ch_edit_star_speed'],
            "ResistFire" => $postVars['ch_edit_star_fire'],
            "ResistWater" => $postVars['ch_edit_star_water'],
            "ResistEarth" => $postVars['ch_edit_star_earth'],
            "ResistLight" => $postVars['ch_edit_star_light'],
            "ResistDark" => $postVars['ch_edit_star_dark'],
                ), array(
            "no" => $postVars['ch_edit_star_sid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionAddRune()
    {
        $postVars = $this->utils->inflatePost(array('rune_id', 'rune_quantity', 'rune_eq_id'));
        $insertFields = array(
            "RuneID" => $postVars['rune_id'],
            "Quantity" => $postVars['rune_quantity'],
            "eid" => $postVars['rune_eq_id'],
        );
        $insert_id = $this->sqllibs->insertRow($this->db, 'tbl_base_rune_requirement', $insertFields);
        redirect($this->agent->referrer());
    }

    public function actionAddStarstat()
    {
        $postVars = $this->utils->inflatePost(array('ch_star_id', 'ch_star_hp', 'ch_star_damage', 'ch_star_power', 'ch_star_armor', 'ch_star_speed',
            'ch_star_fire', 'ch_star_water', 'ch_star_earth', 'ch_star_light', 'ch_star_dark', 'ch_star_type'));
        $insertFields = array(
            "HP" => $postVars['ch_star_hp'],
            "Damage" => $postVars['ch_star_damage'],
            "Power" => $postVars['ch_star_power'],
            "Armor" => $postVars['ch_star_armor'],
            "Speed" => $postVars['ch_star_speed'],
            "ResistFire" => $postVars['ch_star_fire'],
            "ResistWater" => $postVars['ch_star_water'],
            "ResistEarth" => $postVars['ch_star_earth'],
            "ResistLight" => $postVars['ch_star_light'],
            "ResistDark" => $postVars['ch_star_dark'],
        );
        $insert_id = $this->sqllibs->insertRow($this->db, 'tbl_base_stats', $insertFields);

        $this->sqllibs->insertRow($this->db, 'tbl_base_starstats', array(
            'type' => $postVars['ch_star_type'],
            'data_id' => $postVars['ch_star_id'],
            'stats_id' => $insert_id
        ));
        //$this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionDeleteMonster($id)
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_monster', array('MonsterID' => $id));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }
    public function actionDeleteStage($id)
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_stage', array('StageID' => $id));
        redirect($this->agent->referrer());
    }

    public function actionDeleteRune($id)
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_rune_requirement', array('RuneID' => $id));
        redirect($this->agent->referrer());
    }

    public function actionDeleteEquipment($id)
    {
        $equipInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type' => 1, 'data_id' => $id));
        foreach ($equipInfos as $eq) {
            $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $eq->stats_id));
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_equip', array('EquipmentStatsID' => $id));
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('type' => 1, 'data_id' => $id));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionDeleteCharacter($id)
    {
        $characterStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type' => 0, 'data_id' => $id));
        foreach ($characterStats as $character) {
            $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $character->stats_id));
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_character', array('CharacterStatsID' => $id));
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('data_id' => $id));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionDeleteEquip($id)
    {
        $eqStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type' => 1, 'data_id' => $id));
        foreach ($eqStats as $eqStat) {
            $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $eqStat->stats_id));
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_equip', array('EquipmentStatsID' => $id));
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('data_id' => $id));
        $this->sqllibs->deleteRow($this->db, 'tbl_base_rune_requirement', array('eid' => $id));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionDeleteStats($id)
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('stats_id' => $id));
        $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $id));
        redirect($this->agent->referrer());
    }
    public function actionUploadEquipDataJson()
    {
        $postVars = $this->utils->inflatePost(array('equipUserId'));
        $jsonFile = "";
        if (isset($_FILES['uploadEquip'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadEquip']);
        }
        //Parse Json file
        $arrayData = $this->jsonlibs->parseJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayData == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        $playerId = $postVars['equipUserId'];
        foreach ($arrayData as $equipData) {
            $in_datas = array(
            "EquipmentStatsID" => $equipData['EquipmentStatsID'],
            "CharacterID" => $equipData['CharacterID'],
            "Star" => $equipData['Star'],
            "SkillLevel" => $equipData['SkillLevel'],
            "Level" => $equipData['Level'],
            "CurrentExp" => $equipData['EXP'],
            "TotalExp" => $equipData['TotalExp']
            );

            if ($this->sqllibs->isExist($this->db, 'tbl_user_equip', array('EquipmentID' => $equipData['EquipmentID']))) {
                $this->sqllibs->updateRow($this->db, 'tbl_user_equip', $in_datas, array('EquipmentID' => $equipData['EquipmentID']));
            } else {
                $in_datas['EquipmentID'] = $equipData['EquipmentID'];
                $in_datas['PlayerID'] = $playerId;
                $this->sqllibs->insertRow($this->db, 'tbl_user_equip', $in_datas);
            }
        }
        $result['result'] = 200;
        echo json_encode($result);
        return;
    }

    public function actionUploadCharacterDataJson()
    {
        $postVars = $this->utils->inflatePost(array('characterUserId'));
        $jsonFile = "";
        if (isset($_FILES['uploadCharacter'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadCharacter']);
        }
        //Parse Json file
        $arrayData = $this->jsonlibs->parseJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayData == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        $playerId = $postVars['characterUserId'];
        foreach ($arrayData as $characterData) {
            $in_datas = array(
            "cid" => $characterData['CharacterStatsID'],
            "exp" => $characterData['EXP'],
            "star" => $characterData['Star'],
            "border" => $characterData['Border'],
            "total_exp" => $characterData['TotalExp'],
            "level" => $characterData['Level'],
            "equip1" => $characterData['EquipmentSlot1'],
            "equip2" => $characterData['EquipmentSlot2'],
            "equip3" => $characterData['EquipmentSlot3'],
            );

            if ($this->sqllibs->isExist($this->db, 'tbl_user_character', array('no' => $characterData['CharacterID'], 'uid' => $playerId ))) {
                $this->sqllibs->updateRow($this->db, 'tbl_user_character', $in_datas, array("uid" => $playerId), array('no' => $characterData['CharacterID'], 'uid' => $playerId));
            } else {
                $in_datas['no'] = $characterData['CharacterID'];
                $in_datas['uid'] = $playerId;
                $this->sqllibs->insertRow($this->db, 'tbl_user_character', $in_datas);
            }
        }
        $result['result'] = 200;
        echo json_encode($result);
        return;
    }
    public function actionUploadCurrencyJson()
    {
        $postVars = $this->utils->inflatePost(array('currencyUserId'));
        $jsonFile = "";
        if (isset($_FILES['uploadCurrency'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadCurrency']);
        }

        //Parse Json file
        $arrayData = $this->jsonlibs->parseJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayData == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        $playerId = $postVars['currencyUserId'];
        $allCurrency = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');

        foreach ($arrayData as $key => $value) {
            $flag = 0;
            foreach ($allCurrency as $currency) {
                if ($currency->name == $key) {
                    $flag = 1;
                    $in_datas = array();
                    $in_datas['amount'] = $value;
                    if ($this->sqllibs->isExist($this->db, 'tbl_user_currency', array('cid' => $currency->no, 'uid' => $playerId ))) {
                        $this->sqllibs->updateRow($this->db, 'tbl_user_currency', $in_datas, array('cid' => $currency->no, 'uid' => $playerId ));
                    } else {
                        $in_datas['uid'] = $playerId;
                        $in_datas['cid'] = $currency->no;
                        $this->sqllibs->insertRow($this->db, 'tbl_user_currency', $in_datas);
                    }
                }
            }
        }
        $result['result'] = 200;
        echo json_encode($result);
        return;
    }
    public function actionUploadPlayerJson()
    {
        $postVars = $this->utils->inflatePost(array('accountUserId'));
        $jsonFile = "";
        if (isset($_FILES['uploadPlayer'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadPlayer']);
        }

        //Parse Json file
        $arrayData = $this->jsonlibs->parseJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayData == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        $playerId = $postVars['accountUserId'];

        $in_datas = array(
        "PlayerName" => $arrayData['PlayerName'],
        "PlayerLevel" => $arrayData['PlayerLevel'],
        "PlayerCurrentExp" => $arrayData['PlayerEXP'],
        "PlayerTotalExp" => $arrayData['PlayerTotalEXP'],
        "Type" => $arrayData['RegisterType'],
        "SocialID" => $arrayData['SocialID'],
        "DeviceID" => $arrayData['DeviceID'],
        "CreationTime" => $arrayData['CreateTime'],
        "LastLogin" => $arrayData['LastLogin'],
        "BasicGashaClaim" => $arrayData['BaseGashaClaimed'],
        "PremiumGashaClaimed" => $arrayData['PremiumGashaClaimed'],
        "TutorialState" => $arrayData['TutorialState'],
        );
        $this->sqllibs->updateRow($this->db, 'tbl_user', $in_datas, array(
          "PlayerID" => $playerId
        ));
        $result['result'] = 200;
        echo json_encode($result);
        return;
    }
    public function actionUploadStageJson()
    {
        $jsonFile = "";
        if (isset($_FILES['uploadStage'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadStage']);
        }

        //Parse Json file
        $arrayStages = $this->jsonlibs->parseEquipJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayStages == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }

        foreach ($arrayStages as $arrayData) {
            $in_datas = array(
              "StageRequirement" => json_encode($arrayData['StageRequirement']),
              "FirstTimeReward" => $arrayData['FirstTimeReward'],
              "StageReward" => json_encode($arrayData['StageReward']),
              "GoldReward" => $arrayData['GoldReward'],
              "PlayerExpReward" => $arrayData['PlayerExpReward'],
              "CharacterExpReward" => $arrayData['CharacterExpReward'],
              "MeatRequirement" => $arrayData['MeatRequirement'],
              "EnemyWavesDetail" => json_encode($arrayData['EnemyWavesDetail']),
              "StageID" => $arrayData['StageID'],
              "Tries" => $arrayData['Tries'],
          );
            $this->sqllibs->insertRow($this->db, 'tbl_base_stage', $in_datas);
        }
        $result['result'] = 200;
        echo json_encode($result);
    }

    public function actionUploadEquipJson()
    {
        $jsonFile = "";
        if (isset($_FILES['uploadEquip'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadEquip']);
        }
        //Parse Json file
        $arrayEquips = $this->jsonlibs->parseEquipJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayEquips == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        foreach ($arrayEquips as $arrayData) {
            //Insert BaseStats
            $baseStatsId = $this->insertStatsTable($arrayData['BaseStats']);
            $baseStatsGrowId = $this->insertStatsTable($arrayData['BaseStatsGrow']);
            $statsIds = array();

            foreach ($arrayData['StarStats'] as $starStats) {
                $statsIds[] = $this->insertStatsTable($starStats);
            }
            $in_datas = array(
              "Name" => $arrayData['Name'],
              "Description" => $arrayData['Description'],
              "Cost" => $arrayData['Cost'],
              "BaseStats" => $baseStatsId,
              "BaseStatsGrow" => $baseStatsGrowId,
              "Skill" => json_encode($arrayData['Skill']),
              "SkillDescription" => $arrayData['SkillDescription'],
              "SkillTNL" => json_encode($arrayData['SkillTNL']),
              "StarStats" => json_encode($statsIds),
          );
            if ($this->sqllibs->isExist($this->db, 'tbl_base_equip', array('EquipmentStatsID' => $arrayData['EquipmentStatsID']))) {
                $this->sqllibs->updateRow($this->db, 'tbl_base_equip', $in_datas, array('EquipmentStatsID',$arrayData['EquipmentStatsID']));
            } else {
                $in_datas['EquipmentStatsID'] = $arrayData['EquipmentStatsID'];
                $this->sqllibs->insertRow($this->db, 'tbl_base_equip', $in_datas);
            }
            //Insert StarStats
            $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('type' => 1,'data_id' => $arrayData['EquipmentStatsID']));
            foreach ($statsIds as $starId) {
                $this->sqllibs->insertRow($this->db, 'tbl_base_starstats', array(
                  "type" => 1,
                  "data_id" => $arrayData['EquipmentStatsID'],
                  "stats_id" => $starId
              ));
            }
            //Insert Rune
            $this->sqllibs->deleteRow($this->db, 'tbl_base_rune_requirement', array('eid' => $arrayData['EquipmentStatsID']));
            foreach ($arrayData['StarRuneRequirement'] as $rune) {
                $this->sqllibs->insertRow($this->db, 'tbl_base_rune_requirement', array(
                  "eid" => $arrayData['EquipmentStatsID'],
                  "RuneID" => $rune['RuneID'],
                  "Quantity" => $rune['Quantity']
              ));
            }
        }
        $result['result'] = 200;
        echo json_encode($result);
    }
    public function actionUploadGlobalJson()
    {
        $jsonFile = "";
        if (isset($_FILES['uploadGlobal'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadGlobal']);
        }
        //Parse Json file
        $arrayData = $this->jsonlibs->parseCharacterJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayData == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }

        $in_datas = array(
          "ServerVersion" => $arrayData['ServerVersion'],
          "ClientVersion" => $arrayData['ClientVersion'],
          "DailyServerReset" => $arrayData['DailyServerReset'],
          "MeatRechargeRate" => $arrayData['MeatRechargeRate'],
          "BasePvpTicket" => $arrayData['BasePvpTicket'],
          "PlayerExpTNL" => json_encode($arrayData['PlayerExpTNL']),
          "PvPReset" => $arrayData['PvPReset'],
          "PlayerLevelCap" => $arrayData['PlayerLevelCap'],
          "CharacterLevelCap" => $arrayData['CharacterLevelCap'],
          "GulidLevelCap" => $arrayData['GulidLevelCap'],
          "FreeBasicGashaReset" => $arrayData['FreeBasicGashaReset'],
          "FreePremiumGashaReset" => $arrayData['FreePremiumGashaReset']
        );
        $datas = $this->sqllibs->selectAllRows($this->db, 'tbl_base_global');
        if (count($datas) > 0) {
            $this->sqllibs->updateRow($this->db, 'tbl_base_global', $in_datas, array('no' => 1));
        } else {
            $this->sqllibs->insertRow($this->db, 'tbl_base_global', $in_datas);
        }
        $result['result'] = 200;
        echo json_encode($result);
    }

    public function actionUploadMonsterJson()
    {
        $jsonFile = "";
        if (isset($_FILES['uploadMonster'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadMonster']);
        }
        //Parse Json file
        $arrayMonsters = $this->jsonlibs->parseCharacterJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayMonsters == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        foreach ($arrayMonsters as $arrayData) {
            //Insert BaseStats
            $baseStatsId = $this->insertStatsTable($arrayData['BaseStats']);
            $baseStatsGrowId = $this->insertStatsGrowTable($arrayData['BaseStatsGrow']);

            $in_datas = array(
            "Name" => $arrayData['Name'],
            "Description" => $arrayData['Description'],
            "Type" => $arrayData['Type'],
            "BaseStats" => $baseStatsId,
            "BaseStatsGrow" => $baseStatsGrowId,
            "Skill1" => json_encode($arrayData['Skill1']),
            "Skill2" => json_encode($arrayData['Skill2']),
            "Skill3" => json_encode($arrayData['Skill3']),
            "Skill4" => json_encode($arrayData['Skill4'])
            );
            if ($this->sqllibs->isExist($this->db, 'tbl_base_monster', array('MonsterID' => $arrayData['MonsterID']))) {
                $this->sqllibs->updateRow($this->db, 'tbl_base_monster', $in_datas, array('monster_id'=> $arrayData['MonsterID']));
            } else {
                $in_datas['MonsterID'] = $arrayData['MonsterID'];
                $this->sqllibs->insertRow($this->db, 'tbl_base_monster', $in_datas);
            }
        }
        $result['result'] = 200;
        echo json_encode($result);
    }
    public function actionUploadCharacterJson()
    {
        $jsonFile = "";
        if (isset($_FILES['uploadCharacter'])) {
            $jsonFile = $this->utils->uploadFile($_FILES['uploadCharacter']);
        }
        //Parse Json file
        $arrayCharacters = $this->jsonlibs->parseCharacterJson(base_url() . $jsonFile);
        $result = array();
        if ($arrayCharacters == false) {
            $result['result'] = 400;
            echo json_encode($result);
            return;
        }
        foreach ($arrayCharacters as $arrayData) {
            //Insert BaseStats
            $baseStatsId = $this->insertStatsTable($arrayData['BaseStats']);
            $baseStatsGrowId = $this->insertStatsTable($arrayData['BaseStatsGrow']);
            $borderStatsId = $this->insertStatsTable($arrayData['BorderStats']);
            $statsIds = array();
            foreach ($arrayData['StarStats'] as $starStats) {
                $statsIds[] = $this->insertStatsTable($starStats);
            }
            $in_datas = array(
              "Name" => $arrayData['Name'],
              "Description" => $arrayData['Description'],
              "Role" => $arrayData['Role'],
              "BaseStats" => $baseStatsId,
              "BaseStatsGrow" => $baseStatsGrowId,
              "BorderStats" => $borderStatsId,
              "SoulshardTNL" => json_encode($arrayData['SoulShardTNL']),
              "BorderRequirement" => json_encode($arrayData['BorderRequirement']),
              "Skill" => json_encode($arrayData['Skill']),
              "Passive" => json_encode($arrayData['Passive']),
              "LeaderSkill" => json_encode($arrayData['LeaderSkill']),
              "StarStats" => json_encode($statsIds)
          );
            if ($this->sqllibs->isExist($this->db, 'tbl_base_character', array('CharacterStatsID' => $arrayData['CharacterStatsID']))) {
                $this->sqllibs->updateRow($this->db, 'tbl_base_character', $in_datas, array('CharacterStatsID',$arrayData['CharacterStatsID']));
            } else {
                $in_datas['CharacterStatsID'] = $arrayData['CharacterStatsID'];
                $this->sqllibs->insertRow($this->db, 'tbl_base_character', $in_datas);
            }

            //Insert StarStats
            $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('type' => 0,'data_id' => $arrayData['CharacterStatsID']));
            foreach ($statsIds as $starId) {
                $this->sqllibs->insertRow($this->db, 'tbl_base_starstats', array(
                  "type" => 0,
                  "data_id" => $arrayData['CharacterStatsID'],
                  "stats_id" => $starId
              ));
            }
        }

        $result['result'] = 200;
        echo json_encode($result);
    }
    public function actionEditGlobalData()
    {
        $postVars = $this->utils->inflatePost(array('edit_global_sversion', 'edit_global_cversion', 'edit_global_dailyreset', 'edit_global_meatrate',
        'edit_global_pvp', 'edit_global_playerexp', 'edit_global_pvpreset', 'edit_global_levelcap', 'edit_global_clevelcap', 'edit_global_glevelcap',
        'edit_global_base_gashareset','edit_global_pre_gashareset'));

        $in_datas = array(
          "ServerVersion" => $postVars['edit_global_sversion'],
          "ClientVersion" => $postVars['edit_global_cversion'],
          "DailyServerReset" => $postVars['edit_global_dailyreset'],
          "MeatRechargeRate" => $postVars['edit_global_meatrate'],
          "BasePvPTicketCap" => $postVars['edit_global_pvp'],
          "PlayerExpTNL" => $postVars['edit_global_playerexp'],
          "PvPReset" => $postVars['edit_global_pvpreset'],
          "PlayerLevelCap" => $postVars['edit_global_levelcap'],
          "CharacterLevelCap" => $postVars['edit_global_clevelcap'],
          "GulidLevelCap" => $postVars['edit_global_glevelcap'],
          "FreeBasicGashaReset" => $postVars['edit_global_base_gashareset'],
          "FreePremiumGashaReset" => $postVars['edit_global_pre_gashareset']
        );
        $this->sqllibs->updateRow($this->db, 'tbl_base_global', $in_datas, array('no' => 1));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }
    public function actionEditMonsterSkill()
    {
        $postVars = $this->utils->inflatePost(array('mnIdSkill','mnSkill1', 'mnSkill2', 'mnSkill3', 'mnSkill4'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_monster', array(
          "Skill1" => $postVars['mnSkill1'],
          "Skill2" => $postVars['mnSkill2'],
          "Skill3" => $postVars['mnSkill3'],
          "Skill4" => $postVars['mnSkill4']
              ), array(
          "MonsterID" => $postVars['mnIdSkill']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }
    public function actionEditCharacterSkill()
    {
        $postVars = $this->utils->inflatePost(array('chIdSkill', 'chSkill'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_character', array(
            "skill" => $postVars['chSkill'],
                ), array(
            "ch_id" => $postVars['chIdSkill']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditEquipSkill()
    {
        $postVars = $this->utils->inflatePost(array('eqIdSkill', 'eqSkill'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_equip', array(
            "Skill" => $postVars['eqSkill'],
                ), array(
            "EquipmentStatsID" => $postVars['eqIdSkill']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }
    public function actionEditMonsterInfo()
    {
        $postVars = $this->utils->inflatePost(array('mnId', 'mnName', 'mnType', 'mnDesc'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_monster', array(
          "Name" => $postVars['mnName'],
          "Type" => $postVars['mnType'],
          "Description" => $postVars['mnDesc']
              ), array(
          "MonsterID" => $postVars['mnId']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }
    public function actionEditCharacterInfo()
    {
        $postVars = $this->utils->inflatePost(array('chId', 'chName', 'chRole','chSoul', 'chDesc','chBorderReq'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_character', array(
            "Name" => $postVars['chName'],
            "Description" => $postVars['chDesc'],
            "Role" => $postVars['chRole'],
            "BorderRequirement"=> $postVars['chBorderReq'],
            "SoulshardTNL" => $postVars['chSoul'],
                ), array(
            "CharacterStatsID" => $postVars['chId']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditEquipInfo()
    {
        $postVars = $this->utils->inflatePost(array('eqId', 'eqName', 'eqCost','eqDesc', 'eqSkillDesc'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_equip', array(
            "Name" => $postVars['eqName'],
            "Cost" => $postVars['eqCost'],
            "Description" => $postVars['eqDesc'],
            "SkillDescription" => $postVars['eqSkillDesc'],
                ), array(
            "EquipmentStatsID" => $postVars['eqId']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }
    public function actionClearMonsterData()
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_monster');
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }
    public function actionClearStageData()
    {
        $this->sqllibs->deleteRow($this->db, 'tbl_base_stage');
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionClearCharacterData()
    {
        $characterStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type' => 0));
        foreach ($characterStats as $character) {
            $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $character->stats_id));
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_character');
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('type' => 0));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionClearEquipData()
    {
        $eqStats = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type' => 1));
        foreach ($eqStats as $eqStat) {
            $this->sqllibs->deleteRow($this->db, 'tbl_base_stats', array('no' => $eqStat->stats_id));
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_equip');
        $this->sqllibs->deleteRow($this->db, 'tbl_base_rune_requirement');
        $this->sqllibs->deleteRow($this->db, 'tbl_base_starstats', array('type' => 1));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }
}
