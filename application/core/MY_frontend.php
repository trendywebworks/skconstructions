<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');
class MY_frontend extends CI_Controller {
    private $menu_ul = 1;
    public function __construct() {
        parent::__construct();
        $this->_output['settings'] = $this->db->select('*')->get('settings')->row();
        //$this->_output['products_footer'] = $this->db->where("product_status", 1)->limit(8)->order_by("product_id", "RANDOM")->get("product");
        $this->_output['menu'] = $this->menu_generate();
    }
    function menu_generate() {
        $retun_array = new stdClass();
        $this->_output["menus_items"] = $this->db->
                        order_by("mm_priority", "asc")->
                        where("mm_pos =", "top")->
                        get('menu')->result_array();
        $this->_output["bottom_items"] = $this->db->
                        order_by("mm_priority", "asc")->
                        where("mm_pos", "bot")->
                        get('menu')->result_array();
        $this->_output["about_items"] = $this->db->
                        order_by("mm_priority", "asc")->
                        where("mm_pos", "about")->
                        get('menu')->result_array();
        $retun_array->Top = $this->generate_li($this->_output['menus_items']);
        $retun_array->Bottom = $this->generate_li_bt($this->_output['bottom_items']);
        $retun_array->Bottom_about = $this->generate_li_about($this->_output['about_items']);
        return $retun_array;
    }
    function generate_li($product, $parent = NULL) {
        $li = "";
        $i = 1;
        $p1 = array_filter($product, function($a)use($parent) {
            return $a['mm_child'] == $parent;
        });
        if ($this->menu_ul == 0) {
            $ul_open = '<ul class="dropdown">';
            $ul_close = "</ul>";
        } else {
            $this->menu_ul = 0;
            $ul_open = "";
            $ul_close = "";
        }
        foreach ($p1 as $p) {
            $inner_li = "";
            $classs = "";
            $class = "";
            $caret = "";
            $p2 = array_filter($product, function($a)use($p) {
                return $a['mm_child'] == $p['mm_id'];
            });
            if ($p2) {
                $inner_li = $this->generate_li($product, $p['mm_id']);
                $class = '';
                $caret = ' <span class="caret"></span>';
            }
            if ($p['mm_type'] === 'sub') {
                $url = base_url($p['mm_slug'] . '-' . $p['mm_id']);
                $active = ($url==current_url())?'active':'';
            }else {
                if(strpos($p['mm_url'], "http://") !== false){
                    $url = prep_url($p['mm_url']);
                    $last = explode("/", $p['mm_url']);
                    $last = $last[1];
                    $active = ($last==$this->uri->segment(1))?'active':'';
                }else if($p['mm_url']=='#'){
                   $url = $p['mm_url'];
                   $active ='';
                }
                else{
                   $url = base_url($p['mm_url']);
                   $active = ($url==current_url())?'active':'';
                }
            }

            if($class !="" || $active!='')
                $classs='class="'.$class.' '.$active.'"';
            $li .= '<li ' . $classs . '><a href="' . $url . '">' . $p['mm_name'] .$caret. "</a>" . $inner_li . "</li>";
        }
        $ol = $ul_open . $li . $ul_close;
        return $ol;
    }
    function generate_li_bt($product, $parent = NULL) {
        $li = "";
        $i = 1;
        $ul_open = '<ul>';
        $ul_close = "</ul>";
        $p1 = array_filter($product, function($a)use($parent) {
            return $a['mm_child'] == $parent;
        });
        foreach ($p1 as $p) {
            $inner_li = "";
            $class = "";
            $p2 = array_filter($product, function($a)use($p) {
                return $a['mm_child'] == $p['mm_id'];
            });
            if ($p2) {
                $inner_li = $this->generate_li($product, $p['mm_id']);
                $class = 'class="nav-submenu"';
            }
            if ($p['mm_type'] === 'sub') {
                $url = base_url($p['mm_slug'] . '-' . $p['mm_id']);
            } else {
                $url = prep_url($p['mm_url']);
            }
            $li .= '<li ' . $class . '><a href="' . $url . '">' . $p['mm_name'] . "</a>" . $inner_li . "</li>";
        }
       // $ol = $ul_open . $li . $ul_close;
      //  return $ol;
        return $li;
    }
    function generate_li_about($product, $parent = NULL) {
        $li = "";
        $i = 1;
        $ul_open = '<ul>';
        $ul_close = "</ul>";
        $p1 = array_filter($product, function($a)use($parent) {
            return $a['mm_child'] == $parent;
        });
        foreach ($p1 as $p) {
            $inner_li = "";
            $class = "";
            $p2 = array_filter($product, function($a)use($p) {
                return $a['mm_child'] == $p['mm_id'];
            });
            if ($p2) {
                $inner_li = $this->generate_li($product, $p['mm_id']);
                $class = 'class="nav-submenu"';
            }
            if ($p['mm_type'] === 'sub') {
                $url = base_url($p['mm_slug'] . '-' . $p['mm_id']);
            } else {
                $url = prep_url($p['mm_url']);
            }
            $li .= '<li ' . $class . '><a href="' .  BASE_URL . 'about">' . $p['mm_name'] . "</a>" . $inner_li . "</li>";
        }
        $ol = $li;
        return $ol;
    }
}
