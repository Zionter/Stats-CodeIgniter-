<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller

{
	function __construct()
	{
		parent::__construct(); /* Standard Libraries of codeigniter are required */
		$this->load->database();
		$this->load->helper('url'); /* ------------------ */
		$this->load->library('Log');
		$this->load->library('ion_auth');
		$this->load->library('grocery_CRUD');
	}
	public function index()

	{
		// echo 'Текущая версия PHP: ' . phpversion();
		// echo "<h1>Система управління заявками</h1>"; /*Just an example to ensure that we get into the function */
		die();
	}
	public function _example_output($output = null)

	{
		$this->load->view('requests.php', $output);
	}
	public function stats()

	{
		if (!$this->ion_auth->logged_in() || !($this->ion_auth->is_admin() || $this->ion_auth->in_group('managers')))
		{
			redirect(base_url() . 'index.php/auth/login');
		}
		
		// For dumping
		$developMode = false;
		
		
		// --------------------
		// JavaScript
		// --------------------
		$JS = "
			$(document).ready(function() {
		
			var getPath = window.location.href;

			// check if user selected an select before
			if ((getPath.search('=')) != -1)
			{
				// get index of address string, where '=value'
				var valuePos = getPath.search('=') + 1;

				// get substring
				var value = getPath.substring(valuePos, getPath.length);

				// set
				$('.DepartmentSelect option[value=' + value + ']').prop('selected','selected');
				// set
				$('.UserSelect option[value=' + value + ']').prop('selected','selected');
				// set
				$('.ItemSelect option[value=' + value + ']').prop('selected','selected');
			}

			// when user select goddammit select option to filter data by departments
			$('.DepartmentSelect').change(
				function (e)
				{
					// get selected option value
					var SelectedItem = $('.DepartmentSelect').val();

					// encode to json
					var encodedData = JSON.stringify(SelectedItem);

					// send to codeigniter main.php, method stats, data, return
					$.post('/kt/index.php/main/stats',{'encodedData' : encodedData}, function(response)
					{
					
						// main response of server; (refresh page)
						window.location.href = '/kt/index.php/main/stats?l=' + SelectedItem;
					});

					e.preventDefault();
				}
			);
			
			// when user select goddammit select option to filter data by user
			$('.UserSelect').change(
				function (e)
				{
					// get selected option value
					var SelectedItem = $('.UserSelect').val();

					// encode to json
					var encodedData = JSON.stringify(SelectedItem);

					// send to codeigniter main.php, method stats, data, return
					$.post('/kt/index.php/main/stats',{'encodedData' : encodedData}, function(response)
					{
						// main response of server; (refresh page)
						window.location.href = '/kt/index.php/main/stats?l=' + SelectedItem;
					});

					e.preventDefault();
				}
			);
			
			// when user select goddammit select option to filter data by item
			$('.ItemSelect').change(
				function (e)
				{
					// get selected option value
					var SelectedItem = $('.ItemSelect').val();

					// encode to json
					var encodedData = JSON.stringify(SelectedItem);

					// send to codeigniter main.php, method stats, data, return
					$.post('/kt/index.php/main/stats',{'encodedData' : encodedData}, function(response)
					{
						// main response of server; (refresh page)
						window.location.href = '/kt/index.php/main/stats?l=' + SelectedItem;
					});

					e.preventDefault();
				}
			);

		});";
		
		$output = "<script src='" . base_url() . "assets/grocery_crud/js/jquery-1.10.2.min.js'></script>
		<script src='" . base_url() . "assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js'></script>
		<script src='" . base_url() . "assets/grocery_crud/themes/datatables/js/jquery.dataTables.min.js'></script>";
		$output.= "<script type='text/javascript'>" . $JS . "</script>";
		// End of JS------------
		
		// --------------------
		// Table
		// --------------------
		$output.= "<div class='container'>";
		$output.= "<div class='cla'>";
		$output.= "<h1 class='mainphph1'>Статистика</h1>";
		$output.= "<table class='table' cellspacing='0' style='background:#f5f5f5'>";
		$output.= "<tr><th>Всього заявок в системі</th><td>" . $this->db->get('requests')->num_rows() . "</td></tr>";
		$output.= "<tr><th>Незакритих заявок в системі</th>";
		$this->db->where('completion_status', 'ні');
		$output.= "<td>" . $this->db->get('requests')->num_rows() . "</td></tr>";
		$output.= "</table>";
		$this->db->order_by("cat_name", "asc");
		$equipment = $this->db->get('equipment_categories')->result();
		
		/* FILTERING BEGIN */
		$output.= "<div class='row' >
		<div class='col-md-4 filtration'>";
		
		// -----------------------
		// SELECT BY DEPARTMENT & INSTITUTES
		// -----------------------
		
		$output.= "<h5><span class='glyphicon glyphicon-filter'></span> 
		Фільтрація за Інститутами або відділами.</h5>
		<form role='form' class='form-horizontal form-dataproceed' name='form' enctype='multipart/form-data'><select name='DepartmentSelect' class='form-control DepartmentSelect'>";
		$institute_name = 0;
		$institute_id = 0;
		$totals = $this->db->query("SELECT institute_name,institute_id as instId FROM institutes")->result();
		$output.= "  <option value= 'all'>Усі заявки</option>";
		$depId = 0;
		foreach($totals as $totalsrow)
		{
			$depName = 0;
			$depn = $totalsrow->institute_name;
			$depn1 = $totalsrow->instId;
			$output.= "  <option value='$depn1'>$depn</option>";
			$total = $this->db->query("SELECT dep_name AS depName,dep_id as depId
			                  FROM departments AS dep
			                        INNER JOIN institutes AS inst ON dep.subsidiary_of = inst.institute_id
			                                                  where inst.institute_name ='$depn'")->result(); /*var_dump($total); */
			foreach($total as $totalrow)
			{
				if (!empty($total))
				{
					$output.= "<option   value='d$totalrow->depId'>$totalrow->depName</option>";
				}
			}
		}
		$output.= "</select></form></div>";
		
		// END OF SELECT BY DEPARTMENT & INSTITUTES
		
		// -----------------------
		// SELECT BY USERS
		// -----------------------
		
		$output.= "<div class='col-md-4 filtration'><h5><span class='glyphicon glyphicon-user'></span> 
		Фільтрація за користувачами.</h5><form role='form' class='form-horizontal form-dataproceed' name='form' enctype='multipart/form-data'>";
		$output.= "<select name='UserSelect' class='form-control UserSelect'>";
		$userId = 0;
		$userName = 0;
		$output.= "  <option value= 'all'>Усі користувачі</option>";
		$totals = $this->db->query("SELECT id  ,username FROM users")->result();

		foreach($totals as $totalsrow)
		{
			$depn = $totalsrow->id;
			$depn1 = $totalsrow->username;
			$output.= "<option value='u$depn'>$depn1</option>";
		}
		$output.= "</select></form></div>";
		
		// END SELECT BY USERS
		
		// -----------------------
		// BY ORDER ITEM
		// -----------------------
		
		$output.= "<div class='col-md-4 filtration'><h5><span class='glyphicon glyphicon-shopping-cart'></span> 
		Фільтрація за обладнням.</h5><form role='form' class='form-horizontal form-dataproceed' name='form' enctype='multipart/form-data'>";
		$output.= "<select name='ItemSelect' class='form-control ItemSelect'>";
		$output.= "  <option value= 'all'>Усе обладнання</option>";
		$totals = $this->db->query("SELECT cat_id  ,cat_name FROM equipment_categories")->result();
		
		foreach($totals as $totalsrow)
		{
			$depn = $totalsrow->cat_id;
			$depn1 = $totalsrow->cat_name;
			$output.= "<option value='e$depn'>$depn1</option>";
		}
		$output.= "</select></form></div>";
		
		// END BY ORDER ITEM
		
		$output.= "</div>";
		
		// END OF ALL FILTERING
		
		$output.= "</table> </div>";
		if ($developMode == true) var_dump($_GET);
		
		/*
		working old fucking asshole query
		his author  mamky ebal
		query("SELECT equip_cat, SUM( requested_amount ) AS reqsum, SUM( fulfilled_amount ) AS fullfillsum, dep.dep_name AS departments, inst.institute_name AS institutes
		FROM requests AS req
		INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
		INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id
		GROUP BY equip_cat
		ORDER BY equip_cat ASC")->result();
		*/
		
		/*            here starts table with fucking rows*/
		$val = 0;
		foreach($_GET as $k => $v)
		{
			if ($_GET['l'])
			{
				$val = $_GET['l'];
			}
		}
		
		// var_dump($val);
		if (!is_numeric(substr($val, 0, 1)))
		{
			$res2 = substr($val, 0, 1);
			
			$res = substr($val, 1, strlen($val));
			if ($res2 == 'd')
			{
				$totals = $this->db->query("Select cat.cat_name AS equipment_categories, requested_amount AS reqsum, fulfilled_amount AS fullfillsum, uses.username AS submitter_acctid, dep.dep_name AS departments, inst.institute_name AS institutes
FROM requests AS req
INNER JOIN equipment_categories AS cat ON req.equip_cat = cat.cat_id
INNER JOIN users AS uses ON req.submitter_acctid = uses.id
INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id
		                                      where   dep.dep_id='$res'")->result();
			}
			if ($res2 == 'u')
			{
				$totals = $this->db->query("Select cat.cat_name AS equipment_categories, requested_amount AS reqsum, fulfilled_amount AS fullfillsum, uses.username AS submitter_acctid, dep.dep_name AS departments, inst.institute_name AS institutes
FROM requests AS req
INNER JOIN equipment_categories AS cat ON req.equip_cat = cat.cat_id
INNER JOIN users AS uses ON req.submitter_acctid = uses.id
INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id
		                                      where   uses.id='$res'")->result();
			}
			if ($res2 == 'e')
			{
				$totals = $this->db->query("Select cat.cat_name AS equipment_categories, requested_amount AS reqsum, fulfilled_amount AS fullfillsum, uses.username AS submitter_acctid, dep.dep_name AS departments, inst.institute_name AS institutes
FROM requests AS req
INNER JOIN equipment_categories AS cat ON req.equip_cat = cat.cat_id
INNER JOIN users AS uses ON req.submitter_acctid = uses.id
INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id
		                                      where   cat.cat_id='$res'")->result();
			}
		}
		$total2 = 0;
		if ($val == 'all')
		{
			//echo $val;
			if ($developMode == true) var_dump($totals);
			$totals = $this->db->query("SELECT cat.cat_name AS equipment_categories, requested_amount AS reqsum, fulfilled_amount AS fullfillsum, uses.username AS submitter_acctid, dep.dep_name AS departments, inst.institute_name AS institutes
FROM requests AS req
INNER JOIN equipment_categories AS cat ON req.equip_cat = cat.cat_id
INNER JOIN users AS uses ON req.submitter_acctid = uses.id
INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id        ")->result();
		}
		else if (is_numeric(substr($val, 0, 1)))
		{
			//echo "institute <br>";
			$totals = $this->db->query("SELECT cat.cat_name AS equipment_categories, requested_amount AS reqsum, fulfilled_amount AS fullfillsum, uses.username AS submitter_acctid, dep.dep_name AS departments, inst.institute_name AS institutes
FROM requests AS req
INNER JOIN equipment_categories AS cat ON req.equip_cat = cat.cat_id
INNER JOIN users AS uses ON req.submitter_acctid = uses.id
INNER JOIN departments AS dep ON req.submitter_departmentid = dep.dep_id
INNER JOIN institutes AS inst ON req.submitter_instituteid = inst.institute_id
		                                      where   inst.institute_id='$val'")->result();
		}
		$equip_cat = 0;
		$fullfillsum = 0;
		$reqsum = 0;
		$output.= "<table class='table table-bordered table-hover statst' cellspacing='0'>";
		$output.= "<tr><th><strong>Обладнання</strong></th><th>Замовлено</th><th>Виконано</th>><th>Різниця</th><th>user</th><th>insti</th><th>kafedra</th></tr>";
		foreach($totals as $eqrow)
		{
			$output.= "<tr>";
			$output.= "<td><strong>{$eqrow->equipment_categories}</strong></td><td>{$eqrow->reqsum}</td><td>{$eqrow->fullfillsum}</td><td>" . ($eqrow->reqsum - $eqrow->fullfillsum) . "</td>
										<td>{$eqrow->submitter_acctid}</td>
										<td>{$eqrow->departments}</td>
										                <td>{$eqrow->institutes}</td>";
			$output.= "</tr>";
		}
		/*            here end of table with fucking rows*/
		$siteroot = getenv('HTTP_HOST');
		$this->_example_output((object)array(
			'js_files' => array() ,
			'css_files' => array(
				"http://{$siteroot}/kt/assets/custom/table.css"
			) ,
			'output' => $output
		));
	}
	public function institutes()

	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect(base_url() . 'index.php/auth/login');
		}
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('institutes');
		$this->grocery_crud->set_subject('інститут');
		$this->grocery_crud->columns('institute_name');
		$this->grocery_crud->display_as('institute_name', 'Назва інституту');
		$this->grocery_crud->required_fields('institute_name');
		$this->grocery_crud->callback_before_delete(array(
			$this,
			'institute_predelete_callback'
		));
		$this->grocery_crud->set_lang_string('delete_error_message', 'Інститут не видалено так як він має підрозділи та/або заявки або помилка БД');
		$this->grocery_crud->set_crud_url_path(site_url(strtolower(__CLASS__ . "/" . __FUNCTION__)) , site_url(strtolower(__CLASS__ . "/institutes")));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	public function institute_predelete_callback($primary_key)

	{
		$this->db->where('submitter_instituteid', $primary_key);
		$query1 = $this->db->get('requests')->row();
		$this->db->where('subsidiary_of', $primary_key);
		$query2 = $this->db->get('departments')->row();
		if (empty($query1) && empty($query2))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function departments()

	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect(base_url() . 'index.php/auth/login');
		}
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('departments');
		$this->grocery_crud->set_subject('підрозділ');
		$this->grocery_crud->columns('dep_name', 'subsidiary_of');
		$this->grocery_crud->display_as('dep_name', 'Назва підрозділу');
		$this->grocery_crud->display_as('subsidiary_of', 'інститут підрозділу');
		$this->grocery_crud->set_relation('subsidiary_of', 'institutes', 'institute_name');
		$this->grocery_crud->set_lang_string('delete_error_message', 'Підрозділ не видалено так як він має заявки або помилка БД');
		$this->grocery_crud->callback_before_delete(array(
			$this,
			'department_predelete_callback'
		));
		$this->grocery_crud->required_fields('dep_name');
		$this->grocery_crud->set_crud_url_path(site_url(strtolower(__CLASS__ . "/" . __FUNCTION__)) , site_url(strtolower(__CLASS__ . "/departments")));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	public function department_predelete_callback($primary_key)

	{
		$this->db->where('submitter_departmentid', $primary_key);
		$query = $this->db->get('requests')->row();
		if (empty($query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function equipcategories()

	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect(base_url() . 'index.php/auth/login');
		}
		$this->grocery_crud->set_theme('datatables');
		$this->grocery_crud->set_table('equipment_categories');
		$this->grocery_crud->set_subject('обладнання');
		$this->grocery_crud->columns('cat_name');
		$this->grocery_crud->display_as('cat_name', 'Назва обладнання');
		$this->grocery_crud->required_fields('cat_name');
		$this->grocery_crud->set_lang_string('delete_error_message', 'Тип обладнання не видалено так як він має заявки або помилка БД');
		$this->grocery_crud->callback_before_delete(array(
			$this,
			'equipcat_predelete_callback'
		));
		$this->grocery_crud->set_crud_url_path(site_url(strtolower(__CLASS__ . "/" . __FUNCTION__)) , site_url(strtolower(__CLASS__ . "/equipcategories")));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	public function equipcat_predelete_callback($primary_key)

	{
		$this->db->where('equip_cat', $primary_key);
		$query = $this->db->get('requests')->row();
		if (empty($query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function requests()

	{
		if (!$this->ion_auth->logged_in())
		{
			redirect(base_url() . 'index.php/auth/login');
		}
		if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('managers'))
		{
			$this->grocery_crud->where('submitter_acctid', $this->ion_auth->user()->row()->id);
		}
		$this->grocery_crud->set_theme('flexigrid');
		$this->grocery_crud->set_table('requests');
		$this->grocery_crud->set_subject('заявку');
		$this->grocery_crud->columns('request_id', 'submit_date', 'equip_cat', 'requested_amount', 'fulfilled_amount', 'submitter_acctid', 'submitter_instituteid', 'submitter_departmentid', 'description', 'room', 'completion_status', 'completion_date', 'attached_fileurl');
		$this->grocery_crud->display_as('request_id', '№ заявки');
		$this->grocery_crud->display_as('submit_date', 'Подано');
		$this->grocery_crud->display_as('equip_cat', 'Обладнання');
		$this->grocery_crud->set_relation('equip_cat', 'equipment_categories', 'cat_name');
		$this->grocery_crud->display_as('requested_amount', 'Замовлено');
		$this->grocery_crud->display_as('fulfilled_amount', 'Придбано');
		$this->grocery_crud->display_as('submitter_acctid', 'Заявник'); /*$this->grocery_crud->set_relation('submitter_acctid','users','{username} - {last_name} {first_name}');*/
		$this->grocery_crud->callback_column('submitter_acctid', array(
			$this,
			'requests_callback_submitter_column'
		));
		$this->grocery_crud->display_as('submitter_instituteid', 'Інститут');
		$this->grocery_crud->set_relation('submitter_instituteid', 'institutes', 'institute_name');
		$this->grocery_crud->display_as('submitter_departmentid', 'Підрозділ');
		$this->grocery_crud->set_relation('submitter_departmentid', 'departments', 'dep_name');
		$this->grocery_crud->display_as('description', 'Додаткова інформація');
		$this->grocery_crud->display_as('room', 'Аудиторія');
		$this->grocery_crud->display_as('completion_status', 'Виконання');
		$this->grocery_crud->display_as('completion_date', 'Дата закриття');
		$this->grocery_crud->display_as('attached_fileurl', 'Файл');
		$this->grocery_crud->set_field_upload('attached_fileurl', 'uploads'); /*$this->grocery_crud->fields('request_id','submit_date','equip_cat','requested_amount','fulfilled_amount','submitter_acctid','submitter_instituteid','submitter_departmentid','description','room','completion_status','completion_date');        $this->grocery_crud->field_type('request_id','invisible'); */
		$this->grocery_crud->required_fields('equip_cat', 'submitter_instituteid' /*,'submitter_departmentid','room'*/);
		if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('managers'))
		{
			$this->grocery_crud->field_type('completion_status', 'hidden');
			$this->grocery_crud->field_type('fulfilled_amount', 'hidden');
		}
		$this->grocery_crud->unset_add_fields('completion_status', 'fulfilled_amount');
		if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('managers'))
		{
			$this->grocery_crud->field_type('submit_date', 'hidden');
		}
		if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('managers'))
		{
			$this->grocery_crud->field_type('completion_date', 'hidden');
		}
		$this->grocery_crud->field_type('submitter_acctid', 'hidden');
		$this->grocery_crud->callback_before_insert(array(
			$this,
			'requests_insert_callback'
		));
		$this->grocery_crud->callback_before_update(array(
			$this,
			'requests_update_callback'
		));
		$this->grocery_crud->set_crud_url_path(site_url(strtolower(__CLASS__ . "/" . __FUNCTION__)) , site_url(strtolower(__CLASS__ . "/requests")));
		$output = $this->grocery_crud->render();
		$this->_example_output($output);
	}
	function requests_callback_submitter_column($value, $row)
	{
		if (!is_null($value))
		{
			$this->db->where('id', $value);
			$usrdata = $this->db->get('users')->row();
			return $usrdata->last_name . " " . $usrdata->first_name;
		}
	}
	function requests_insert_callback($post_array)
	{
		if ((!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('managers')) || is_null($post_array['submit_date']))
		{
			$post_array['submit_date'] = date('Y-d-m');
		}
		$post_array['submitter_acctid'] = $this->ion_auth->user()->row()->id;
		return $post_array;
	}
	function requests_update_callback($post_array, $primary_key)
	{
		if ($post_array['completion_status'] == 'так')
		{
			$this->db->select('completion_status');
			$this->db->where('request_id', $primary_key);
			$query = $this->db->get('requests')->row();
			if (!empty($query) && $query->completion_status != "так")
			{
				$post_array['completion_date'] = date('Y-d-m');
			}
		}
		return $post_array;
	}
} 
/* End of file main.php */ 
/* Location: ./application/controllers/main.php */
