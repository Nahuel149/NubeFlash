<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load system form helper first
require_once FCPATH . 'system/helpers/form_helper.php';

if (!function_exists('form_group')) {
    function form_group($label, $input, $error = '', $options = array()) {
        $group_class = isset($options['group_class']) ? ' ' . $options['group_class'] : '';
        $label_class = isset($options['label_class']) ? ' ' . $options['label_class'] : '';
        $input_class = isset($options['input_class']) ? ' ' . $options['input_class'] : '';
        $error_class = isset($options['error_class']) ? ' ' . $options['error_class'] : ' text-danger';
        
        $html = '<div class="form-group' . $group_class . '">';
        
        if (!empty($label)) {
            $html .= '<label class="form-label' . $label_class . '">' . $label . '</label>';
        }
        
        $html .= '<div class="input-wrapper' . $input_class . '">' . $input . '</div>';
        
        if (!empty($error)) {
            $html .= '<div class="form-error' . $error_class . '">' . $error . '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('form_input_group')) {
    function form_input_group($input, $addon = '', $position = 'right', $options = array()) {
        $group_class = isset($options['group_class']) ? ' ' . $options['group_class'] : '';
        $addon_class = isset($options['addon_class']) ? ' ' . $options['addon_class'] : '';
        
        $html = '<div class="input-group' . $group_class . '">';
        
        if ($position === 'left' && !empty($addon)) {
            $html .= '<div class="input-group-prepend">';
            $html .= '<span class="input-group-text' . $addon_class . '">' . $addon . '</span>';
            $html .= '</div>';
        }
        
        $html .= $input;
        
        if ($position === 'right' && !empty($addon)) {
            $html .= '<div class="input-group-append">';
            $html .= '<span class="input-group-text' . $addon_class . '">' . $addon . '</span>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('form_buttons')) {
    function form_buttons($buttons = array(), $options = array()) {
        $wrapper_class = isset($options['wrapper_class']) ? ' ' . $options['wrapper_class'] : '';
        
        $html = '<div class="form-buttons' . $wrapper_class . '">';
        foreach ($buttons as $button) {
            $type = isset($button['type']) ? $button['type'] : 'submit';
            $text = isset($button['text']) ? $button['text'] : 'Submit';
            $class = isset($button['class']) ? $button['class'] : 'btn-primary';
            $attrs = isset($button['attributes']) ? $button['attributes'] : array();
            
            $attributes = '';
            foreach ($attrs as $key => $value) {
                $attributes .= ' ' . $key . '="' . $value . '"';
            }
            
            $html .= '<button type="' . $type . '" class="btn ' . $class . '"' . $attributes . '>';
            if (isset($button['icon'])) {
                $html .= '<i class="' . $button['icon'] . '"></i> ';
            }
            $html .= $text . '</button>';
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('form_select2')) {
    function form_select2($name, $options = array(), $selected = '', $extra = array()) {
        $CI =& get_instance();
        
        // Add Select2 CSS and JS if not already added
        add_css_file('assets/backend/bower_components/select2/dist/css/select2.min.css');
        add_js_file('assets/backend/bower_components/select2/dist/js/select2.min.js');
        
        $class = isset($extra['class']) ? $extra['class'] . ' select2' : 'select2';
        $extra['class'] = $class;
        
        $html = form_dropdown($name, $options, $selected, $extra);
        
        // Add initialization script
        $script = '
            <script>
                $(document).ready(function() {
                    $("#' . (isset($extra['id']) ? $extra['id'] : $name) . '").select2({
                        theme: "bootstrap"
                    });
                });
            </script>
        ';
        
        return $html . $script;
    }
}

if (!function_exists('form_datepicker')) {
    function form_datepicker($name, $value = '', $extra = array()) {
        $CI =& get_instance();
        
        // Add Datepicker CSS and JS if not already added
        add_css_file('assets/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');
        add_js_file('assets/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
        
        $class = isset($extra['class']) ? $extra['class'] . ' datepicker' : 'datepicker';
        $extra['class'] = $class;
        
        $html = form_input($name, $value, $extra);
        
        // Add initialization script
        $script = '
            <script>
                $(document).ready(function() {
                    $("#' . (isset($extra['id']) ? $extra['id'] : $name) . '").datepicker({
                        format: "yyyy-mm-dd",
                        autoclose: true,
                        todayHighlight: true
                    });
                });
            </script>
        ';
        
        return $html . $script;
    }
}

if (!function_exists('form_upload_image')) {
    function form_upload_image($name, $value = '', $preview = true, $extra = array()) {
        $CI =& get_instance();
        
        $class = isset($extra['class']) ? $extra['class'] . ' custom-file-input' : 'custom-file-input';
        $extra['class'] = $class;
        
        $html = '<div class="custom-file">';
        $html .= form_upload($name, $value, $extra);
        $html .= '<label class="custom-file-label" for="' . (isset($extra['id']) ? $extra['id'] : $name) . '">';
        $html .= isset($extra['placeholder']) ? $extra['placeholder'] : 'Choose file';
        $html .= '</label>';
        $html .= '</div>';
        
        if ($preview && !empty($value)) {
            $html .= '<div class="image-preview mt-2">';
            $html .= '<img src="' . base_url($value) . '" alt="Preview" class="img-thumbnail" style="max-height: 150px;">';
            $html .= '</div>';
        }
        
        return $html;
    }
} 