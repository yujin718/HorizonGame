<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class GashaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function addGashapon($type)
    {
      if (!$this->isLogin()) {
            $this->utils->redirectPage('index.php/AdminController/userDetailPage/'.$id);
          return;
      }
      $data = $this->getViewParameters("AddGashapon", "Admin");
      $data['type'] = $type;
      switch($type)
      {
          case "basic":
              $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_item_encyclopedia');
              break;
          case "character":
              $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_character');
              break;
          case "equipment":
              $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_equip');
              break;
          case "premium":
              $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_item_encyclopedia');
              break;

      }
      $data = $this->setMessages($data);
      $this->load->view('view_admin', $data);
    }
    public function editGashapon($type,$no)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $data = $this->getViewParameters("EditGashapon", "Admin");
        switch($type)
        {
            case "basic":
                $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_item_encyclopedia');
                $data['itemInfo'] = $this->sqllibs->getOneRow($this->db,'tbl_base_gashapon_basic',array('no' => $no));
                break;
            case "character":
                $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_character');
                $data['itemInfo'] = $this->sqllibs->getOneRow($this->db,'tbl_base_gashapon_character',array('no' => $no));
                break;
            case "equipment":
                $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_equip');
                $data['itemInfo'] = $this->sqllibs->getOneRow($this->db,'tbl_base_gashapon_equip',array('no' => $no));
                break;
            case "premium":
                $data['items'] = $this->sqllibs->selectAllRows($this->db,'tbl_base_item_encyclopedia');
                $data['itemInfo'] = $this->sqllibs->getOneRow($this->db,'tbl_base_gashapon_premium',array('no' => $no));
                break;

        }
        $data['type'] = $type;
        $data = $this->setMessages($data);
        $this->load->view('view_admin', $data);
    }
    public function actionEditRequirement()
    {
        $postVars = $this->utils->inflatePost(array('gashaReqKey','gashaReqActive','gashaReqCurrency','gashaReqQuantity','gashaReqGuarentee','gashaReqRoll','gashaReqCooldown','gashaReqTable'));
        $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon_requirement', array(
            "IsActive" => $postVars['gashaReqActive'],
            "cid" => $postVars['gashaReqCurrency'],
            "Quantity" => $postVars['gashaReqQuantity'],
            "GuaranteedTier" => $postVars['gashaReqGuarentee'],
            "TotalRoll" => $postVars['gashaReqRoll'],
            "Cooldown" => $postVars['gashaReqCooldown'],
            "TableReference" => $postVars['gashaReqTable'],
                ), array(
            "GashaponID" => $postVars['gashaReqKey']
        ));
        redirect($this->agent->referrer());
    }
    public function actionCreateGashapon()
    {
        $postVars = $this->utils->inflatePost(array('gashaIDType','gashaItemID','gashaType','gashaQuantity','gashaTier','gashaWeight'));
        if ($postVars['gashaIDType'] == "basic")
        {
          $this->sqllibs->insertRow($this->db, 'tbl_base_gashapon_basic', array(
              "ItemID" => $postVars['gashaItemID'],
              "Type" => $postVars['gashaType'],
              "Quantity" => $postVars['gashaQuantity'],
              "Tier" => $postVars['gashaTier'],
              "Weight" => $postVars['gashaWeight']
          ));
        }
        else if ($postVars['gashaIDType'] == "character")
        {
          $this->sqllibs->insertRow($this->db, 'tbl_base_gashapon_character', array(
              "ItemID" => $postVars['gashaItemID'],
              "Type" => $postVars['gashaType'],
              "Quantity" => $postVars['gashaQuantity'],
              "Tier" => $postVars['gashaTier'],
              "Weight" => $postVars['gashaWeight']
          ));
        }
        else if ($postVars['gashaIDType'] == "equipment")
        {
          $this->sqllibs->insertRow($this->db, 'tbl_base_gashapon_equip', array(
              "ItemID" => $postVars['gashaItemID'],
              "Type" => $postVars['gashaType'],
              "Quantity" => $postVars['gashaQuantity'],
              "Tier" => $postVars['gashaTier'],
              "Weight" => $postVars['gashaWeight']
          ));
        }
        else if ($postVars['gashaIDType'] == "premium")
        {
          $this->sqllibs->insertRow($this->db, 'tbl_base_gashapon_premium', array(
              "ItemID" => $postVars['gashaItemID'],
              "Type" => $postVars['gashaType'],
              "Quantity" => $postVars['gashaQuantity'],
              "Tier" => $postVars['gashaTier'],
              "Weight" => $postVars['gashaWeight']
          ));
        }
        $this->session->set_flashdata('message', "Create Successful");
        redirect($this->agent->referrer());
    }
    public function actionDeleteGashapon($type,$id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        if ($type == "basic")
        {
          $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon_basic', array(
              "no" => $id
          ));
        }
        else if ($type == "character")
        {
          $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon_character', array(
              "no" => $id
          ));
        }
        else if ($type == "equipment")
        {
          $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon_equip', array(
              "no" => $id
          ));
        }
        else if ($type == "premium")
        {
          $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon_premium', array(
              "no" => $id
          ));
        }
        $this->session->set_flashdata('message', "Delete Successful");
        redirect($this->agent->referrer());
    }

    public function actionEditGashapon()
    {
        $postVars = $this->utils->inflatePost(array('gashaNo','gashaIDType','gashaItemID','gashaType','gashaQuantity','gashaTier','gashaWeight'));
        if ($postVars['gashaIDType'] == "basic")
        {
          $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon_basic', array(
            "ItemID" => $postVars['gashaItemID'],
            "Type" => $postVars['gashaType'],
            "Quantity" => $postVars['gashaQuantity'],
            "Tier" => $postVars['gashaTier'],
            "Weight" => $postVars['gashaWeight']
                  ), array(
              "no" => $postVars['gashaNo']
          ));
        }
        else if ($postVars['gashaIDType'] == "character")
        {
          $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon_character', array(
            "ItemID" => $postVars['gashaItemID'],
            "Type" => $postVars['gashaType'],
            "Quantity" => $postVars['gashaQuantity'],
            "Tier" => $postVars['gashaTier'],
            "Weight" => $postVars['gashaWeight']
                  ), array(
              "no" => $postVars['gashaNo']
          ));
        }
        else if ($postVars['gashaIDType'] == "equipment")
        {
          $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon_equip', array(
            "ItemID" => $postVars['gashaItemID'],
            "Type" => $postVars['gashaType'],
            "Quantity" => $postVars['gashaQuantity'],
            "Tier" => $postVars['gashaTier'],
            "Weight" => $postVars['gashaWeight']
                  ), array(
              "no" => $postVars['gashaNo']
          ));
        }
        else if ($postVars['gashaIDType'] == "premium")
        {
          $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon_premium', array(
            "ItemID" => $postVars['gashaItemID'],
            "Type" => $postVars['gashaType'],
            "Quantity" => $postVars['gashaQuantity'],
            "Tier" => $postVars['gashaTier'],
            "Weight" => $postVars['gashaWeight']
                  ), array(
              "no" => $postVars['gashaNo']
          ));
        }
        $this->session->set_flashdata('message', "Edit Successful");
        redirect($this->agent->referrer());
    }
}
