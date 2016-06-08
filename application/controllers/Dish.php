<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dish extends CI_Controller
{
	function __construct()
    {
        // Construct our parent class
        parent::__construct();
				$this->load->helper(array('form','url'));
				$this->load->model('Dish_Model');

    }
	function index()
		{
			if($this->session->userdata('logged_in'))
			 {
				 $this->load->model('dish_model');
				 $data['list'] = $this->dish_model->dish_id_name_image();
				 $this->load->view('sample_navbar_view');
				 $this->load->view('dishes_view', $data);

	 }
		 else
		 {
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
	function dish_add()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		$config = array(
											array(
											 'field'   => 'DishName',
											 'label'   => 'Dish Name',
											 'rules'   => 'required|callback_dish_check'
											),
											array(
											 'field'   => 'DishType',
											 'label'   => 'Dish Type',
											 'rules'   => 'required'
											),
											array(
													'field'   => 'DishImage',
													'label'   => 'DishImage',
													'rules'   => ''
													 )
											);

				$this->form_validation->set_rules($config);

				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('sample_navbar_view');
					$this->load->view('dish_add');
					return FALSE;
				}
				else
				{

					$file_name = $this->do_upload();
	//			echo 'file_name';
				//	echo $file_name;
					$data = array(
		 'DISH_NAME' => $this->input->post('DishName'),
		 'DISH_TYPE' => $this->input->  post('DishType'),
		 'DISH_IMAGE'=> $file_name
 );

 			$this->load->model('dish_model');
 		  $this->dish_model->dish_add($data);

					return TRUE;
				}
			}
		function dish_check($dishname)
		{
					$this->load->model('dish_model');
					$result = $this->dish_model->check_dish_name($dishname);

					if($result > 0)
					{
						return FALSE;
					}
					else
						{
							return TRUE;
						}
			}
			function do_upload()
				{
							 $config['upload_path']          = './assets/images/dishes';
							 $config['allowed_types']        = 'gif|jpg|png';
							 $config['max_size']             = 20000;
							 $config['max_width']            = 750;
							 $config['max_height']           = 450;

							 $this->load->library('upload', $config);

					 if ( ! $this->upload->do_upload('DishImage'))
					 {
									 $error = array('error' => $this->upload->display_errors());
									 $this->load->view('error_restaurant_edit', $error);
					 }
					 else
					 {
									 $data = array('upload_data' => $this->upload->data());

									 $this->load->view('success_view', $data);
					 }
						$file_name =  $this->upload->file_name;
						return $file_name;
			 }
}

?>