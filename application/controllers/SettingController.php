<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class SettingController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionCreateInventory()
    {
        $postVars = $this->utils->inflatePost(array('inventoryName'));
        if ($this->sqllibs->isExist($this->db, 'tbl_base_inventory', array('name' => $postVars['inventoryName']))) {
            $this->session->set_flashdata('errorMessage', 'Already exist');
            redirect(base_url() . 'index.php/AdminController/settingPage');
            return;
        }
        $this->sqllibs->insertRow($this->db, 'tbl_base_inventory', array(
            "name" => $postVars['inventoryName'],
        ));
        redirect(base_url() . 'index.php/AdminController/settingPage');
    }

    public function actionCreateCurrency()
    {
        $postVars = $this->utils->inflatePost(array('currencyName'));
        if ($this->sqllibs->isExist($this->db, 'tbl_base_currency', array('name' => $postVars['inventoryName']))) {
            $this->session->set_flashdata('errorMessage', 'Already exist');
            redirect(base_url() . 'index.php/AdminController/settingPage');
            return;
        }
        $this->sqllibs->insertRow($this->db, 'tbl_base_currency', array(
            "name" => $postVars['currencyName'],
        ));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionDeleteInventory($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_inventory', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . 'index.php/AdminController/settingPage');
    }
    public function actionDeleteCurrency($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_currency', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }

    public function actionEditInventory()
    {
        $postVars = $this->utils->inflatePost(array('iid', 'edit_inventoryName'));
        if (!$this->isLogin()) {
            redirect(base_url() . 'index.php/AdminController/settingPage');
            return;
        }
        if ($this->sqllibs->isExist($this->db, 'tbl_base_inventory', array('name' => $postVars['edit_inventoryName']))) {
            $this->session->set_flashdata('errorMessage', 'Duplicate name!');
            redirect(base_url() . 'index.php/AdminController/settingPage');
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_base_inventory', array(
            "name" => $postVars['edit_inventoryName'],
                ), array(
            "no" => $postVars['iid']
        ));
        redirect(base_url() . 'index.php/AdminController/settingPage');
    }

    public function actionEditCurrency()
    {
        $postVars = $this->utils->inflatePost(array('cid', 'edit_currencyName'));
        if (!$this->isLogin()) {
            redirect(base_url() . 'index.php/AdminController/serverDataPage');
            return;
        }
        if ($this->sqllibs->isExist($this->db, 'tbl_base_currency', array('name' => $postVars['edit_currencyName']))) {
            redirect(base_url() . 'index.php/AdminController/serverDataPage');
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_base_currency', array(
            "name" => $postVars['edit_currencyName'],
                ), array(
            "no" => $postVars['cid']
        ));
        redirect(base_url() . 'index.php/AdminController/serverDataPage');
    }
}
