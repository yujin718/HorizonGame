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
        if ($this->sqllibs->isExist($this->db, 'tbl_user', array("Email" => $postVars['email']))) {
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
                . "left join tbl_base_equip as B on A.EquipmentStatsID=B.EquipmentStateID "
                . "where A.PlayerID='" . $postVars['uid'] . "'");
        $pvpInfos = $this->sqllibs->selectAllRows($this->db, 'tbl_user_pvp', array('PlayerID' => $postVars['uid']));
        $userInfo['currency'] = $currency;
        $userInfo['character'] = $characterInfos;
        $userInfo['equip'] = $eqInfos;
        $userInfo['pvp'] = $pvpInfos;

        $result['users'] = $userInfo;
        $result['result'] = 200;
        echo json_encode($result, JSON_NUMERIC_CHECK);
    }

    public function preBattleService() {
        $result = array();
        $postVars = $this->utils->inflatePost(array('userId', 'characterIds', 'stageId'));
        $stageInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stage', array("StageID" => $postVars['stageId']));
        $userMeat = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array("uid" => $postVars['userId'], "cid" => 1));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array("PlayerID" => $postVars['userId']));
        $stageProgressionInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_stage', array("StageID" => $postVars['stageId'], "user_id" => $postVars['userId']));

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
                $triesNumber = $stageProgressionInfo->TriesNumber;
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
            if ($stageProgressionInfo == null) {
                $this->sqllibs->insertRow($this->db, 'tbl_user_stage', array(
                    "StageID" => $postVars['stageId'],
                    "StarAcquired" => 0,
                    "TriesNumber" => 1
                ));
            } else {
                $tryNumber = $stageProgressionInfo->TriesNumber + 1;
                $this->sqllibs->updateRow($this->db, 'tbl_user_stage', array(
                    "TriesNumber" => $tryNumber,
                        ), array(
                    "no" => $stageProgressionInfo->StageProgressionID));
            }
            $meat = $userMeat->amount - $stageInfo->MeatRequirement;
            $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                "amount" => $meat,
                    ), array(
                "no" => $userMeat->no));
            $ids = json_decode($postVars['characterIds']);
            $characterArray = array();
            foreach ($ids as $id) {
                $info = $this->sqllibs->rawSelectSql($this->db, "select * from tbl_user_character as A left join tbl_base_character as B on A.CharacterStatsID=B.CharacterStatsID where A.CharacterID='" . $id . "'");
                if (count($info) > 0) {
                    $characterArray[] = $info[0];
                }
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
        $stageProgressionInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_stage', array("StageID" => $postVars['stageId'], "user_id" => $postVars['userId']));
        if ($stageProgressionInfo == null) {
            $this->sqllibs->insertRow($this->db, 'tbl_user_stage', array(
                "StageID" => $postVars['stageId'],
                "StarAcquired" => $postVars['star'],
                "TriesNumber" => 1
            ));
        } else {
            $this->sqllibs->updateRow($this->db, 'tbl_user_stage', array(
                "StarAcquired" => $postVars['star'],
                    ), array(
                "StageProgressionID" => $stageProgressionInfo->StageProgressionID));
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
                    $starIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array("data_id" => $ch->CharacterStatsID, "type" => '0'));
                    $starArray = array();
                    foreach ($starIds as $starInfo) {
                        $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo->stats_id));
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
                    $starIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array("data_id" => $eq->EquipmentStateID, "type" => '1'));
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
            $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->base_state_id));
            $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->base_state_grow));
            $border = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $ch->border_state));
            $starIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array("data_id" => $ch->ch_id, "type" => '0'));
            $starArray = array();
            foreach ($starIds as $starInfo) {
                $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo->stats_id));
                $starArray[] = $stInfo;
            }
            $extended = (object) array_merge((array) $ch, array(
                        'base_state' => $baseState,
                        'base_grow' => $baseGrow,
                        'border_state' => $border,
                        'star_stats' => $starArray,
            ));
            $characterArray[] = $extended;
        }
        $equipArray = array();
        foreach ($equips as $eq) {
            $baseState = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->base_state_id));
            $baseGrow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $eq->base_state_grow));
            $starIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array("data_id" => $eq->eq_id, "type" => '0'));
            $starArray = array();
            foreach ($starIds as $starInfo) {
                $stInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array("no" => $starInfo->stats_id));
                $starArray[] = $stInfo;
            }
            $extended = (object) array_merge((array) $eq, array(
                        'base_state' => $baseState,
                        'base_grow' => $baseGrow,
                        'star_stats' => $starArray,
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

    public function buyGashapon() {
        $postVars = $this->utils->inflatePost(array('uid', 'itemId'));
        $userInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('no' => $postVars['uid']));
        $itemInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_gashapon', array('no' => $postVars['itemId']));
        $currencyInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_currency', array('uid' => $postVars['uid'], 'cid' => $itemInfo->currency));
        if ($itemInfo->amount > 0) {
            if ($currencyInfo == null || count($currencyInfo) == 0 || $currencyInfo->amount < $itemInfo->cost) {
                $result['message'] = "Not enough currency";
                $result['result'] = 401;
            } else {
                $amount = $itemInfo->amount - 1;
                $currency = $currencyInfo->amount - $itemInfo->cost;
                $this->sqllibs->updateRow($this->db, 'tbl_user_currency', array(
                    "amount" => $currency,
                        ), array(
                    "no" => $currencyInfo->no));
                $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon', array(
                    "amount" => $amount,
                        ), array(
                    "no" => $itemInfo->no));
                $this->sqllibs->insertRow($this->db, 'tbl_order', array(
                    "item_id" => $postVars['itemId'],
                    "user_id" => $postVars['uid'],
                    "amount" => 1,
                    "type" => 1,
                    "cost" => $itemInfo->cost
                ));
                $result['result'] = 200;
            }
        } else {
            $result['message'] = "Not enough amount";
            $result['result'] = 400;
        }
        echo json_encode($result, JSON_NUMERIC_CHECK);
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
        if ($expLevels[$playerLevel] < $userInfo->PlayerCurrentExp) {
            $playerLevel++;
            $playerCurrentExp = $userInfo->PlayerCurrentExp - $expLevels[$playerLevel];
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
        if ($expLevels[$chLevel] < $chInfo->CurrentExp) {
            $chLevel++;
            $chCurrentExp = $chInfo->CurrentExp - $expLevels[$chLevel];
            $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
                "CurrentExp" => $chCurrentExp,
                "Level" => $chLevel,
                    ), array(
                "CharacterID" => $characterID));
        }
    }
    
    //5 Weeks Character Star
    public function updateCharacterStar($playerId,$characterID) {
        
        if (!$this->sqllibs->isExist($this->db, 'tbl_user_character', array("CharacterID" => $characterID, "PlayerID" => $playerId))) {
            return;
        }
        $chInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user_character', array('CharacterID' => $characterID));
        $globalInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_global', array('no' => 1));
        $chLevel = $chInfo->Level;
        $expLevels = json_decode($globalInfo->CharacterExpTNL);
        if ($expLevels[$chLevel] < $chInfo->CurrentExp) {
            $chLevel++;
            $chCurrentExp = $chInfo->CurrentExp - $expLevels[$chLevel];
            $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
                "CurrentExp" => $chCurrentExp,
                "Level" => $chLevel,
                    ), array(
                "CharacterID" => $characterID));
        }
    }

}
