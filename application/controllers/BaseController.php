<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BaseController extends CI_Controller {

    public $database;

    function __construct() {
        parent::__construct();
        $this->connectDB();

        $this->load->helper('url');
        $this->load->helper('language');
        $this->load->library('session');
        $this->load->library('utils');
        $this->load->library('sqllibs');
        $this->load->library('jsonlibs');
        $this->load->library('stripe');
        $this->load->library('notification');
        $this->load->library('user_agent');
        $this->lang->load("english", "english");
    }

    public function setMessages($data) {
        $data['error'] = $this->session->flashdata('errorMessage');
        $data['message'] = $this->session->flashdata('message');
        $this->session->set_flashdata('errorMessage', "");
        $this->session->set_flashdata('message', "");
        return $data;
    }

    public function isLogin() {
        if ($this->session->adminLogin == "") {
            return false;
        } else {
            return true;
        }
    }

    public function connectDB() {
        $this->database = $this->load->database();
    }

    public function getViewParameters($pageName = '', $role = 'Customer', $title = 'Bruped') {
        $data['title'] = $title;
        $data['pageName'] = $pageName;
        $data['role'] = $role;
        return $data;
    }

    function generateRestaurantArray($restaurants) {
        $rstArray = array();
        $index = 0;
        foreach ($restaurants as $rst) {
            $images = $this->sqllibs->selectAllRows($this->db, 'tbl_image_restaurant', array("rid" => $rst->no));
            $sql = "select A.*,B.name as lang_name from tbl_map_language_restaurant as A left join tbl_base_language as B on A.lid=B.no";
            $langs = $this->sqllibs->rawSelectSql($this->db, $sql);
            $rstExtend = (object) array_merge((array) $rst, array('rs_image' => $images));
            $discounts = $this->sqllibs->selectJoinTables($this->db, array('tbl_map_discount_restaurant', 'tbl_base_discount')
                    , array('did', 'no')
                    , array('rid' => $rst->no)
            );
            $rstExtend = (object) array_merge((array) $rstExtend, array('rs_discounts' => $discounts, 'langs' => $langs));
            $rstArray[$index] = $rstExtend;
            $index++;
        }
        return $rstArray;
    }

}

?>