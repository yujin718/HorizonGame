<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_DASHBOARD);
        } else {
            $data = $this->setMessages(array());
            $this->load->view('login_admin', $data);
        }
    }

    public function dashboardPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Dashboard", "Admin");
        $data = $this->setMessages($data);
        $data['countCat'] = 0;
        $data['countRest'] = 0;
        $data['countReserve'] = 0;
        $data['countUser'] = 0;
        $data['restaurants'] = array();
        $this->load->view('view_admin', $data);
    }

    public function userPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Users", "Admin");
        $data = $this->setMessages($data);
        $data['users'] = $this->sqllibs->selectAllRows($this->db, 'tbl_user');
        $data['admins'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_admin', array('level' => 1));
        $this->load->view('view_admin', $data);
    }

    public function settingPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Settings", "Admin");
        $data = $this->setMessages($data);
        $data['inventorys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_inventory');
        $this->load->view('view_admin', $data);
    }

    public function gashaponPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Gashapons", "Admin");
        $data = $this->setMessages($data);
        $data['reqs'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon_requirement');
        $data['users'] = $this->sqllibs->selectAllRows($this->db, 'tbl_user');
        $data['basics'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon_basic');
        $data['characters'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon_character');
        $data['currencys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');
        $data['equips'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon_equip');
        $data['premiums'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_gashapon_premium');
        $this->load->view('view_admin', $data);
    }
    public function shopPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Shop", "Admin");
        $data = $this->setMessages($data);
        $data['shops'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_shop');
        $data['currencys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');
        $this->load->view('view_admin', $data);
    }
    public function serverDataPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("ServerData", "Admin");
        $data = $this->setMessages($data);
        $data['characters'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_character');
        $data['equips'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_equip');
        $data['stages'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_stage');
        $data['currencys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');
        $data['globals'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_global');
        $data['monsters'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_monster');

        $this->createGlobalJsonData($data['globals'], 'globals.json');
        $this->createCharacterServerJsonData($data['characters'], 'character_serverdata.json');
        $this->createEquipServerJsonData($data['equips'], 'equip_serverdata.json');
        $this->createStageServerJsonData($data['stages'], 'stage_serverdata.json');
        $this->createMonsterServerJsonData($data['monsters'], 'monster_serverdata.json');

        $this->load->view('view_admin', $data);
    }


    public $mapGlobalData = array(
      "server_version" => "ServerVersion",
      "client_version" => "ClientVersion",
      "daily_server_reset" => "DailyServerReset",
      "meat_recharge_rate" => "MeatRechargeRate",
      "base_pvp_ticketcap" => "BasePvpTicket",
      "player_exptnl" => "PlayerExpTNL",
      "pvp_reset" => "PvPReset",
      "player_levelcap" => "PlayerLevelCap",
      "character_levelcap" => "CharacterLevelCap",
      "gulid_levelcap" => "GulidLevelCap",
      "freebase_gashareset" => "FreeBasicGashaReset",
      "freepremium_gashareset" => "FreePremiumGashaReset",
    );

    public $mapCharacterServerData = array(
          "ch_id" => "CharacterStatsID",
          "name" => "Name",
          "description" => "Description",
          "role" => "Role",
          "exptnl" => "ExpTNL",
          "soulshardtnl" => "SoulShardTNL",
          "skill" => "Skill",
          "passive" => "Passive",
          "leaderskill" => "LeaderSkill",
          "border_requirement" => "BorderRequirement",
    );

    public $mapEquipServerData = array(
          "eq_id" => "EquipmentStatsID",
          "name" => "Name",
          "description" => "Description",
          "cost" => "Cost",
          "exptnl" => "ExpTNL",
          "skill" => "Skill",
          "skill_description" => "SkillDescription",
          "skilltnl" => "SkillTNL",
    );

    public $mapStageServerData = array(
          "stage_id" => "StageID",
          "stage_requirement" => "StageRequirement",
          "stage_reward" => "StageReward",
          "meat_requirement" => "MeatRequirement",
          "enemy_wave" => "EnemyWavesDetail",
          "first_time_reward" => "FirstTimeReward",
          "gold_reward" => "GoldReward",
          "player_exp_reward" => "PlayerExpReward",
          "character_exp_reward" => "CharacterExpReward",
          "tries" => "Tries",
    );

    public $mapStats = array(
          "hp" => "HP",
          "damage" => "Damage",
          "power" => "Power",
          "armor" => "Armor",
          "speed" => "Speed",
          "resist_fire" => "ResistFire",
          "resist_water" => "ResistWater",
          "resist_light" => "ResistLight",
          "resist_dark" => "ResistDark",
          "resist_earth" => "ResistEarth",
    );

    public $mapMonster = array(
          "monster_id" => "MonsterID",
          "name" => "Name",
          "description" => "Description",
          "type" => "Type",
          "skill1" => "Skill1",
          "skill2" => "Skill2",
          "skill3" => "Skill3",
          "skill4" => "Skill4",
          "skill5" => "Skill5"
    );

    public $mapAccount = array(
          "name" => "PlayerName",
          "player_level" => "PlayerLevel",
          "player_exp" => "PlayerEXP",
          "total_exp" => "PlayerTotalEXP",
          "type" => "RegisterType",
          "sid" => "SocialID",
          "token" => "DeviceID",
          "createtime" => "CreateTime",
          "last_login" => "LastLogin",
          "base_gasha_claim" => "BaseGashaClaimed",
          "premium_gasha_claim" => "PremiumGashaClaimed",
          "tutorial_state" => "TutorialState"
    );

    public $mapCurrency = array(
          "1" => "Meat",
          "2" => "Gold",
          "4" => "Gem",
          "5" => "Skip Ticket",
          "6" => "PvP Ticket",
          "7" => "PvP Token",
          "8" => "Guild Token",
    );
    public $mapCharacter = array(
          "exp" => "EXP",
          "total_exp" => "TotalExp",
          "level" => "Level",
          "star" => "Star",
          "border" => "Border",
          "equip1" => "EquipmentSlot1",
          "equip2" => "EquipmentSlot2",
          "equip3" => "EquipmentSlot3",
          "no" => "CharacterID",
          "cid" => "CharacterStatsID",
    );

    public $mapEquip = array(
          "no" => "EquipmentID",
          "eid" => "EquipmentStatsID",
          "ch_id" => "CharacterID",
          "star" => "Star",
          "skill_level" => "SkillLevel",
          "level" => "Level",
          "current_exp" => "EXP",
          "total_exp" => "TotalExp"
    );

    public function createGlobalJsonData($globals, $fileName)
    {
        $arrayData = array();
        $gInfo = array();
        if (count($globals) > 0) {
            $gInfo = $globals[0];
        }
        unset($gInfo->no);
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($gInfo));
        fclose($fp);
    }
    public function createUserEqupJsonData($equips, $fileName)
    {
        $result = array();
        foreach ($equips as $equip) {
            $result[] = $equip;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function createUserCharacterJsonData($characters, $fileName)
    {
        $result = array();
        foreach ($characters as $character) {
            $result[] = $character;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function createCurrencyJsonData($currency, $fileName)
    {
        $arrayData = array();
        foreach ($currency as $cy) {
            $currencyBase = $this->sqllibs->getOneRow($this->db, 'tbl_base_currency', array('no' => $cy->cid));
            $arrayData[$currencyBase->name] = $cy->amount;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($arrayData));
        fclose($fp);
    }
    public function createPlayerJsonData($player, $fileName)
    {
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($player));
        fclose($fp);
    }

    public function createCharacterServerJsonData($characters, $fileName)
    {
        $result = array();
        foreach ($characters as $character) {
            $arrayData = json_decode(json_encode($character));
            // foreach ($data as $key => $value) {
            //     if (array_key_exists($key, $this->mapCharacterServerData)) {
            //         $arrayData[$this->mapCharacterServerData[$key]] = $value;
            //     }
            // }
            //Add Base State,BaseStatsGrow,BorderStats,StarStats
            $baseStat = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $character->BaseStats));
            $base_state_grow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $character->BaseStatsGrow));
            $borde_stat = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $character->BorderStats));
            //
            $startIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type'=>0,'data_id' => $character->CharacterStatsID));

            $arrayData->BaseStats = $this->getStatesArray($baseStat);
            $arrayData->BaseStatsGrow = $this->getStatesArray($base_state_grow);
            $arrayData->BorderStats = $this->getStatesArray($borde_stat);
            $stars = array();
            foreach ($startIds as $star) {
                $starInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $star->stats_id));
                $stars[] = $this->getStatesArray($starInfo);
            }
            $arrayData->StarStats = $stars;
            $result[] = $arrayData;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function createEquipServerJsonData($equips, $fileName)
    {
        $data = json_decode(json_encode($equips));
        $result = array();
        foreach ($equips as $equip) {
            $arrayData = json_decode(json_encode($equip));
            // foreach ($data as $key => $value) {
            //     if (array_key_exists($key, $this->mapEquipServerData)) {
            //         $arrayData[$this->mapEquipServerData[$key]] = $value;
            //     }
            // }
            //Add Base State,BaseStatsGrow,BorderStats,StarStats
            $baseStat = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $equip->BaseStats));
            $base_state_grow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $equip->BaseStatsGrow));
            $startIds = $this->sqllibs->selectAllRows($this->db, 'tbl_base_starstats', array('type'=>1,'data_id' => $equip->EquipmentStatsID));

            $arrayData->BaseStats = $this->getStatesArray($baseStat);
            $arrayData->BaseStatsGrow = $this->getStatesArray($base_state_grow);
            $stars = array();
            foreach ($startIds as $star) {
                $starInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $star->stats_id));
                $stars[] = $this->getStatesArray($starInfo);
            }
            $arrayData->StarStats = $stars;
            $result[] = $arrayData;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function createMonsterServerJsonData($monsters, $fileName)
    {
        $data = json_decode(json_encode($monsters));
        $result = array();
        foreach ($monsters as $monster) {
            $data = json_decode(json_encode($monster));
            foreach ($data as $key => $value) {
                if (array_key_exists($key, $this->mapMonster)) {
                    $arrayData[$this->mapMonster[$key]] = $value;
                }
            }
            $baseStat = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $monster->BaseStats));
            $base_state_grow = $this->sqllibs->getOneRow($this->db, 'tbl_base_stats', array('no' => $monster->BaseStatsGrow));
            $arrayData['BaseStats'] = $this->getStatesArray($baseStat);
            $arrayData['BaseStatsGrow'] = $this->getStatesArray($base_state_grow);
            $result[] = $arrayData;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function createStageServerJsonData($stages, $fileName)
    {
        $result = array();
        foreach ($stages as $stage) {
            //$data = json_decode(json_encode($stage));
            // foreach ($data as $key => $value) {
            //     if (array_key_exists($key, $this->mapStageServerData)) {
            //         $arrayData[$this->mapStageServerData[$key]] = $value;
            //     }
            // }
            $result[] = $stage;
        }
        $fp = fopen($fileName, 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }
    public function getStatesArray($stats)
    {
        $data = json_decode(json_encode($stats));
        $arrayData = array();
        // foreach ($data as $key => $value) {
        //     if (array_key_exists($key, $this->mapStats)) {
        //         $arrayData[$this->mapStats[$key]] = $value;
        //     }
        // }
        return $stats;
    }

    public function addMailPage($id)
    {
      if (!$this->isLogin()) {
            $this->utils->redirectPage('index.php/AdminController/userDetailPage/'.$id);
          return;
      }
      $data = $this->getViewParameters("AddEmail", "Admin");
      $data['userInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
          "PlayerID" => $id
      ));
      $currencys = $this->sqllibs->selectAllRows($this->db,'tbl_base_currency');
      $soulshards = $this->sqllibs->selectAllRows($this->db,'tbl_base_soulshard');
      $items = $this->sqllibs->selectAllRows($this->db,'tbl_base_item_encyclopedia');
      $equips = $this->sqllibs->selectAllRows($this->db,'tbl_base_equip');
      $characters = $this->sqllibs->selectAllRows($this->db,'tbl_base_character');

      $items1[0] = $currencys;
      $items1[1] = $soulshards;
      $items1[2] = $items;
      $items1[3] = $equips;
      $items1[4] = $characters;

      $items1 = $this->utils->js_array($items1);
      $data['items'] = $items1;
      $data = $this->setMessages($data);
      $this->load->view('view_admin', $data);
    }
    public function actionAddMail()
    {
        $postVars = $this->utils->inflatePost(array('email_title', 'email_message', 'email_uid','email_attach'));
        $attach = json_decode($postVars['email_attach']);
        $arrayItem = array();
        $itemType1 = -1;  $itemID1 = -1;  $itemQuantity1 = -1;
        $itemType2 = -1;  $itemID2 = -1;  $itemQuantity2 = -1;
        $itemType3 = -1;  $itemID3 = -1;  $itemQuantity3 = -1;
        $itemType4 = -1;  $itemID4 = -1;  $itemQuantity4 = -1;
        $itemType5 = -1;  $itemID5 = -1;  $itemQuantity5 = -1;

        if (count($attach) > 0)
        {
            $itemType1 = $attach[0]->type;
            $itemID1 = $attach[0]->id;
            $itemQuantity1 = $attach[0]->quantity;
        }
        if (count($attach) > 1)
        {
            $itemType2 = $attach[1]->type;
            $itemID2 = $attach[1]->id;
            $itemQuantity2 = $attach[1]->quantity;
        }
        if (count($attach) > 2)
        {
            $itemType3 = $attach[2]->type;
            $itemID3 = $attach[2]->id;
            $itemQuantity3 = $attach[2]->quantity;
        }
        if (count($attach) > 3)
        {
            $itemType4 = $attach[3]->type;
            $itemID4 = $attach[3]->id;
            $itemQuantity4 = $attach[3]->quantity;
        }
        if (count($attach) > 4)
        {
            $itemType5 = $attach[4]->type;
            $itemID5 = $attach[4]->id;
            $itemQuantity5 = $attach[4]->quantity;
        }
        $this->sqllibs->insertRow($this->db, 'tbl_user_mail', array(
            "PlayerID" => $postVars['email_uid'],
            "Title" => $postVars['email_title'],
            "Message" => $postVars['email_message'],
            "ItemType" => $itemType1,
            "ItemID" =>$itemID1,
            "Quantity" => $itemQuantity1,
            "ItemType2" => $itemType2,
            "ItemID2" => $itemID2,
            "Quantity2" => $itemQuantity2,
            "ItemType3" => $itemType3,
            "ItemID3" => $itemID3,
            "Quantity3" => $itemQuantity3,
            "ItemType4" => $itemType4,
            "ItemID4" => $itemID4,
            "Quantity4" => $itemQuantity4,
            "ItemType5" => $itemType5,
            "ItemID5" => $itemID5,
            "Quantity5" => $itemQuantity5,
            "IsClaimed" => 0,
        ));
        $this->utils->redirectPage('index.php/AdminController/userDetailPage/'.$postVars['email_uid']);
    }

    public function userDetailPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("UserDetail", "Admin");
        $data['userInfo'] = $this->sqllibs->getOneRow($this->db, 'tbl_user', array(
            "PlayerID" => $id
        ));
        // $data['inventorys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_inventory');
        // $data['inventoryInfos'] = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_inventory as A "
        //         . "left join tbl_base_inventory as B on A.InventoryID=B.no "
        //         . "where A.PlayerID='" . $id . "'");
        $data['inventorys'] = array();
        $data['inventoryInfos'] = array();

        $data['currencys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');
        $data['currencyInfos'] = $this->sqllibs->selectAllRows($this->db, "tbl_user_currency", array('uid' => $id));

        $data['equips'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_equip');
        $data['equipInfos'] = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_equip as A "
                . "left join tbl_base_equip as B on A.EquipmentStatsID=B.EquipmentStatsID "
                . "where A.PlayerID='" . $id . "'");
        $data['characters'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_character');
        $data['characterInfo'] = $this->sqllibs->selectAllRows($this->db, 'tbl_user_character', array('PlayerID' => $id));

        $data['stLevels'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_progress_stage');
        $data['stLevelInfo'] = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_progress_level as A "
                . "left join tbl_base_progress_stage as B on A.stage_id=B.no "
                . "where A.uid='" . $id . "'");

        $data['stRewards'] = $this->sqllibs->selectAllRows($this->db, 'tbl_base_progress_reward');
        $data['stRewardInfo'] = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.name as name from tbl_user_progress_rewards as A "
                . "left join tbl_base_progress_reward as B on A.reward_id=B.no "
                . "where A.uid='" . $id . "'");
        $data['pvpInfo'] = $this->sqllibs->selectAllRows($this->db, 'tbl_user_pvp', array('PlayerID' => $id));
        $data['analystics'] = $this->sqllibs->selectAllRows($this->db, 'tbl_user_analystic', array('uid' => $id));
        $data['emails'] = $this->sqllibs->selectAllRows($this->db,'tbl_user_mail',array('PlayerID' => $id));

        $this->createPlayerJsonData($data['userInfo'], 'player.json');
        $this->createCurrencyJsonData($data['currencyInfos'], 'currency.json');
        $this->createUserCharacterJsonData($data['characterInfo'], 'character.json');
        $this->createUserEqupJsonData($data['equipInfos'], 'equip.json');


        $data = $this->setMessages($data);
        $this->load->view('view_admin', $data);
    }
    public function actionDeleteMail($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(base_url().'index.php');
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_mail', array(
            "MailID" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function changeAdminPassword()
    {
        $postVars = $this->utils->inflatePost(array('old_pw', 'new_pw', 'adminId'));
        $adminInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_admin', array(
            "no" => $postVars['adminId']
        ));
        $adminPw = $adminInfo->password;
        if ($adminPw == $postVars['old_pw']) {
            $this->sqllibs->updateRow($this->db, 'tbl_base_admin', array(
                "password" => $postVars['new_pw'],
                    ), array(
                "no" => $postVars['adminId']
            ));
            $this->session->set_flashdata('message', 'Success to change password');
        } else {
            $this->session->set_flashdata('errorMessage', 'Old password is wrong');
        }
        $this->utils->redirectPage('index.php/AdminController/settingPage');
    }

    public function addGoodsPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("AddGoods", "Admin");
        $data = $this->setMessages($data);
        $data['companys'] = $this->sqllibs->selectAllRows($this->db, 'tbl_company');
        $this->load->view('view_admin', $data);
    }

    public function addCompanyPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("AddCompany", "Admin");
        $data = $this->setMessages($data);
        $this->load->view('view_admin', $data);
    }

    public function addDeliverPage()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("AddDeliver", "Admin");
        $data = $this->setMessages($data);
        $this->load->view('view_admin', $data);
    }

    public function viewUserHistoryPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("UserHistory", "Admin");
        $data = $this->setMessages($data);
        $data['orders'] = $this->sqllibs->rawSelectSql($this->db, "select A.*,B.good_id as gid,C.name as deliver_name from tbl_order as A "
                . "left join tbl_goods as B on A.good_id=B.no "
                . "left join tbl_deliver as C on A.deliver=C.no "
                . "where A.user_id='" . $id . "'");
        $this->load->view('view_admin', $data);
    }

    public function setJavascriptString($slashString)
    {
        return '"' . addcslashes($slashString, "\0..\37\"\\") . '"';
    }

    public function setJavascriptArray($array)
    {
        $temp = array_map([$this, 'setJavascriptString'], $array);

        return '[' . implode(',', $temp) . ']';
    }

    public function viewGoodsChartPage($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("Chart", "Admin");
        $data = $this->setMessages($data);
        $graphData = [];
        for ($iIndex = -29; $iIndex < 1; $iIndex++) {
            $date1 = new \DateTime($iIndex . ' days');
            $orders = $this->sqllibs->rawSelectSql($this->db, "select * from tbl_order where good_id='" . $id . "' and createtime like '" . $date1->format('Y-m-d') . "%'");
            $graphData[$iIndex] = count($orders);
        }
        $data['graphs'] = $this->setJavascriptArray($graphData);
        ;
        $this->load->view('view_admin', $data);
    }

    public function actionAddPvp()
    {
        $postVars = $this->utils->inflatePost(array('pvp_group_id', 'pvp_rating', 'pvp_rating_highscore', 'pvp_leader_rank', 'pvp_win_ratio', 'pvp_match_history', 'pvp_reward_history', 'pvp_uid'));
        $this->sqllibs->insertRow($this->db, 'tbl_user_pvp', array(
            "pvp_group_id" => $postVars['pvp_group_id'],
            "pvp_rating" => $postVars['pvp_rating'],
            "pvp_highscore" => $postVars['pvp_rating_highscore'],
            "pvp_leader_rank" => $postVars['pvp_leader_rank'],
            "pvp_win_ratio" => $postVars['pvp_win_ratio'],
            "pvp_history" => $postVars['pvp_match_history'],
            "pvp_reward_history" => $postVars['pvp_reward_history'],
            "uid" => $postVars['pvp_uid'],
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionAddStoryReward()
    {
        $postVars = $this->utils->inflatePost(array('str_name', 'str_claim_status', 'str_uid'));
        $this->sqllibs->insertRow($this->db, 'tbl_user_progress_rewards', array(
            "reward_id" => $postVars['str_name'],
            "claim_status" => $postVars['str_claim_status'],
            "uid" => $postVars['str_uid'],
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionAddStoryLevel()
    {
        $postVars = $this->utils->inflatePost(array('st_name', 'st_clear_status', 'st_stage_star', 'st_uid'));
        $this->sqllibs->insertRow($this->db, 'tbl_user_progress_level', array(
            "stage_id" => $postVars['st_name'],
            "clear_status" => $postVars['st_clear_status'],
            "stage_star" => $postVars['st_stage_star'],
            "uid" => $postVars['st_uid']
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionAddCharacter()
    {
        $postVars = $this->utils->inflatePost(array('ch_total_exp','ch_level','ch_e_id','ch_name', 'ch_exp', 'ch_star', 'ch_border', 'ch_equip1', 'ch_equip2', 'ch_equip3', 'ch_uid'));
        $this->sqllibs->insertRow($this->db, 'tbl_user_character', array(
            "CharacterID" => $postVars['ch_e_id'],
            "CharacterStatsID" => $postVars['ch_name'],
            "PlayerID" => $postVars['ch_uid'],
            "CurrentExp" => $postVars['ch_exp'],
            "Star" => $postVars['ch_star'],
            "Border" => $postVars['ch_border'],
            "Equipment1" => $postVars['ch_equip1'],
            "Equipment2" => $postVars['ch_equip2'],
            "Equipment3" => $postVars['ch_equip3'],
            "TotalExp" => $postVars['ch_total_exp'],
            "Level" => $postVars['ch_level'],
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionAddEquipment()
    {
        $postVars = $this->utils->inflatePost(array('eq_id','eq_name', 'eq_exp', 'eq_level', 'eq_star', 'eq_total_exp','eq_skill_level', 'eq_uid'));
        $this->sqllibs->insertRow($this->db, 'tbl_user_equip', array(
            "EquipmentID" => $postVars['eq_id'],
            "PlayerID" => $postVars['eq_uid'],
            "EquipmentStatsID" => $postVars['eq_name'],
            "CurrentExp" => $postVars['eq_exp'],
            "Level" => $postVars['eq_level'],
            "Star" => $postVars['eq_star'],
            "TotalExp" => $postVars['eq_total_exp'],
            "SkillLevel" => $postVars['eq_skill_level'],
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionAddInventory()
    {
        $postVars = $this->utils->inflatePost(array('iv_name', 'iv_quantity', 'iv_uid'));
        if ($postVars['iv_quantity'] == '' || $postVars['iv_name'] == '') {
            $this->session->set_flashdata('errorMessage', "Please fill input");
            redirect($this->agent->referrer());
            return;
        }
        $this->sqllibs->insertRow($this->db, 'tbl_user_inventory', array(
            "PlayerID" => $postVars['iv_uid'],
            "InventoryID" => $postVars['iv_name'],
            "Quantity" => $postVars['iv_quantity'],
        ));
        $this->session->set_flashdata('message', "Successfully Added");
        redirect($this->agent->referrer());
    }

    public function actionEditCharacter()
    {
        $postVars = $this->utils->inflatePost(array('ch_edit_level','ch_edit_total_exp','ch_edit_name', 'ch_edit_uid', 'ch_edit_cid', 'ch_edit_exp', 'ch_edit_star', 'ch_edit_border', 'ch_edit_equip1', 'ch_edit_equip2', 'ch_edit_equip3'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_character', array(
            "PlayerID" => $postVars['ch_edit_uid'],
            "CharacterStatsID" => $postVars['ch_edit_name'],
            "CurrentExp" => $postVars['ch_edit_exp'],
            "Star" => $postVars['ch_edit_star'],
            "Border" => $postVars['ch_edit_border'],
            "Equipment1" => $postVars['ch_edit_equip1'],
            "Equipment2" => $postVars['ch_edit_equip2'],
            "Equipment3" => $postVars['ch_edit_equip3'],
            "Level" => $postVars['ch_edit_level'],
            "TotalExp" => $postVars['ch_edit_total_exp'],
                ), array(
            "CharacterID" => $postVars['ch_edit_cid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditEquipment()
    {
        $postVars = $this->utils->inflatePost(array('eq_edit_name', 'eq_edit_uid', 'eq_edit_eid', 'eq_edit_exp', 'eq_edit_level', 'eq_edit_star','eq_edit_total_exp', 'eq_edit_skill_level'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_equip', array(
            "EquipmentStatsID" => $postVars['eq_edit_name'],
            "CurrentExp" => $postVars['eq_edit_exp'],
            "Level" => $postVars['eq_edit_level'],
            "Star" => $postVars['eq_edit_star'],
            "TotalExp" => $postVars['eq_edit_total_exp'],
            "SkillLevel" => $postVars['eq_edit_skill_level'],
                ), array(
            "EquipmentID" => $postVars['eq_edit_eid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditStoryLevel()
    {
        $postVars = $this->utils->inflatePost(array('st_edit_name', 'st_edit_clear_status', 'st_edit_stage_star', 'st_edit_uid', 'st_edit_sid'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_progress_level', array(
            "uid" => $postVars['st_edit_uid'],
            "stage_id" => $postVars['st_edit_name'],
            "clear_status" => $postVars['st_edit_clear_status'],
            "stage_star" => $postVars['st_edit_stage_star'],
                ), array(
            "no" => $postVars['st_edit_sid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditInventory()
    {
        $postVars = $this->utils->inflatePost(array('iv_edit_name', 'iv_edit_quantity', 'iv_edit_uid', 'iv_edit_iid'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_inventory', array(
            "PlayerID" => $postVars['iv_edit_uid'],
            "InventoryID" => $postVars['iv_edit_name'],
            "Quantity" => $postVars['iv_edit_quantity'],
                ), array(
            "no" => $postVars['iv_edit_iid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditPlayerName()
    {
        $postVars = $this->utils->inflatePost(array('pl_edit_name', 'pl_edit_uid'));
        $this->sqllibs->updateRow($this->db, 'tbl_user', array(
            "name" => $postVars['pl_edit_name'],
                ), array(
            "no" => $postVars['pl_edit_uid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditCurrency()
    {
        $postVars = $this->utils->inflatePost(array('cy_edit_number', 'uid'));
        $currencys = $this->sqllibs->selectAllRows($this->db, 'tbl_base_currency');
        $this->sqllibs->deleteRow($this->db, 'tbl_user_currency', array(
            "uid" => $postVars['uid']
        ));
        $i = 0;
        foreach ($currencys as $currency) {
            if ($postVars['cy_edit_number'][$i] == 0) {
                $i++;
                continue;
            }
            $this->sqllibs->insertRow($this->db, 'tbl_user_currency', array(
                "uid" => $postVars['uid'],
                "cid" => $currency->no,
                "amount" => $postVars['cy_edit_number'][$i],
            ));
            $i++;
        }
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionDeleteAnalystic($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_analystic', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionDeletePvp($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_pvp', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionDeleteProgressReward($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_progress_rewards', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionDeleteProgressLevel($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_progress_level', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }
    public function actionDeleteCharacter($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_character', array(
            "CharacterID" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }
    public function actionDeleteEquip($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_equip', array(
            "EquipmentID" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionDeleteInventory($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user_inventory', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionCreateAdmin()
    {
        $postVars = $this->utils->inflatePost(array('adminId', 'adminPassword'));
        if ($postVars['adminId'] == '' || $postVars['adminPassword'] == '') {
            $this->session->set_flashdata('errorMessage', "Please fill input");
            redirect(base_url() . 'index.php/AdminController/userPage');
            return;
        }
        if ($this->sqllibs->isExist($this->db, 'tbl_base_admin', array('user' => $postVars['adminId']))) {
            $this->session->set_flashdata('errorMessage', "Account ID already exist!");
            redirect(base_url() . 'index.php/AdminController/userPage');
            return;
        }
        $this->sqllibs->insertRow($this->db, 'tbl_base_admin', array(
            "user" => $postVars['adminId'],
            "password" => $postVars['adminPassword'],
            "level" => 1,
        ));
        $this->session->set_flashdata('message', "Create Successfully");
        redirect(base_url() . 'index.php/AdminController/userPage');
    }

    public function actionEditPvp()
    {
        $postVars = $this->utils->inflatePost(array('pvp_edit_group_id', 'pvp_edit_rating', 'pvp_edit_rating_highscore', 'pvp_edit_leader_rank',
            'pvp_edit_win_ratio', 'pvp_edit_match_history', 'pvp_edit_reward_history', 'pvp_edit_uid', 'pvp_edit_pid'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_pvp', array(
            "pvp_group_id" => $postVars['pvp_edit_group_id'],
            "pvp_rating" => $postVars['pvp_edit_rating'],
            "pvp_highscore" => $postVars['pvp_edit_rating_highscore'],
            "pvp_leader_rank" => $postVars['pvp_edit_leader_rank'],
            "pvp_win_ratio" => $postVars['pvp_edit_win_ratio'],
            "pvp_history" => $postVars['pvp_edit_match_history'],
            "pvp_reward_history" => $postVars['pvp_edit_reward_history'],
            "uid" => $postVars['pvp_edit_uid'],
                ), array(
            "no" => $postVars['pvp_edit_pid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditStoryReward()
    {
        $postVars = $this->utils->inflatePost(array('str_edit_name', 'str_edit_claim_status', 'str_edit_uid', 'str_edit_rid'));
        $this->sqllibs->updateRow($this->db, 'tbl_user_progress_rewards', array(
            "reward_id" => $postVars['str_edit_name'],
            "claim_status" => $postVars['str_edit_claim_status'],
            "uid" => $postVars['str_edit_uid'],
                ), array(
            "no" => $postVars['str_edit_rid']
        ));
        $this->session->set_flashdata('message', "Successfully Updated");
        redirect($this->agent->referrer());
    }

    public function actionEditAdmin()
    {
        $postVars = $this->utils->inflatePost(array('adminEditName', 'adminEditId', 'adminEditPermission', 'aid', 'adminEditPassword'));
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_SETTING);
            return;
        }
        if ($this->sqllibs->isExist($this->db, 'tbl_base_admin', array('user' => $postVars['adminEditId']))) {
            $this->session->set_flashdata('errorMessage', lang('text_86'));
            redirect(base_url() . ADMIN_PAGE_SETTING);
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_base_admin', array(
            "user" => $postVars['adminEditId'],
            "password" => $postVars['adminEditPassword'],
            "name" => $postVars['adminEditName'],
            "type" => $postVars['adminEditPermission'],
                ), array(
            "no" => $postVars['aid']
        ));
        $this->session->set_flashdata('message', lang('text_90'));
        redirect(base_url() . ADMIN_PAGE_SETTING);
    }

    public function actionDeleteAdmin($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_admin', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . ADMIN_PAGE_USERS);
    }

    public function actionSetUserPermission($id = null)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage('index.php');
            return;
        }
        if ($id == null) {
            $id = $_POST['userId'];
            $durationDays = $_POST['durationDay'];
            $now = new DateTime();
            $timestamp = $now->getTimestamp();

            if ($durationDays == 0) {
                $timestamp = 0;
            } else {
                $timestamp = $timestamp + $durationDays * 24 * 3600;
            }
            $this->sqllibs->updateRow(
                $this->db,
                'tbl_user',
                array(
                "Status" => 0,
                "LockDuration" => $timestamp,
                    ),
                array('PlayerID' => $id)
            );
            $this->session->set_flashdata('message', "Permission Changed");
            redirect(base_url() . 'index.php/AdminController/userPage');
            return;
        }
        $rtInfo = $this->sqllibs->getOneRow($this->db, 'tbl_user', array('PlayerID' => $id));
        $featureValue = 0;
        if ($rtInfo->status == 0) {
            $featureValue = 1;
        }
        $this->sqllibs->updateRow(
            $this->db,
            'tbl_user',
            array(
            "status" => $featureValue
                ),
            array('PlayerID' => $id)
        );
        if ($featureValue == 1) {
            $this->session->set_flashdata('message', "User Enabled");
        } else {
            $this->session->set_flashdata('message', "User Disabled");
        }
        redirect(base_url() . 'index.php/AdminController/userPage');
    }

    public function actionDeleteUsers($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . ADMIN_PAGE_USERS);
    }

    public function actionLogin()
    {
        if ($this->utils->isEmptyPost(array('user', 'pw'))) {
            $this->session->set_flashdata('errorMessage', "Please fill input.");
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $postVars = $this->utils->inflatePost(array('user', 'pw'));
        if ($this->sqllibs->isExist($this->db, 'tbl_base_admin', array("user" => $postVars['user'], "password" => $postVars['pw']))) {
            $adminInfo = $this->sqllibs->getOneRow($this->db, 'tbl_base_admin', array("user" => $postVars['user'], "password" => $postVars['pw']));
            $this->session->set_userdata(array("adminLogin" => "1"));
            $this->session->set_userdata(array("level" => $adminInfo->level));
            $this->session->set_userdata(array("adminId" => $adminInfo->no));
            $this->utils->redirectPage(ADMIN_PAGE_DASHBOARD);
            return;
        }
        $this->session->set_flashdata('errorMessage', "Login Fail");
        $this->utils->redirectPage(ADMIN_PAGE_HOME);
    }

    public function actionLogout()
    {
        $this->session->set_userdata(array("adminLogin" => ""));
        $this->session->set_userdata(array("level" => ""));
        $this->session->set_userdata(array("adminId" => ""));
        $this->utils->redirectPage(ADMIN_PAGE_HOME);
    }

    public function actionDeleteUser($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_user', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . ADMIN_PAGE_USERS);
    }

    public function actionChangePrice()
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $postVars = $this->utils->inflatePost(array('did', 'priceValue'));
        $this->sqllibs->updateRow($this->db, 'tbl_map_discount_restaurant', array(
            "price" => $postVars['priceValue']
                ), array(
            "no" => $postVars['did']
        ));
        $this->session->set_flashdata('message', "Price Changed");
        redirect(base_url() . ADMIN_PAGE_DISCOUNTS);
    }
}
