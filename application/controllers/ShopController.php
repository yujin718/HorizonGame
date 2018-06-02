<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class ShopController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionCreateShopItem()
    {
        $postVars = $this->utils->inflatePost(array('shopName','shopAmount','shopCost','shopCurrency'));
        $this->sqllibs->insertRow($this->db, 'tbl_base_shop', array(
            "name" => $postVars['shopName'],
            "amount" => $postVars['shopAmount'],
            "cost" => $postVars['shopCost'],
            "currency" => $postVars['shopCurrency'],
        ));
        redirect(base_url() . 'index.php/AdminController/shopPage');
    }

    public function actionDeleteShopItem($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . 'index.php/AdminController/shopPage');
    }

    public function actionEditShopItem()
    {
        $postVars = $this->utils->inflatePost(array('editShopName', 'editShopAmount','editShopCost','editShopId','editShopCurrency'));
        if (!$this->isLogin()) {
            redirect(base_url() . 'index.php/AdminController/serverDataPage');
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_base_shop', array(
            "name" => $postVars['editShopName'],
            "amount" => $postVars['editShopAmount'],
            "cost" => $postVars['editShopCost'],
            "currency" => $postVars['editShopCurrency'],
                ), array(
            "no" => $postVars['editShopId']
        ));
        redirect(base_url() . 'index.php/AdminController/shopPage');
    }
}
