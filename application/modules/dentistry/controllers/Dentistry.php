<?php    
date_default_timezone_set('Asia/Kolkata');

class Dentistry extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Dentistry_model');
        $this->load->helper('url');
        $this->load->library('session');
        
    }

    public function index()
    {
        
        $data['clinic']=$this->Dentistry_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);
        
    }

    public function fetchDentistry()
    {
        $data = $row = array();
        $rows = $this->Dentistry_model->getRows_dentistry($_POST);
        foreach ($rows as $users) {
            $data[] = array(  '<img src="'.$users->image.' " width="100" height="100"> ', 
           $users->General_dentistry_name,$users->description,$users->desired_clinic,
        '<i name="update" id="'.$users->id.'" class="fa fa-pencil edit_dentistry makepoint" aria-hidden="true"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_dentistry makepoint" style="margin-left: 20px;" aria-hidden="true"></i>',
  
         );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Dentistry_model->countAll_dentistry($_POST),
            "recordsFiltered" => $this->Dentistry_model->countFiltered_dentistry($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function deleteDentistry()
    {
        // $id=$_POST['id'];
        // $this->Dentistry_model->deleteDentistry($id);
        //  echo true;

         $id = $_POST['id'];
         $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
         $this->Dentistry_model->deleteDentistry($id,$status);

    }

    public function addDentistry()
    {  
        // print_r($_FILES) ;  die;
        $config['upload_path'] = './assets/images/dentistry/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        if(!$this->upload->do_upload('image'))  
        {  
            echo $this->upload->display_errors();  
        }  
        else  
        {  
            $data = $this->upload->data();  

            $picture = array(
            'image'=>'assets/images/dentistry/'.$data['file_name'],'General_dentistry_name'=>$_POST['General_dentistry_name'],
            'clinic_id'=>$_POST['clinic_id'],'created_date'=>date("Y-m-d H:i:s"),
            'description'=>$_POST['Ck_editor_value'],         
                );
        $this->Dentistry_model->addDentistry($picture);
        
        } 
    }

    public function editDentistry()
    {

        $output = array();  
        $data = $this->Dentistry_model->editDentistry($_POST["id"]);  
        foreach($data as $row)  
        {
             $output['id']=$row->id;
             $output['image'] = $row->image;  
             $output['General_dentistry_name'] = $row->General_dentistry_name;  
             $output['clinic_id'] = $row->clinic_id;  
             $output['description'] = $row->description;  


            //  echo $row->category_name or die;
        }  
        echo json_encode($output);

    }

    public function updateDentistry()
    {
       

        if(($_FILES['image']['name']!=="")){ 
            $id=$_POST['id'];
        

            $this->db->where('id',$id);
            $q= $this->db->get('sc_General_dentistry_table')->result()[0];
            $p=$q->{'image'};

            unlink(FCPATH.'/'.$p);

            $config['upload_path'] = './assets/images/dentistry/';  
            $config['allowed_types'] = 'jpg|jpeg|png|gif';  
            $this->load->library('upload', $config);  
            $this->upload->do_upload('image') ; 
            $data = $this->upload->data();  
            $picture = array(
                'image'=>'assets/images/dentistry/'.$_FILES['image']['name'],'General_dentistry_name'=>$_POST['General_dentistry_name'],
               'clinic_id'=>$_POST['clinic_id'],
                'description'=>$_POST['Ck_editor_value'] ,'updated_date'=>date("Y-m-d H:i:s")     
                );
           
            $this->Dentistry_model->updateDentistry($picture,$id);
           
            }
             else{
                $id=$_POST['id'];
                 $this->db->where('id',$id);
                $image_exist= $this->db->get('sc_General_dentistry_table')->result()[0]->image;
              
                        $picture = array(
                            'image'=>$image_exist,'General_dentistry_name'=>$_POST['General_dentistry_name'],
                           'clinic_id'=>$_POST['clinic_id'],
                            'description'=>$_POST['Ck_editor_value'] ,'updated_date'=>date("Y-m-d H:i:s")       
                            );
                        // $this->db->where('id',$id);
                        // $this->db->update('doctor',$data);
                        $this->Dentistry_model->updateDentistry($picture,$id);
                    }
        echo true ;
    }


   
     
  


}






?>