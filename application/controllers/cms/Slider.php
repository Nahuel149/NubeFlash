<?php

class Slider extends CI_Controller
{

    private $permisos;

    function __construct()
    {
        parent::__construct();
        $this->permisos = $this->permisos_lib->control();
        $this->load->model('slider_model','slider');
    }

    function index()
    {

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'results'            => $this->slider->get()
        );

        $vista_externa = array(
            'title' => ucwords("slider"),
            'contenido_main' => $this->load->view('components/cms/slider/slider_list', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function add()
    {

        if ($this->input->post('enviar_form')) {

            $imagen = $this->backend_lib->imagen_upload_simple('imagen', 'img_slider');

            $data = array(
                'name' => $this->input->post('nombre'),
                'image' => $imagen,
            );

            $this->slider->insert($data);

            redirect(base_url('cms/slider'),'refresh');

        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos
        );

        $vista_externa = array(
            'title' => ucwords("slider"),
            'contenido_main' => $this->load->view('components/cms/slider/slider_add', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);

    }

    function edit($id)
    {

        if ($this->input->post('enviar_form')) {

            $data = array(
                'name' => $this->input->post('nombre'),
            );

            if (!empty($_FILES['imagen']['tmp_name'])) {
                $data['image'] = $this->backend_lib->imagen_upload_simple('imagen', 'img_slider');
            }    

            $this->slider->edit($data, $id);

            redirect(base_url('cms/slider'),'refresh');

        }

        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->slider->find($id)
        );

        $vista_externa = array(
            'title'          => ucwords("slider"),
            'contenido_main' => $this->load->view('components/cms/slider/slider_edit', $vista_interna, true)
        );

        $this->load->view('template/backend', $vista_externa);
    }

    function view($id)
    {
        $vista_interna = array(
            'permisos_efectivos' => $this->permisos,
            'result' => $this->slider->find($id)
        );

        $vista_externa = array(
            'title'          => ucwords("slider"),
            'contenido_main' => $this->load->view('components/cms/slider/slider_view', $vista_interna, true)
        );

        $this->load->view('template/view', $vista_externa);

    }

    function delete($id)
    {
        $slider_estado = array(
            'active' => DELETE,
        );
        $this->slider->edit($slider_estado, $id);
    }

}
