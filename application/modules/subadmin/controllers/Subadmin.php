<?php  

date_default_timezone_set('Asia/Kolkata');

class Subadmin extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Subadmin_model');
        $this->load->helper('url','date');
        // $this->load->helper('date');
        $this->load->library('session');
        
    }

    public function index()
    {
        $data['clinic']=$this->Subadmin_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);
        
    }

    public function fetchSubadmin()
    {
        $data = $row = array();
        $rows = $this->Subadmin_model->getRows_users($_POST);
        foreach ($rows as $users) {
            $data[] = array($users->name,$users->lastname,
           $users->email,'<a href="tel:'.$users->phone.' ">'.$users->phone.'</a>',$users->desired_clinic,
    '
        <i name="update" id="'.$users->id.'" class="fa fa-pencil editsubadmin makepoint" aria-hidden="true" style="margin-left: 20px;"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o deletesubadmin makepoint" style="margin-left: 20px;" aria-hidden="true"></i>', 
         );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Subadmin_model->countAll_users($_POST),
            "recordsFiltered" => $this->Subadmin_model->countFiltered_users($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function insertUser()
    { 
        $Token=substr(md5(uniqid(mt_rand(), true)), 0, 15);
            $data=array('name'=>$_POST['name'],'lastname'=>$_POST['lastname'],'email'=>$_POST['email'],'phone'=>$_POST['phone'],'usertype'=>2,'token'=>$Token,'desired_clinic'=>$_POST['desired_clinic'],
            'push_notification_state'=>0,'special_notification'=>0,'created_date'=>date("Y-m-d H:i:s"),
            'password'=>base64_encode($_POST['password'])
            );
            $this->Subadmin_model->insertUser($data);
            
    }

    public function editSubadmin()
    {
        $output = array();  
           $data = $this->Subadmin_model->editSubadmin($_POST["id"]);  
           foreach($data as $row)  
           {
                $output['id']=$row->id;
                $output['name'] = $row->name;  
                $output['email']=$row->email;
                $output['phone']=$row->phone;
                $output['lastname']=$row->lastname;
                $output['password']=$row->password;
                $output['desired_clinic']=$row->desired_clinic;
           }  
           echo json_encode($output);
    }

    public function updateSubadmin()
    {
        $id=$_POST['id'];
        $data=array('name'=>$_POST['name'],'lastname'=>$_POST['lastname'], 'updated_date'=>date("Y-m-d H:i:s"),
        'email'=>$_POST['email'],'phone'=>$_POST['phone'],'desired_clinic'=>$_POST['desired_clinic'],'updated_date'=>date("Y-m-d H:i:s"));
        $this->Subadmin_model->updateSubadmin($id,$data);
        
    }

    public function deleteSubadmin()
    {
        // $id=$_POST['id'];
        // $this->Subadmin_model->deleteSubadmin($id);

        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Subadmin_model->deleteSubadmin($id,$status);
        
    }

    public function change_user_status()
    {
        if($_POST['prop'] == "false")
        {
            $this->db->where('id',$_POST['id']);
            $this->db->update('users',array('status'=>0));
        }
        else
        {
            $this->db->where('id',$_POST['id']);
            $this->db->update('users',array('status'=>1));
        }
    }

    public function viewModule()
    {
        $data['module']=$this->Subadmin_model->Module();
        $data['subModule']=$this->Subadmin_model->subModule();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('view',$data);
        $this->load->view('footer',$data);

    }


   
     
  


}






?>