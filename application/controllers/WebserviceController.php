<?php

header('Content-Type: application/json');
defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class WebserviceController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function makeFailResponse() {
        $channel = array();
        $channel["response"] = 400;
        echo json_encode($channel, JSON_NUMERIC_CHECK);
    }

    public function makeSuccessResponse() {
        $channel = array();
        $channel["response"] = 200;
        echo json_encode($channel, JSON_NUMERIC_CHECK);
    }

    public function login() {
        $postVars = $this->utils->inflatePost(array('email', 'password'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $result = array();
        if ($this->sqllibs->isExist($this->db, 'tbl_user', array("Email" => $postVars['email'], "Password" => $postVars['password']))) {
            $userData = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
                "Email" => $postVars['email'],
                "Password" => $postVars['password']
            ));
            unset($userData->password);
            $result['user'] = $userData;
            $result['result'] = 200;
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $result['result'] = 400;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function register() {
        $postVars = $this->utils->inflatePost(array('name', 'email', 'password', 'device_type'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if ($this->sqllibs->isExist($this->db, 'tbl_user', array("Email" => trim($postVars['email'])))) {
            $result['result'] = 400;
            $result['message'] = "Email already registered";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $now = new DateTime();
        $now->format('Y-m-d H:i:s');    // MySQL datetime format
        $timestamp = $now->getTimestamp();

        $id = $this->sqllibs->insertRow($this->db, 'tbl_user', array(
            "PlayerName" => $postVars['name'],
            "Email" => $postVars['email'],
            "Password" => $postVars['password'],
            "DeviceType" => $postVars['device_type'],
            "CreationTime" => $timestamp,
            "PlayerLevel" => 1,
            "PlayerTotalExp" => 0,
            "BasicGashaClaim" => 0,
            "TutorialState" => 0,
            "PremiumGashaClaimed" => 0,
        ));
        $userData = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
            "PlayerID" => $id,
        ));

        //Create Default 4 Character
        $baseStarter = $this->sqllibs->getOneRow($this->db, 'tbl_base_starters_param', array("no" => 1));
        $defaultChIds = json_decode($baseStarter->CharacterIDs);
        $partyIds = array();
        foreach ($defaultChIds as $chId) {
            $createdId = $this->sqllibs->insertRow($this->db, 'tbl_user_character', array(
                "CharacterStatsID" => $chId,
                "PlayerID" => $id,
                "CurrentExp" => 0,
                "Star" => 1,
                "Border" => 0,
                "TotalExp" => 0,
                "Level" => 1,
                "Equipment1" => "",
                "Equipment2" => "",
                "Equipment3" => ""
            ));
            $partyIds[] = $createdId;
        }
        $defaultEquips = json_decode($baseStarter->EquipmentIDs);
        foreach ($defaultEquips as $eqId) {
            $createdId = $this->sqllibs->insertRow($this->db, 'tbl_user_equip', array(
                "EquipmentStatsID" => $eqId,
                "PlayerID" => $id,
                "Level" => 1,
                "Star" => 1,
                "SkillLevel" => 1,
                "CurrentExp" => 0,
                "TotalExp" => 0,
                "TotalSkillExp" => 0
            ));
        }
        //Set Meat Gold,Gem
        $meatId = $this->sqllibs->insertRow($this->db, 'tbl_user_currency', array(
            "uid" => $id, "cid" => 1, "amount" => $baseStarter->Meat
        ));
        $goldId = $this->sqllibs->insertRow($this->db, 'tbl_user_currency', array(
            "uid" => $id, "cid" => 2, "amount" => $baseStarter->Gold
        ));
        $gemId = $this->sqllibs->insertRow($this->db, 'tbl_user_currency', array(
            "uid" => $id, "cid" => 4, "amount" => $baseStarter->Gem
        ));

        //Create Random Chracter
        $randomInfo = $this->sqllibs->rawSelectSql($this->db, "SELECT * FROM tbl_base_tut_character_pool ORDER BY RAND() % 3 LIMIT 1");
        $createdId = $this->sqllibs->insertRow($this->db, 'tbl_user_character', array(
            "CharacterStatsID" => $randomInfo[0]->CharacterID,
            "PlayerID" => $id,
            "CurrentExp" => 0,
            "Star" => 1,
            "Border" => 0,
            "TotalExp" => 0,
            "Level" => 1,
            "Equipment1" => "",
            "Equipment2" => "",
            "Equipment3" => ""
        ));
        $partyIds[] = $createdId;

        $userData->Party = json_encode($partyIds, JSON_NUMERIC_CHECK);
        $this->sqllibs->updateRow($this->db, 'tbl_user', array(
            "Party" => $userData->Party,
                ), array(
            "PlayerID" => $userData->PlayerID));

        $result = array();
        unset($userData->Password);
        $result['user'] = $userData;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function registerFacebook() {
        $postVars = $this->utils->inflatePost(array('name', 'email', 'device_type', 'image'));
        if ($this->sqllibs->isExist($this->db, 'tbl_user', array("Email" => $postVars['email'], "Type" => 1))) {
            $userData = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
                "Email" => $postVars['email'],
                "Type" => 1
            ));
        } else {
            $id = $this->sqllibs->insertRow($this->db, 'tbl_user', array(
                "PlayerName" => $postVars['name'],
                "Email" => $postVars['email'],
                "Type" => 1,
                "DeviceType" => $postVars['device_type'],
            ));
            $userData = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
                "PlayerID" => $id,
            ));
        }
        $result = array();
        $result['user'] = $userData;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getAllPlayers() {
        $result = array();
        $users = $this->sqllibs->selectAllRows($this->db, 'tbl_user');
        $userArray = array();
        foreach ($users as $user) {
            $userInfo = array();
            $userInfo['account'] = $user;
            $currency = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as currency from tbl_user_currency as A left join tbl_base_currency as B on A.cid=B.no where A.uid='" . $user->no . "'");
            $characterInfos = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_character as A "
                    . "left join tbl_base_character as B on A.cid=B.ch_id "
                    . "where A.uid='" . $user->no . "'");
            $eqInfos = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_equip as A "
                    . "left join tbl_base_equip as B on A.eid=B.eq_id "
                    . "where A.uid='" . $user->no . "'");
            $pvpInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_user_pvp', array('uid' => $user->no));
            $userInfo['currency'] = $currency;
            $userInfo['character'] = $characterInfos;
            $userInfo['equip'] = $eqInfos;
            $userInfo['pvp'] = $pvpInfos;
            $userArray[] = $userInfo;
        }
        $result['users'] = $userArray;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getPlayerInfo() {
        $postVars = $this->utils->inflatePost(array('uid'));
        $userInfo = array();
        $user = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $postVars['uid']));
        $userInfo['account'] = $user;
        $currency = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as currency from tbl_user_currency as A left join tbl_base_currency as B on A.cid=B.no where A.uid='" . $user->PlayerID . "'");
        $characterInfos = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_character as A "
                . "left join tbl_base_character as B on A.CharacterStatsID=B.CharacterStatsID "
                . "where A.PlayerID='" . $postVars['uid'] . "'");
        $eqInfos = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_equip as A "
                . "left join tbl_base_equip as B on A.EquipmentStatsID=B.EquipmentStatsID "
                . "where A.PlayerID='" . $postVars['uid'] . "'");
        $pvpInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_user_pvp', array('PlayerID' => $postVars['uid']));
        $stageInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_user_stage', array('PlayerID' => $postVars['uid']));
        $inventoryInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_user_inventory', array('PlayerID' => $postVars['uid']));
        $userInfo['currency'] = $currency;
        $userInfo['character'] = $characterInfos;
        $userInfo['equip'] = $eqInfos;
        $userInfo['pvp'] = $pvpInfos;
        $userInfo['stage'] = $stageInfos;
        $userInfo['inventory'] = $inventoryInfos;
        $result['users'] = $userInfo;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function preBattleService() {
        $result = array();
        $postVars = $this->utils->inflatePost(array('userId', 'characterIds', 'stageId'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $stageInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stage', array("StageID" => $postVars['stageId']));
        $userMeat = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array("uid" => $postVars['userId'], "cid" => 1));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array("PlayerID" => $postVars['userId']));
        $stageProgressionInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_stage', array("StageID" => $postVars['stageId'], "PlayerID" => $postVars['userId']));

        $requireStages = json_decode($stageInfo->StageRequirement);
        $isStageClear = false;
        $clearStages = json_decode($userInfo->StageProgression);
        if ($requireStages == null || count($requireStages) == 0) {
            $isStageClear = true;
        } else if ($clearStages != null && count(array_intersect($requireStages, $clearStages)) == count($requireStages)) {
            $isStageClear = true;
        }
        if (!$isStageClear) {
            $result['message'] = "Require Stages are not clear.";
            $result['result'] = 400;
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if ($userMeat->amount > $stageInfo->MeatRequirement) {
            $triesNumber = 0;
            if ($stageProgressionInfo != null) {
                $triesNumber = $stageProgressionInfo->DailyTries;
                $date = new DateTime();
                $currentTimeStamp = $date->getTimestamp();
                if ($stageProgressionInfo->Last_Try_Day_Timestamp + 24 * 3600 < $currentTimeStamp) {
                    $triesNumber = 0;
                }
            }
            if ($stageInfo->Tries > $triesNumber) {

//Verify Character With Player ID
                $arrayCharacter = json_decode($postVars['characterIds']);
                foreach ($arrayCharacter as $cid) {
                    if (!$this->sqllibs->isExist($this->db, 'tbl_user_character', array('PlayerID' => $postVars['userId'], 'CharacterID' => $cid))) {
                        $result['message'] = "Invalid Character Ids";
                        $result['result'] = 400;
                        echo json_encode($result, JSON_NUMERIC_CHECK);
                        return;
                    }
                }
            } else {
                $result['message'] = "Player tried over limit";
                $result['result'] = 400;
            }
//
            $stageProgressionJson = $userInfo->StageProgression;
            $this->sqllibs->updateRow($this->db, 'tbl_user', array(
                "Party" => $postVars['characterIds'],
                    ), array(
                "PlayerID" => $userInfo->PlayerID));
//Minus
            $date = new DateTime();
            $date->setTime(0, 0, 0);
            $timeStamp = $date->getTimestamp();
            if ($stageProgressionInfo == null) {
                $this->sqllibs->insertRow($this->db, 'tbl_user_stage', array(
                    "StageID" => $postVars['stageId'],
                    "StarAcquired" => 0,
                    "TriesNumber" => 1,
                    "DailyTries" => 1,
                    "Last_Try_Day_Timestamp" => $timeStamp,
                    "PlayerID" => $userInfo->PlayerID
                ));
            } else {
                $tryNumber = $stageProgressionInfo->TriesNumber + 1;
                $triesNumber++;
                $this->sqllibs->updateRow($this->db, 'tbl_user_stage', array(
                    "TriesNumber" => $tryNumber,
                    "DailyTries" => $triesNumber,
                    "Last_Try_Day_Timestamp" => $timeStamp
                        ), array(
                    "StageProgressionID" => $stageProgressionInfo->StageProgressionID));
            }
            $meat = $userMeat->amount - $stageInfo->MeatRequirement;
            $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                "amount" => $meat,
                    ), array(
                "no" => $userMeat->no));
            $ids = json_decode($postVars['characterIds']);
            $characterArray = array();
            foreach ($ids as $id) {
                $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array("CharacterID" => $id));
                $ch = $this->sqllibs->getOneRow($this->db, "tbl_base_character", array("CharacterStatsID" => $chInfo->CharacterStatsID));
                $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStats));
                $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStatsGrow));
                $border = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BorderStats));
                $starIds = json_decode($ch->StarStats);
                $starArray = array();
                foreach ($starIds as $starInfo) {
                    $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo));
                    $starArray[] = $stInfo;
                }
                $extended = (object) array_merge((array) $ch, array(
                            'BaseStats' => $baseState,
                            'BaseStatsGrow' => $baseGrow,
                            'BorderStats' => $border,
                            'StarStats' => $starArray,
                ));
                $chInfo->CharacterStats = $extended;
                $characterArray[] = $chInfo;
            }
            $result['characters'] = $characterArray;
            $result['result'] = 200;
        } else {
            $result['message'] = "Player's meat is not enough";
            $result['result'] = 400;
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function postBattleService() {
        $postVars = $this->utils->inflatePost(array('userId', 'stageId', 'star'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }

        $stageProgressionInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_stage', array("StageID" => $postVars['stageId'], "PlayerID" => $postVars['userId']));
        $baseData = $this->sqllibs->getOneRow($this->db, 'tbl_base_stage', array("StageID" => $postVars['stageId']));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array("PlayerID" => $postVars['userId']));
        if ($baseData == null || $userInfo == null) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }

        if ($stageProgressionInfo == null) {
            $date = new DateTime();
            $date->setTime(0, 0, 0);
            $timeStamp = $date->getTimestamp();
            $this->sqllibs->insertRow($this->db, 'tbl_user_stage', array(
                "PlayerID" => $postVars['userId'],
                "StageID" => $postVars['stageId'],
                "StarAcquired" => $postVars['star'],
                "TriesNumber" => 1,
                "DailyTries"=>1,
                "Last_Try_Day_Timestamp" => $timeStamp
            ));
        } else {
            $this->sqllibs->updateRow($this->db, 'tbl_user_stage', array(
                "StarAcquired" => $postVars['star'],
                    ), array(
                "StageProgressionID" => $stageProgressionInfo->StageProgressionID));
        }
        //Add Experience
        $userInfo->PlayerCurrentExp = $userInfo->PlayerCurrentExp + $baseData->PlayerExpReward;
        $userInfo->PlayerTotalExp = $userInfo->PlayerTotalExp + $baseData->PlayerExpReward;
        $this->sqllibs->updateRow($this->db, 'tbl_user', array(
            "PlayerCurrentExp" => $userInfo->PlayerCurrentExp,
            "PlayerTotalExp" => $userInfo->PlayerTotalExp,
                ), array(
            "PlayerID" => $postVars['userId']));

        $this->updatePlayerLevel($postVars['userId']);
        //Add Character Experience
        $characterIds = json_decode($userInfo->Party);
        foreach($characterIds as $chId)
        {
            $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array("CharacterID" => $chId));
            $chInfo->CurrentExp = $chInfo->CurrentExp + $baseData->CharacterExpReward;
            $chInfo->TotalExp = $chInfo->TotalExp + $baseData->CharacterExpReward;
            $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
                "CurrentExp" => $chInfo->CurrentExp,
                "TotalExp" => $chInfo->TotalExp,
                    ), array(
                "CharacterID" => $chId));
                $this->updateCharacterLevel($chId);
        }
        $result = array();
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getBaseServerData() {
        $postVars = $this->utils->inflatePost(array('type'));
        $data = array();
        switch ($postVars['type']) {
            case "global":
                $global = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
                $data['datas'] = $global;
                break;
            case "stage":
                $stage = $this->sqllibs->selectAllRows($this->db, 'tbl_base_stage');
                $data['datas'] = $stage;
                break;
            case "monster":
                $characters = $this->sqllibs->selectAllRows($this->db, "tbl_base_monster");
                $characterArray = array();
                foreach ($characters as $ch) {
                    $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStats));
                    $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats_grow', array("no" => $ch->BaseStatsGrow));
                    $extended = (object) array_merge((array) $ch, array(
                                'BaseStats' => $baseState,
                                'BaseStatsGrow' => $baseGrow
                    ));
                    $characterArray[] = $extended;
                }
                $data['datas'] = $characterArray;
                break;
            case "character":
                $characters = $this->sqllibs->selectAllRows($this->db, "tbl_base_character");
                $characterArray = array();
                foreach ($characters as $ch) {
                    $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStats));
                    $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStatsGrow));
                    $border = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BorderStats));
                    $starIds = json_decode($ch->StarStats);
                    $starArray = array();
                    foreach ($starIds as $starInfo) {
                        $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo));
                        $starArray[] = $stInfo;
                    }
                    $extended = (object) array_merge((array) $ch, array(
                                'BaseStats' => $baseState,
                                'BaseStatsGrow' => $baseGrow,
                                'BorderStats' => $border,
                                'StarStats' => $starArray,
                    ));
                    $characterArray[] = $extended;
                }
                $data['datas'] = $characterArray;
                break;
            case "equip":
                $equips = $this->sqllibs->selectAllRows($this->db, "tbl_base_equip");
                $equipArray = array();
                foreach ($equips as $eq) {
                    $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->BaseStats));
                    $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->BaseStatsGrow));
                    $starIds = json_decode($eq->StarStats);
                    $starArray = array();
                    foreach ($starIds as $starInfo) {
                        $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo));
                        $starArray[] = $stInfo;
                    }
                    $extended = (object) array_merge((array) $eq, array(
                                'BaseStats' => $baseState,
                                'BaseStatsGrow' => $baseGrow,
                                'StarStats' => $starArray,
                    ));
                    $equipArray[] = $extended;
                }
                $data['datas'] = $equipArray;
                break;
            case "character_skill":
                $skills = $this->sqllibs->selectAllRows($this->db, "tbl_base_character_skill");
                $data['datas'] = $skills;
                break;
            case "equip_skill":
                $skills = $this->sqllibs->selectAllRows($this->db, "tbl_base_equip_skill");
                $data['datas'] = $skills;
                break;
            case "gashapon":
                $gashapons = $this->sqllibs->selectAllRows($this->db, "tbl_base_gashapon");
                $data['datas'] = $gashapons;
                break;
            case "orb":
                $orbs = $this->sqllibs->selectAllRows($this->db, "tbl_base_orb_requirement");
                $data['datas'] = $orbs;
                break;
        }
        $data['result'] = 200;
        echo json_encode($data, JSON_NUMERIC_CHECK);
    }

    public function getAllServerData() {
        $postVars = $this->utils->inflatePost(array('uid'));
        $data = array();

        $global = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $stage = $this->sqllibs->selectAllRows($this->db, 'tbl_base_stage');
        $characters = $this->sqllibs->selectAllRows($this->db, "tbl_base_character");
        $equips = $this->sqllibs->selectAllRows($this->db, "tbl_base_equip");
        $characterArray = array();
        foreach ($characters as $ch) {
            $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStats));
            $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BaseStatsGrow));
            $border = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->BorderStats));
            $starIds = json_decode($ch->StarStats);
            $starArray = array();
            foreach ($starIds as $starInfo) {
                $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo));
                $starArray[] = $stInfo;
            }
            $extended = (object) array_merge((array) $ch, array(
                        'BaseStats' => $baseState,
                        'BaseStatsGrow' => $baseGrow,
                        'BorderStats' => $border,
                        'StarStats' => $starArray,
            ));
            $characterArray[] = $extended;
        }
        $equipArray = array();
        foreach ($equips as $eq) {
            $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->BaseStats));
            $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->BaseStatsGrow));
            $starIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array("data_id" => $eq->EquipmentStatsID, "type" => '0'));
            $starArray = array();
            foreach ($starIds as $starInfo) {
                $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo->stats_id));
                $starArray[] = $stInfo;
            }
            $extended = (object) array_merge((array) $eq, array(
                        'BaseStats' => $baseState,
                        'BaseStatsGrow' => $baseGrow,
                        'StarStats' => $starArray,
            ));
            $equipArray[] = $extended;
        }

        $data['global'] = $global;
        $data['stage'] = $stage;
        $data['characters'] = $characterArray;
        $data['equips'] = $equipArray;
        $result['datas'] = $data;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getAllGashapon() {
        $postVars = $this->utils->inflatePost(array('uid'));
        $data = array();
        $gashas = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon');
        $data['gashas'] = $gashas;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }
    public function getGashapon()
    {

    }
    public function gashaRollItem($tableName,$tier,$totalReward)
    {
        $result = array();
        $gashaItems = $this->sqllibs->selectAllRows($this->db, $tableName);
        $totalWeight = 0;
        foreach($gashaItems as $gasha)
        {
          if ($gasha->Tier >= $tier)
          {
            $totalWeight += $gasha->Weight;
          }
        }
        $rngNumber = rand(0,$totalWeight);
        $currentWeight = 0;
        foreach($gashaItems as $gasha)
        {
          if ($gasha->Tier < $tier) continue;
          if ($currentWeight >= $rngNumber)
          {
              $result[] = $gasha;
              break;
          }
          $currentWeight += $gasha->Weight;
        }
        if ($totalReward == 1)
        {
            return $result;
        }
        $totalWeight = 0;
        foreach($gashaItems as $gasha)
        {
            $totalWeight += $gasha->Weight;
        }
        for ($i = 0;$i < $totalReward;$i++)
        {
            $rngNumber = rand(0,$totalWeight);
            $currentWeight = 0;
            {
              if ($gasha->Tier < $tier) continue;
              if ($currentWeight >= $rngNumber)
              {
                  $result[] = $gasha;
                  break;
              }
              $currentWeight += $gasha->Weight;
            }
        }
        return $result;
    }
    public function buyGashapon() {

        $postVars = $this->utils->inflatePost(array('gashaponID', 'playerID'));
        $reqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_gashapon_requirement', array('GashaponID' => $postVars['gashaponID']));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('no' => $postVars['playerID']));
        $currencyInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array('uid' => $postVars['playerID'],'cid' => $reqInfo->cid));
        $date = new DateTime();
        $items = array();
        $result = array();
        $type = "";
        if ($reqInfo->Cooldown <= 0 && (substr($postVars['gashaponID'], 0, 5 ) === "Basic") && $userInfo->BasicGashaClaim <= $date->getTimestamp())
        {
            $userInfo->BasicGashaClaim += $reqInfo->Cooldown;
            $items = $this->gashaRollItem($reqInfo->TableReference,$reqInfo->GuaranteedTier,$reqInfo->TotalRoll);
            $type = $reqInfo->TableReference;
        }
        else if ($currencyInfo->amount >= $reqInfo->Quantity)
        {
            $currencyInfo->amount -= $reqInfo->Quantity;
            $items = $this->gashaRollItem($reqInfo->TableReference,$reqInfo->GuaranteedTier,$reqInfo->TotalRoll);
            $type = $reqInfo->TableReference;
        }
        $type = $this->getGashaType($type);
        $result['items'][$type] = $items;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function getGashaType($table)
    {
        $types = ["basic","character","equip","premium"];
        foreach($types as $type)
        {
          if ($this->util->endsWith($table,"basic"))
          {
              return "basic";
          }
        }
        return "";
    }
    public function buyShopItem() {
        $postVars = $this->utils->inflatePost(array('uid', 'itemId', 'itemAmount'));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('no' => $postVars['uid']));
        $itemInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_shop', array('no' => $postVars['itemId']));
        $currencyInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array('uid' => $postVars['uid'], 'cid' => $itemInfo->currency));
        $result = array();
        if ($itemInfo->amount >= $postVars['itemAmount']) {
            if ($currencyInfo == null || count($currencyInfo) == 0 || $currencyInfo->amount < $itemInfo->cost * $postVars['itemAmount']) {
                $result['message'] = "Not enough currency";
                $result['result'] = 401;
            } else {
                $amount = $itemInfo->amount - $postVars['itemAmount'];
                $currency = $currencyInfo->amount - $itemInfo->cost * $postVars['itemAmount'];
                $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                    "amount" => $currency,
                        ), array(
                    "no" => $currencyInfo->no));
                $this->sqllibs->updateRow($this->db, 'tbl_base_shop', array(
                    "amount" => $amount,
                        ), array(
                    "no" => $itemInfo->no));
                $this->sqllibs->insertRow($this->db, 'tbl_order', array(
                    "item_id" => $postVars['itemId'],
                    "user_id" => $postVars['uid'],
                    "amount" => $postVars['itemAmount'],
                    "type" => 0,
                    "cost" => $itemInfo->cost * $postVars['itemAmount']
                ));
                $result['result'] = 200;
            }
        } else {
            $result['message'] = "Not enough amount";
            $result['result'] = 400;
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function testCurrency() {
        $this->currencyRecharge(1);
    }

    public function currencyRecharge($userId) {
//meat cap = initial meat value + (player level * meat growth)
        $date = new DateTime();
        $meatHistoryCurrency = $this->sqllibs->rawSelectSql($this->db, "select * from tbl_history_charge_currency where uid='" . $userId . "' and currency ='1' order by timestamp desc");
        $ticketHistoryCurrency = $this->sqllibs->rawSelectSql($this->db, "select * from tbl_history_charge_currency where uid='" . $userId . "' and currency ='6' order by timestamp desc");

        $meatInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array('uid' => $userId, 'cid' => 1));
        $ticketInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array('uid' => $userId, 'cid' => 6));

        if (count($meatHistoryCurrency) == 0) {
            $this->sqllibs->insertRow($this->db, 'tbl_history_charge_currency', array(
                "uid" => $userId,
                "currency" => 1,
                "amount" => 0,
                "timestamp" => $date->getTimestamp()
            ));
        } else {
            $oldTimestamp = $meatHistoryCurrency[0]->timestamp;
            $currentTimestamp = $date->getTimestamp();
            $meatAmount = (int) (($currentTimestamp - $oldTimestamp) / (5 * 60 * 1000));
            if ($meatAmount > 0) {
                $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                    "amount" => $meatInfo->amount + $meatAmount,
                        ), array(
                    "no" => $meatInfo->no));

                $this->sqllibs->insertRow($this->db, 'tbl_history_charge_currency', array(
                    "uid" => $userId,
                    "currency" => 1,
                    "amount" => $meatAmount,
                    "timestamp" => $date->getTimestamp()
                ));
            }
        }

        if (count($ticketHistoryCurrency) == 0) {
            $this->sqllibs->insertRow($this->db, 'tbl_history_charge_currency', array(
                "uid" => $userId,
                "currency" => 6,
                "amount" => 0,
                "timestamp" => $date->getTimestamp()
            ));
        } else {
            $oldTimestamp = $ticketHistoryCurrency[0]->timestamp;
            $currentTimestamp = $date->getTimestamp();
            $ticketAmount = (int) (($currentTimestamp - $oldTimestamp) / (20 * 60 * 1000));

            $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                "amount" => $ticketInfo->amount + $ticketAmount,
                    ), array(
                "no" => $ticketInfo->no));

            $this->sqllibs->insertRow($this->db, 'tbl_history_charge_currency', array(
                "uid" => $userId,
                "currency" => 6,
                "amount" => $ticketAmount,
                "timestamp" => $date->getTimestamp()
            ));
        }
    }

    //Update PlayerLevel following Experience
    //5 Weeks PlayerLevel
    public function updatePlayerLevel($playerID) {
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $playerID));
        $globalInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $playerLevel = $userInfo->PlayerLevel;
        $expLevels = json_decode($globalInfo->PlayerExpTNL);
        if ($expLevels[$playerLevel - 1] < $userInfo->PlayerCurrentExp) {
            $playerCurrentExp = $userInfo->PlayerCurrentExp - $expLevels[$playerLevel - 1];
            $playerLevel++;
            $this->sqllibs->updateRow($this->db, 'tbl_user', array(
                "PlayerCurrentExp" => $playerCurrentExp,
                "PlayerLevel" => $playerLevel,
                    ), array(
                "PlayerID" => $playerID));
        }
    }

    //5 Weeks Character Level
    public function updateCharacterLevel($characterID) {
        $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array('CharacterID' => $characterID));
        $globalInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $chLevel = $chInfo->Level;
        $expLevels = json_decode($globalInfo->CharacterExpTNL);
        if ($expLevels[$chLevel - 1] < $chInfo->CurrentExp) {
            $chCurrentExp = $chInfo->CurrentExp - $expLevels[$chLevel - 1];
            $chLevel++;
            $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
                "CurrentExp" => $chCurrentExp,
                "Level" => $chLevel,
                    ), array(
                "CharacterID" => $characterID));
        }
    }

    //5 Weeks Character Star
    public function updateCharacterStar($playerId, $characterID) {

        $postVars = $this->utils->inflatePost(array('playerId', 'characterStatId'));
        $playerId = $postVars['playerId'];
        $characterStatId = $postVars['characterStatId'];
        $playerInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $playerId));
        $soulShardInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_soulshard', array('PlayerID' => $playerId));
        if ($postVars == false) {
          $result['result'] = 400;
          $result['message'] = "Wrong Request";
          echo json_encode($result, JSON_NUMERIC_CHECK);
          return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user_character', array("CharacterStatsID" => $characterStatId, "PlayerID" => $playerId))) {
            $characterBaseInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_character', array('CharacterStatsID' => $characterStatId));
            $soulTNL = json_decode($characterBaseInfo->SoulshardTNL);
            if ($soulTNL[0] <= $soulShardInfo->Quantity)
            {
              //Create Character
              $createdId = $this->sqllibs->insertRow($this->db, 'tbl_user_character', array(
                  "CharacterStatsID" => $characterStatId,
                  "PlayerID" => $playerId,
                  "CurrentExp" => 0,
                  "Star" => 1,
                  "Border" => 0,
                  "TotalExp" => 0,
                  "Level" => 1,
                  "Equipment1" => "",
                  "Equipment2" => "",
                  "Equipment3" => ""
              ));
              $party = json_decode($playerInfo->Party);
              $party[] = $createdId;
              $this->sqllibs->updateRow($this->db, 'tbl_user', array(
                  "Party" => json_encode($party),
                      ), array(
                  "PlayerID" => $playerId));
            }
            else {
              $result['result'] = 400;
              $result['message'] = "Not Enough Shard Error";
              echo json_encode($result, JSON_NUMERIC_CHECK);
              return;
            }
        }
        $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array('CharacterID' => $characterID));
        $chStatId = $chInfo->CharacterStatsID;
        $soulShards = json_decode($playerInfo->SoulShard);
        foreach ($soulShards as $sInfo) {
            $soulInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_soulshards', array('no' => $sInfo));
            $statInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_character', array('CharacterStatsID' => $soulInfo->CharacterStatsID));
            $reqSoulShards = json_decode($statInfo->SoulshardTNL);
            for ($i = 1; $i < count($reqSoulShards) + 1; $i++) {
                if (($reqSoulShards[$i] <= $soulInfo->Quantity) && ($chInfo->Star < $i)) {
                    $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
                        "Star" => $chInfo->Star + 1,
                            ), array(
                        "CharacterID" => $characterID));
                    $this->sqllibs->updateRow($this->db, 'tbl_user_soulshards', array(
                        "Quantity" => $soulInfo->Quantity - $reqSoulShards[$i],
                            ), array(
                        "no" => $soulInfo->no));
                    $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array('CharacterID' => $characterID));
                    $result['character'] = $chInfo;
                    echo json_encode($result, JSON_NUMERIC_CHECK);
                }
            }
        }
    }

    //5 Weeks Character Border
    public function updateCharacterBorder($playerId, $characterID) {

        $postVars = $this->utils->inflatePost(array('playerId', 'characterId'));
        $playerId = $postVars['playerId'];
        $characterID = $postVars['characterId'];

        if ($postVars == false) {
          $result['result'] = 400;
          $result['message'] = "Wrong Request";
          echo json_encode($result, JSON_NUMERIC_CHECK);
          return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user_character', array("CharacterID" => $characterID, "PlayerID" => $playerId))) {

            return;
        }
        $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array('CharacterID' => $characterID, "PlayerID" => $playerId));
        $chStatId = $chInfo->CharacterStatsID;
        $playerInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $playerId));
        $statInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_character', array('CharacterStatsID' => $chStatId->CharacterStatsID));
        $borderReqs = $statInfos->BorderRequirement;
        $reqIds = json_decode($borderReqs);
        foreach ($reqIds as $req) {
            $userItemData = $this->sqllibs->getOneRow($this->db, 'tbl_user_inventory', array('PlayerID' => $playerId, 'ItemID' => $req));
            $reqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_orb_requirement', array('OrbID' => $req));
            if ($userItemData == null) {
                $result['result'] = 400;
                $result['message'] = "Failure";
                echo json_encode($result, JSON_NUMERIC_CHECK);
                return;
            }
            if ($userItemData->Quantity < $reqInfo->Quantity) {
                $result['result'] = 400;
                $result['message'] = "Failure";
                echo json_encode($result, JSON_NUMERIC_CHECK);
                return;
            }
        }
        foreach ($reqIds as $req) {
            $this->sqllibs->updateRow($this->db, 'tbl_user_inventory', array(
                "Quantity" => $userItemData->Quantity - $reqInfo->Quantity,
                    ), array(
                "no" => $userItemData->$characterID));
        }
        $chInfo->Border = $chInfo->Border + 1;
        $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
            "Border" => $chInfo->Border,
                ), array(
            "no" => $chInfo->no));
        $result['result'] = 200;
        $result['message'] = "Success";
        $result['character'] = $chInfo;
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    //5 Weeks Equipment Level
    public function updateEquipLevel($equipId) {

        $postVars = $this->utils->inflatePost(array('equipId'));
        $equipId = $postVars['equipId'];

        if ($postVars == false) {
          $result['result'] = 400;
          $result['message'] = "Wrong Request";
          echo json_encode($result, JSON_NUMERIC_CHECK);
          return;
        }

        $eqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_equip', array('EquipmentID' => $equipId));
        $globalInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $expLevel = $eqInfo->Level;
        $expLevels = json_decode($globalInfo->EquipmentExpTNL);
        if ($expLevels[$expLevel] < $eqInfo->CurrentExp) {
            $expLevel++;
            $eqCurrentExp = $eqInfo->CurrentExp - $expLevels[$expLevel];
            $this->sqllibs->updateRow($this->db, 'tbl_user_equip', array(
                "CurrentExp" => $eqCurrentExp,
                "Level" => $expLevel,
                    ), array(
                "EquipmentID" => $equipId));
        }
    }

    //5 Week Equipment Star
    public function updateEquipStar($playerId, $equipId) {

        $postVars = $this->utils->inflatePost(array('playerId','equipId'));
        $equipId = $postVars['equipId'];
        $playerId = $postVars['playerId'];

        if ($postVars == false) {
          $result['result'] = 400;
          $result['message'] = "Wrong Request";
          echo json_encode($result, JSON_NUMERIC_CHECK);
          return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user_equip', array("EquipmentID" => $equipId, "PlayerID" => $playerId))) {
            return;
        }
        $eqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_equip', array('EquipmentID' => $equipId));
        $eqStatId = $eqInfo->EquipmentStatsID;
        $playerInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $playerId));
        $statInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_equip', array('EquipmentStatsID' => $eqStatId));
        $runeReqs = $statInfos->StarRuneRequirement;
        $runeIds = json_decode($runeReqs);
        foreach ($runeIds as $runeId) {
            $userItemData = $this->sqllibs->getOneRow($this->db, 'tbl_user_inventory', array('PlayerID' => $playerId, 'ItemID' => $runeId));
            $reqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_rune_requirement', array('RuneID' => $runeId));
            if ($userItemData == null) {
                $result['result'] = 400;
                $result['message'] = "Failure";
                echo json_encode($result, JSON_NUMERIC_CHECK);
                return;
            }
            if ($userItemData->Quantity < $reqInfo->Quantity) {
                $result['result'] = 400;
                $result['message'] = "Failure";
                echo json_encode($result, JSON_NUMERIC_CHECK);
                return;
            }
        }
        foreach ($reqIds as $req) {
            $this->sqllibs->updateRow($this->db, 'tbl_user_inventory', array(
                "Quantity" => $userItemData->Quantity - $reqInfo->Quantity,
                    ), array(
                "no" => $userItemData->no));
        }
        $eqInfo->Border = $eqInfo->Border + 1;
        $this->sqllibs->updateRow($this->db, 'tbl_user_equip', array(
            "Star" => $eqInfo->Star,
                ), array(
            "no" => $eqInfo->EquipmentID));
        $result['result'] = 200;
        $result['message'] = "Success";
        $result['equip'] = $eqInfo;
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    //5 Week Equipment Skill Level
    public function updateEquipSkillLevel($playerId, $equipId) {

        $postVars = $this->utils->inflatePost(array('playerId','equipId'));
        $equipId = $postVars['equipId'];
        $playerId = $postVars['playerId'];

        if ($postVars == false) {
          $result['result'] = 400;
          $result['message'] = "Wrong Request";
          echo json_encode($result, JSON_NUMERIC_CHECK);
          return;
        }

        $eqInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_equip', array('EquipmentID' => $equipId));
        $globalInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $expLevel = $eqInfo->SkillLevel;
        $expLevels = json_decode($globalInfo->EquipmentSkillExpTNL);
        if ($expLevels[$expLevel] < $eqInfo->SkillExp) {
            $expLevel++;
            $eqCurrentExp = $eqInfo->SkillExp - $expLevels[$expLevel];
            $eqInfo->SkillLevel = $expLevel;
            $eqInfo->SkillExp = $eqCurrentExp;
            $this->sqllibs->updateRow($this->db, 'tbl_user_equip', array(
                "SkillExp" => $eqCurrentExp,
                "SkillLevel" => $expLevel,
                    ), array(
                "EquipmentID" => $equipId));
        }
        $result['result'] = 200;
        $result['message'] = "Success";
        $result['equip'] = $eqInfo;
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    //5 Week Equipment Skill Level
    public function setPlayerName() {
        $postVars = $this->utils->inflatePost(array('name', 'playerId'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['playerId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_user', array(
            "PlayerName" => $postVars['name']
                ), array(
            "PlayerID" => $postVars['playerId']));
        $result['result'] = 200;
        $result['message'] = "Success";
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    //5 Weeks Friend APIS
    public function sendFriendRequest()
    {
        $postVars = $this->utils->inflatePost(array('playerId', 'friendId'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['playerId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['friendId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if ($postVars['playerId'] == $postVars['friendId'])
        {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $id = $this->sqllibs->insertRow($this->db, 'tbl_user_friend', array(
            "PlayerID" => $postVars['playerId'],
            "FriendID" => $postVars['friendId'],
            "RequestStatus" => 1
        ));

        $id = $this->sqllibs->insertRow($this->db, 'tbl_user_friend', array(
            "PlayerID" => $postVars['friendId'],
            "FriendID" => $postVars['playerId'],
            "RequestStatus" => 0
        ));
        $result['result'] = 200;
        $result['message'] = "Success";
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    public function acceptFriendRequest()
    {
        $postVars = $this->utils->inflatePost(array('playerId', 'friendId','status'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['playerId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['friendId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if ($postVars['playerId'] == $postVars['friendId'])
        {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if ($postVars['status'] == 1)
        {
          $this->sqllibs->updateRow($this->db, 'tbl_user', array("RequestStatus" => 1),
                array(
                    "PlayerID" => $postVars['playerId'],
                    "FriendID" => $postVars['friendId']
          ));
          $this->sqllibs->updateRow($this->db, 'tbl_user', array("RequestStatus" => 1),
                array(
                    "FriendID" => $postVars['playerId'],
                    "PlayerID" => $postVars['friendId']
          ));
        }
        else {
            $this->sqllibs->deleteRow($this->db, 'tbl_user', array(
              "PlayerID" => $postVars['playerId'],
              "FriendID" => $postVars['friendId']
            ));
            $this->sqllibs->deleteRow($this->db, 'tbl_user', array(
              "FriendID" => $postVars['playerId'],
              "PlayerID" => $postVars['friendId']
            ));
        }
        $result['result'] = 200;
        $result['message'] = "Success";
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }
    public function getFriendRequest()
    {
        $postVars = $this->utils->inflatePost(array('playerId'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['playerId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $requests = $this->sqllibs->selectAllRows($this->db, 'tbl_user_friend', array("PlayerID" => $postVars['playerId']));
        $datas = array();
        foreach($reqeusts as $req)
        {
            $userData = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
                "PlayerID" => $postVars['FriendID']
            ));
            $req->friend = $userData;
            $datas[] = $req;
        }
        $result['result'] = 200;
        $result['datas'] = $datas;
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }

    //5 Weeks Mail APIS
    public function getPlayerMails()
    {
        $postVars = $this->utils->inflatePost(array('playerId'));
        if ($postVars == false) {
            $result['result'] = 400;
            $result['message'] = "Wrong Request";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        if (!$this->sqllibs->isExist($this->db, 'tbl_user', array("PlayerID" => $postVars['playerId']))) {
            $result['result'] = 400;
            $result['message'] = "Player is not exist";
            echo json_encode($result, JSON_NUMERIC_CHECK);
            return;
        }
        $mails = $this->sqllibs->selectAllRows($this->db, 'tbl_user_mail', array("PlayerID" => $postVars['playerId']));
        $result['result'] = 200;
        $result['datas'] = $mails;
        echo json_encode($result, JSON_NUMERIC_CHECK);
        return;
    }




}
