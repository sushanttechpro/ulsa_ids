<?php    
date_default_timezone_set('Asia/Kolkata');

class Braces extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Braces_model');
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    public function index()
    {
        $data['clinic']=$this->Braces_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);


        
    }

    public function fetchBraces()
    {
        $data = $row = array();
        $rows = $this->Braces_model->getRows_braces($_POST);
        foreach ($rows as $users) {
            $data[] = array(  $users->Braces_post_op,$users->desired_clinic,$users->link,
           
            // ' <a href="' . $this->config->item("base_url") . 'users/edit_User?id=' . $users->id . ' " class="btn btn-primary edit"> <i class="fa fa-pencil"></i>Edit</a>',
 
         '<i name="update" id="'.$users->id.'" class="fa fa-pencil edit_brace makepoint" aria-hidden="true"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_braces makepoint" style="margin-left: 20px;" aria-hidden="true"></i>',
  
         );
        }
        

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Braces_model->countAll_braces($_POST),
            "recordsFiltered" => $this->Braces_model->countFiltered_braces($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function edit_braces(){
        $output = array();  
        $data = $this->Braces_model->edit_braces($_POST["id"]); 
        foreach($data as $row)  
        {
             $output['id']=$row->id;
             $output['Braces_post_op'] = $row->Braces_post_op;  
             $output['clinic_id'] = $row->clinic_id;  

             $output['link'] = $row->link;  
        }  
        echo json_encode($output);
    }

    public function update_braces(){
        $id=$_POST['id'];
        $this->db->where('id',$id);
        $inputs = array(
            'Braces_post_op'=>$_POST['braces_name'],
            'link'=>$_POST['youlink'],'clinic_id'=>$_POST['clinic_id'] ,'updated_date'=>date("Y-m-d H:i:s")          
            );
        $result = $this->Braces_model->update_braces_data($inputs,$id);
        echo $result;
    }

    public function delete_braces()
    {
        // $id=$_POST['id'];
        // $this->Braces_model->delete_braces_data($id);
        // echo true;

        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Braces_model->delete_braces_data($id,$status);
    }

    public function add_braces(){

        // $url=var_dump(parse_url($_POST['braces_link']));
        
        // print_r($url);die;
        $inputs = array(
            'Braces_post_op'=>$_POST['braces_name_add'],
            'link'=>$_POST['braces_link'],'clinic_id'=>$_POST['clinic_id'],'created_date'=>date("Y-m-d H:i:s")       
                );
        $this->Braces_model->add_braces_data($inputs);
        echo true;
    }
}