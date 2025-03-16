<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('load_template')) {
    function load_template($view, $data = array(), $template = 'main') {
        $CI =& get_instance();
        $data['content'] = $CI->load->view($view, $data, TRUE);
        return $CI->load->view('templates/layouts/' . $template, $data);
    }
}

if (!function_exists('load_partial')) {
    function load_partial($partial, $data = array()) {
        $CI =& get_instance();
        return $CI->load->view('templates/partials/' . $partial, $data, TRUE);
    }
}

if (!function_exists('load_component')) {
    function load_component($component, $data = array()) {
        $CI =& get_instance();
        return $CI->load->view('frontend/components/' . $component, $data, TRUE);
    }
}

if (!function_exists('set_page_title')) {
    function set_page_title($title) {
        $CI =& get_instance();
        $CI->template->set('title', $title);
    }
}

if (!function_exists('add_css_file')) {
    function add_css_file($file) {
        $CI =& get_instance();
        $css_files = $CI->template->get('css_files', array());
        $css_files[] = $file;
        $CI->template->set('css_files', $css_files);
    }
}

if (!function_exists('add_js_file')) {
    function add_js_file($file) {
        $CI =& get_instance();
        $js_files = $CI->template->get('js_files', array());
        $js_files[] = $file;
        $CI->template->set('js_files', $js_files);
    }
}

if (!function_exists('add_breadcrumb')) {
    function add_breadcrumb($title, $url = '') {
        $CI =& get_instance();
        $breadcrumbs = $CI->template->get('breadcrumbs', array());
        $breadcrumbs[] = array('title' => $title, 'url' => $url);
        $CI->template->set('breadcrumbs', $breadcrumbs);
    }
} 