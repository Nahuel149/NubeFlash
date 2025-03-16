<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('html_status_badge')) {
    function html_status_badge($status, $text = '') {
        $classes = array(
            'active' => 'badge badge-success',
            'inactive' => 'badge badge-danger',
            'pending' => 'badge badge-warning',
            'completed' => 'badge badge-info',
            'cancelled' => 'badge badge-secondary'
        );
        
        $texts = array(
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        );
        
        $class = isset($classes[$status]) ? $classes[$status] : 'badge badge-secondary';
        $label = !empty($text) ? $text : (isset($texts[$status]) ? $texts[$status] : ucfirst($status));
        
        return '<span class="' . $class . '">' . $label . '</span>';
    }
}

if (!function_exists('html_icon_button')) {
    function html_icon_button($icon, $text = '', $url = '#', $class = 'btn-primary', $attributes = array()) {
        $attrs = '';
        foreach ($attributes as $key => $value) {
            $attrs .= ' ' . $key . '="' . $value . '"';
        }
        
        return '<a href="' . $url . '" class="btn ' . $class . '"' . $attrs . '>
            <i class="' . $icon . '"></i>' . (!empty($text) ? ' ' . $text : '') . '
        </a>';
    }
}

if (!function_exists('html_action_buttons')) {
    function html_action_buttons($actions = array()) {
        $html = '<div class="btn-group action-buttons">';
        foreach ($actions as $action) {
            $icon = isset($action['icon']) ? $action['icon'] : '';
            $text = isset($action['text']) ? $action['text'] : '';
            $url = isset($action['url']) ? $action['url'] : '#';
            $class = isset($action['class']) ? $action['class'] : 'btn-secondary';
            $attrs = isset($action['attributes']) ? $action['attributes'] : array();
            
            $html .= html_icon_button($icon, $text, $url, $class, $attrs);
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('html_data_table')) {
    function html_data_table($headers = array(), $data = array(), $options = array()) {
        $table_class = isset($options['table_class']) ? $options['table_class'] : 'table table-striped';
        $empty_message = isset($options['empty_message']) ? $options['empty_message'] : 'No data available';
        
        $html = '<div class="table-responsive">';
        $html .= '<table class="' . $table_class . '">';
        
        // Headers
        if (!empty($headers)) {
            $html .= '<thead><tr>';
            foreach ($headers as $header) {
                $html .= '<th>' . $header . '</th>';
            }
            $html .= '</tr></thead>';
        }
        
        // Body
        $html .= '<tbody>';
        if (!empty($data)) {
            foreach ($data as $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    $html .= '<td>' . $cell . '</td>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="' . count($headers) . '" class="text-center">' . $empty_message . '</td></tr>';
        }
        $html .= '</tbody>';
        
        $html .= '</table>';
        $html .= '</div>';
        
        return $html;
    }
}

if (!function_exists('html_alert')) {
    function html_alert($message, $type = 'info', $dismissible = true) {
        $class = 'alert alert-' . $type;
        if ($dismissible) {
            $class .= ' alert-dismissible fade show';
        }
        
        $html = '<div class="' . $class . '" role="alert">';
        $html .= $message;
        
        if ($dismissible) {
            $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $html .= '<span aria-hidden="true">&times;</span>';
            $html .= '</button>';
        }
        
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('html_card')) {
    function html_card($title = '', $content = '', $footer = '', $options = array()) {
        $card_class = isset($options['card_class']) ? ' ' . $options['card_class'] : '';
        $header_class = isset($options['header_class']) ? ' ' . $options['header_class'] : '';
        $body_class = isset($options['body_class']) ? ' ' . $options['body_class'] : '';
        $footer_class = isset($options['footer_class']) ? ' ' . $options['footer_class'] : '';
        
        $html = '<div class="card' . $card_class . '">';
        
        if (!empty($title)) {
            $html .= '<div class="card-header' . $header_class . '">' . $title . '</div>';
        }
        
        $html .= '<div class="card-body' . $body_class . '">' . $content . '</div>';
        
        if (!empty($footer)) {
            $html .= '<div class="card-footer' . $footer_class . '">' . $footer . '</div>';
        }
        
        $html .= '</div>';
        return $html;
    }
} 