<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Dish extends CI_Controller
{
    public function __construct()
    {
        // Construct our parent class
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('Dish_Model');
    }
    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $this->load->model('dish_model');
            $data['list'] = $this->dish_model->dish_id_name_image();
            $this->load->view('sample_navbar_view');
            $this->load->view('dishes_view', $data);
        } else {
            //If no session, redirect to login page
                         redirect('login', 'refresh');
        }
    }

    /*function dish_register()
    {
        $this->load->view('sample_navbar_view');
        $this->load->view('dish_add');
    }
*/
    public function dish_add()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $config = array(
                                            array(
                                             'field' => 'DishName',
                                             'label' => 'Dish Name',
                                             'rules' => 'required|callback_dish_check',
                                            ),
                                            array(
                                             'field' => 'DishType',
                                             'label' => 'Dish Type',
                                             'rules' => 'required',
                                            ),
                                            array(
                                                    'field' => 'DishImage',
                                                    'label' => 'DishImage',
                                                    'rules' => '',
                                                     ),
                                            );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            $this->load->view('sample_navbar_view');
            $this->load->view('dish_add');

            return false;
        } else {
            $file_name = $this->do_upload();
    //			echo 'file_name';
                //	echo $file_name;
                    $data = array(
         'DISH_NAME' => $this->input->post('DishName'),
         'DISH_TYPE' => $this->input->post('DishType'),
         'DISH_IMAGE' => $file_name,
 );

            $this->load->model('dish_model');
            $this->dish_model->dish_add($data);

            return true;
        }
    }
    public function dish_check($dishname)
    {
        $this->load->model('dish_model');
        $result = $this->dish_model->check_dish_name($dishname);

        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function do_upload()
    {
        $config['upload_path'] = './assets/images/dishes';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 20000;
        $config['max_width'] = 700;
        $config['max_height'] = 5000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('DishImage')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('sample_navbar_view');
            $this->load->view('error_restaurant_edit', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('sample_navbar_view');
            $this->load->view('success_view', $data);
        }
        $file_name = $this->upload->file_name;

        return $file_name;
    }
    public function dish_delete()
    {
        $this->load->view('sample_navbar_view');
        $this->load->model('dish_model');
                    //Get ID and Name to populate combobox
                    $data['list'] = $this->dish_model->edit_dish();
        $this->load->view('dish_delete', $data);
    }

    public function dish_delete_data()
    {
        $id = $this->input->post('SelectDish');
        $this->load->model('dish_model');
        $this->dish_model->dish_delete($id);
        $this->index();
    }
    public function dish_edit()
    {
        $this->load->view('sample_navbar_view');
        $this->load->model('dish_model');
        $data['list'] = $this->dish_model->edit_dish();
        $this->load->view('dish_edit', $data);
    }

    public function dish_ajax()
    {
        $this->load->model('dish_model');
        $this->dish_model->dish_ajax();
    }

    public function dish_edit_data()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $config = array(
                                                    array(
                                                     'field' => 'DishName',
                                                     'label' => 'Dish Name',
                                                     'rules' => 'required',
                                                    ),
                                                    array(
                                                     'field' => 'DishType',
                                                     'label' => 'Dish Type',
                                                     'rules' => '',
                                                    ),
                                                    );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            $this->load->view('sample_navbar_view');
            $this->load->view('error_restaurant_edit');

            return false;
        } else {
            $id = $this->input->post('SelectDish');
            $data = array(
                                                         'DISH_NAME' => $this->input->post('DishName'),
                                                         'DISH_TYPE' => $this->input->post('DishType'),

                                                        );
            $this->load->model('dish_model');
            $this->dish_model->dish_edit($data, $id);
            $this->index();

            return true;
        }
    }
    public function sucess()
    {
        $this->load->view('sample_navbar_view');
        $this->load->view('success_view');
    }

    public function dish_add_xml()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

        $config = array(
                                                array(
                                                 'field' => 'DishName',
                                                 'label' => 'Dish Name',
                                                 'rules' => 'required|callback_dish_check',
                                                ),
                                                array(
                                                 'field' => 'DishType',
                                                 'label' => 'Dish Type',
                                                 'rules' => 'required',
                                                ),
                                                array(
                                                        'field' => 'DishImage',
                                                        'label' => 'DishImage',
                                                        'rules' => '',
                                                         ),
                                                );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == false) {
            $this->load->view('sample_navbar_view');
            $this->load->view('dish_add');

            return false;
        } else {
            $file_name = $this->do_upload();
        //			echo 'file_name';
                    //	echo $file_name;
                    $data = array(
         'DISH_NAME' => $this->input->post('DishName'),
         'DISH_TYPE' => $this->input->post('DishType'),
         'DISH_IMAGE' => $file_name,
     );

            $this->load->model('dish_model');
            $this->dish_model->dish_add_xml($data);
    //			$this->dish_model->dish_add($data);

 print_r($data);

// CODIGO PARA INSERIR NO PROCEDIMENTO O XML

                        return true;
        }
    }
    public function dish_add_xml_direct()
    {
        $xml = $this->input->post('xmldata');
        $this->load->model('dish_model');
        $this->dish_model->dish_add_xml_direct($xml);
    }
}
