<?php

defined('BASEPATH') or exit('No direct script access allowed');
require 'BaseController.php';

class GashaController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function actionCreateGashapon()
    {
        $postVars = $this->utils->inflatePost(array('gashaName','gashaAmount','gashaCost','gashaMin','gashaMax','gashaType'));
        $this->sqllibs->insertRow($this->db, 'tbl_base_gashapon', array(
            "name" => $postVars['gashaName'],
            "amount" => $postVars['gashaAmount'],
            "cost" => $postVars['gashaCost'],
            "range_min" => $postVars['gashaMin'],
            "range_max" => $postVars['gashaMax'],
            "type" => $postVars['gashaType'],

        ));
        redirect(base_url() . 'index.php/AdminController/gashaponPage');
    }

    public function actionDeleteGashapon($id)
    {
        if (!$this->isLogin()) {
            $this->utils->redirectPage(ADMIN_PAGE_HOME);
            return;
        }
        $this->sqllibs->deleteRow($this->db, 'tbl_base_gashapon', array(
            "no" => $id
        ));
        $this->session->set_flashdata('message', "Delete Successful");
        redirect(base_url() . 'index.php/AdminController/gashaponPage');
    }

    public function actionEditGashapon()
    {
        $postVars = $this->utils->inflatePost(array('editGashaName', 'editGashaAmount','editGashaCost','editGashaCost','editGashaMax','editGahsaId','editGashaType'));
        if (!$this->isLogin()) {
            redirect(base_url() . 'index.php/AdminController/serverDataPage');
            return;
        }
        $this->sqllibs->updateRow($this->db, 'tbl_base_gashapon', array(
            "name" => $postVars['editGashaName'],
            "amount" => $postVars['editGashaAmount'],
            "cost" => $postVars['editGashaCost'],
            "range_min" => $postVars['editGashaCost'],
            "range_max" => $postVars['editGashaMax'],
            "type" => $postVars['editGashaType'],
                ), array(
            "no" => $postVars['editGahsaId']
        ));
        redirect(base_url() . 'index.php/AdminController/gashaponPage');
    }
}
