
<?php    
date_default_timezone_set('Asia/Kolkata');

class Clinic extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Clinic_model');
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    public function index()
    {
        $data['doctors']=$this->Clinic_model->getDoctor();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);


        
    }

    public function fetchClinic()
    
    {
        $data = $row = array();
        $rows = $this->Clinic_model->getRows_clinic($_POST);
        foreach ($rows as $users) {
            $data[] = array( '<img src="'.$users->image.' "  style="width:80px;height:80px;border-radius:80px; "> ','<img src="'.$users->logo.' "  style="width:80px;height:80px;border-radius:80px; "> ',  
                  $users->desired_clinic,$users->clinic_email, '<a href="tel:'.$users->clinic_phoneno.' ">'.$users->clinic_phoneno.'</a>',$users->working_hours,
                   $users->clinic_address, 
                   ' <a href="' . $this->config->item("base_url") . 'clinic/servicetype?id=' . $users->id . ' " class=""><i class="fa fa-plus-square" aria-hidden="true"></i></a>',
         '<i name="update" id="'.$users->id.'" class="fa fa-pencil edit_clinic makepoint" aria-hidden="true"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_clinic makepoint" style="margin-left: 10px;" aria-hidden="true"></i>',
  
         );
        }
        

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Clinic_model->countAll_clinic($_POST),
            "recordsFiltered" => $this->Clinic_model->countFiltered_clinic($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function editClinic(){
        $output = array();  
        $data = $this->Clinic_model->editClinic($_POST["id"]); 
        foreach($data as $row)  
        {
             $output['id']=$row->id;
             $output['desired_clinic'] = $row->desired_clinic; 
             $output['working_hours'] = $row->working_hours; 
             $output['clinic_email'] = $row->clinic_email; 
             $output['clinic_phoneno'] = $row->clinic_phoneno; 
             $output['clinic_address'] = $row->clinic_address; 
             $output['latitude'] = $row->latitude; 
             $output['longitude'] = $row->longitude; 



        }  
        echo json_encode($output);
    }

    public function updateClinic(){
       
    if(($_FILES['image']['name']!=="") and ($_FILES['logo']['name']!=="")){ 
        $id=$_POST['id'];
    
        //      $this->db->where('id',$id);
        // $r=  $this->db->get('desired_clinic')->result()[0];
        // $i=$r->{'image'};
        // unlink(FCPATH.'/'.$i);


        // $this->db->where('id',$id);
        // $f=  $this->db->get('desired_clinic')->result()[0];
        // $logo=$f->{'logo'};
        // unlink(FCPATH.'/'.$logo);

        $config['upload_path'] = './assets/images/clinic/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        $this->upload->do_upload('image') ; 
        $this->upload->do_upload('logo') ; 
        $data = $this->upload->data();  

        $picture = array(
            'desired_clinic'=>$_POST['desired_clinic'],'logo'=>'assets/images/clinic/'.$_FILES['logo']['name'],
            'image'=>'assets/images/clinic/'.$_FILES['image']['name'],'clinic_email'=>$_POST['clinic_email'],'latitude'=>$_POST['clinic_lat'],'longitude'=>$_POST['clinic_long'],
        'clinic_phoneno'=>$_POST['clinic_phoneno'],'clinic_address'=>$_POST['clinic_address'],
        'working_hours'=>$_POST['Ck_editor_value'], 'updated_date'=>date("Y-m-d H:i:s")      
            );
            $this->Clinic_model->updateClinic($picture,$id);

    }elseif(  ($_FILES['image']['name']!=="") and($_FILES['logo']['name']=="")  ){

        $id=$_POST['id'];

        $this->db->where('id',$id);
        $link=  $this->db->get('sc_desired_clinic')->result()[0];
        $image=$link->{'image'};
        unlink(FCPATH.'/'.$image);

        $config['upload_path'] = './assets/images/clinic/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        $this->upload->do_upload('image') ; 
        $datas = $this->upload->data();  
    
            $picture = array(
                'desired_clinic'=>$_POST['desired_clinic'],
            'clinic_email'=>$_POST['clinic_email'],'latitude'=>$_POST['clinic_lat'],'longitude'=>$_POST['clinic_long'],
            'clinic_phoneno'=>$_POST['clinic_phoneno'],'clinic_address'=>$_POST['clinic_address'],'image'=>'assets/images/clinic/'.$_FILES['image']['name'],
            'working_hours'=>$_POST['Ck_editor_value'], 'updated_date'=>date("Y-m-d H:i:s")      
                );
       
        $this->Clinic_model->updateClinic($picture,$id);
   
    }elseif(  ($_FILES['logo']['name']!=="") and ($_FILES['image']['name']=="")){
        $id=$_POST['id'];

        $this->db->where('id',$id);
        $links=  $this->db->get('sc_desired_clinic')->result()[0];
        $logos=$links->{'logo'};
        unlink(FCPATH.'/'.$logos);

        $config['upload_path'] = './assets/images/clinic/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        $this->upload->do_upload('logo') ; 
        $datas = $this->upload->data();  

        $this->db->where('id',$id);
        // $image_logo= $this->db->get('desired_clinic')->result()[0]->logo;
        $image_exist= $this->db->get('desired_clinic')->result()[0]->image;

        $picture = array(
            'desired_clinic'=>$_POST['desired_clinic'],
        'clinic_email'=>$_POST['clinic_email'],'latitude'=>$_POST['clinic_lat'],'longitude'=>$_POST['clinic_long'],  'image'=>$image_exist,
        'clinic_phoneno'=>$_POST['clinic_phoneno'],'clinic_address'=>$_POST['clinic_address'],'logo'=>'assets/images/clinic/'.$_FILES['logo']['name'],
        'working_hours'=>$_POST['Ck_editor_value'], 'updated_date'=>date("Y-m-d H:i:s")      
            );
   
        $this->Clinic_model->updateClinic($picture,$id);
          } else{
            $id=$_POST['id'];
             $this->db->where('id',$id);
            $image_exist= $this->db->get('sc_desired_clinic')->result()[0]->image;

            $this->db->where('id',$id);
            $image_logo= $this->db->get('sc_desired_clinic')->result()[0]->logo;

            
            $picture = array(
                'desired_clinic'=>$_POST['desired_clinic'],
                'image'=>$image_exist,'clinic_email'=>$_POST['clinic_email'],'latitude'=>$_POST['clinic_lat'],'longitude'=>$_POST['clinic_long'],
            'clinic_phoneno'=>$_POST['clinic_phoneno'],'clinic_address'=>$_POST['clinic_address'],'logo'=>$image_logo,
            'working_hours'=>$_POST['Ck_editor_value'] ,'updated_date'=>date("Y-m-d H:i:s")      
                );
                $this->Clinic_model->updateClinic($picture,$id);
                }
        echo true ;
        }

    public function deleteClinic()
    {
        // $id=$_POST['id'];
        // $this->Clinic_model->deleteClinic($id);
        // echo true;
        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Clinic_model->deleteClinic($id,$status);
    }

    public function addClinic(){

        $config['upload_path'] = './assets/images/clinic/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        if(!$this->upload->do_upload('image'))  
        {  
            echo $this->upload->display_errors();  
        }  
        else  
        {  
            $data = $this->upload->data();  
        }
        if(!$this->upload->do_upload('logo'))  
        {  
            echo $this->upload->display_errors();  
        }  
        else  
        {  
            $datas = $this->upload->data(); 
            $picture = array(
                'desired_clinic'=>$_POST['desired_clinic'],
            'image'=>'assets/images/clinic/'.$data['file_name'],'clinic_email'=>$_POST['clinic_email'],
            'latitude'=>$_POST['clinic_lat'],'longitude'=>$_POST['clinic_long'],
            'clinic_phoneno'=>$_POST['clinic_phoneno'],'clinic_address'=>$_POST['clinic_address'],
            'working_hours'=>$_POST['Ck_editor_value'],  'logo'=>'assets/images/clinic/'.$datas['file_name'],
            'created_date'=>date("Y-m-d H:i:s")      
                );
        $this->Clinic_model->addClinic($picture);
        echo true;
        } 
    }


    
    public function checkEmail()
    {
        $email=$_POST['clinic_email'];
		$data=$this->Clinic_model->checkEmail($email);
		if ($data==true){
            echo true;
        }
        else{
            echo false;
        }
    }

    public function checkMobile()
    {
        $mobile=$_POST['clinic_phoneno'];
        $this->Clinic_model->checkMobile($mobile);
    }

    public function servicetype()
    {
        $data['id'] = $_GET['id'];
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('servicetype',$data);
        $this->load->view('footer',$data);
    }

    public function Fetchservice_type()
    {
        $data = $row = array();
        $rows = $this->Clinic_model->getRows_appoinmenttype($_POST);
        foreach ($rows as $users) {
            $data[] = array( $users->service_type,$users->service_description,
         '<i name="update" id="'.$users->id.'" class="fa fa-pencil edit_service makepoint" aria-hidden="true"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_service makepoint" style="margin-left: 20px;" aria-hidden="true"></i>',
  
         );
        }
        

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Clinic_model->countAll_appoinmenttype($_POST),
            "recordsFiltered" => $this->Clinic_model->countFiltered_appoinmenttype($_POST),
            "data" => $data,
        );
        echo json_encode($output);

    }

    public function insertservices()
    {
       
        $data=array('service_type'=>$_POST['service_type'],'service_description'=>$_POST['service_description'],
        'clinic_id'=>$_POST['id'],'created_date'=>date("Y-m-d H:i:s"));
            $this->Clinic_model->insertservices($data);

    }
    public function editService()
    {

        $output = array();  
        $data = $this->Clinic_model->editService($_POST["id"]); 
        foreach($data as $row)  
        {
            $output['id']=$row->id;
            $output['service_type'] = $row->service_type;
            $output['service_description'] = $row->service_description;
        }  
        echo json_encode($output);
    }

    public function updateService()
    {
        $id=$_POST['id'];
        $data=array('service_type'=>$_POST['service_type'],'service_description'=>$_POST['service_description'],
        'updated_date'=>date("Y-m-d H:i:s")
        );
        $this->Clinic_model->updateService($data,$id);
    }

    public function deleteService()
    {
        $id = $_POST['id'];
        $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
        $this->Clinic_model->deleteService($id,$status);
    }

}