<?php 

date_default_timezone_set('Asia/Kolkata');

class Offers extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Offers_model');
        $this->load->helper('url');
        $this->load->library('session');
        
    }

 

    public function index()
    {
        
        $data['clinic']=$this->Offers_model->getClinic();
        $data['base_url'] = $this->config->item("base_url");
        $this->load->view('header',$data);
        $this->load->view('index',$data);
        $this->load->view('footer',$data);
        
    }

    public function fetchOffers()
    {
        $data = $row = array();
        $rows = $this->Offers_model->getRows_offers($_POST);
        foreach ($rows as $users) {

            if ($users->expiry_date <= date('Y-m-d')) {
                $avilable_status = '<span class="label label-danger">Expired</span>';
            } else {
                $avilable_status = '<span class="label label-success">Available</span>';
            }
            $data[] = array(  '<img src="'.$users->image.' " width="100" height="100"> ', 
           $users->name,$users->promo_code,$users->description,date(" j F Y ", strtotime($users->starting_date)),date(" j F Y ", strtotime($users->expiry_date)),$users->desired_clinic,$avilable_status,
        '<i name="update" id="'.$users->id.'" class="fa fa-pencil edit_offers makepoint" aria-hidden="true"></i> <i name="delete" id="'.$users->id.'" class="fa fa-trash-o delete_offers makepoint" style="margin-left: 20px;" aria-hidden="true"></i>',
  
         );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Offers_model->countAll_offers($_POST),
            "recordsFiltered" => $this->Offers_model->countFiltered_offers($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function deleteOffer()
    {
        
         $id = $_POST['id'];
         $status=array('status'=>0,'deleted_date'=>date("Y-m-d H:i:s"));
         $this->Offers_model->deleteOffer($id,$status);

    }

    public function addOffer()
    {  
        // print_r($_FILES) ;  die;
        $config['upload_path'] = './assets/images/offers/';  
        $config['allowed_types'] = 'jpg|jpeg|png|gif';  
        $this->load->library('upload', $config);  
        if(!$this->upload->do_upload('image'))  
        {  
            echo $this->upload->display_errors();  
        }  
        else  
        {  
            $data = $this->upload->data();  
           $starting_date= date("Y-m-d", strtotime($_POST['starting_date']));
           $expiry_date= date("Y-m-d", strtotime($_POST['expiry_date']));


            $picture = array(
            'image'=>'assets/images/offers/'.$data['file_name'],'name'=>$_POST['name'],'promo_code'=>$_POST['promo_code'],
            'clinic_id'=>$_POST['clinic_id'],'starting_date'=> $starting_date,'expiry_date'=>$expiry_date,
            'description'=>$_POST['Ck_editor_value'],'created_date'=>date("Y-m-d H:i:s")       
                );
        $this->Offers_model->addOffer($picture);
        // echo true;
        } 
    }

    public function editOffer()
    {

        $output = array();  
        $data = $this->Offers_model->editOffer($_POST["id"]);  
        foreach($data as $row)  
        {
             $output['id']=$row->id;
            //  $output['image'] = $row->image;  
             $output['name'] = $row->name;  
             $output['clinic_id'] = $row->clinic_id;  
             $output['description'] = $row->description;  
            //  $output['starting_date'] = $row->starting_date;  
             $output['expiry_date'] = $row->expiry_date;  

             $output['starting_date'] = date("d-m-Y", strtotime( $row->starting_date));
             $output['expiry_date'] = date("d-m-Y", strtotime( $row->expiry_date));

             $output['promo_code'] = $row->promo_code;  

        }  
        echo json_encode($output);

    }

    public function updateOffer()
    {
       

        if(($_FILES['image']['name']!=="")){ 
            $id=$_POST['id'];
            $this->db->where('id',$id);
            $q= $this->db->get('sc_special_offer')->result()[0];
            $p=$q->{'image'};

            unlink(FCPATH.'/'.$p);

            $config['upload_path'] = './assets/images/offers/';  
            $config['allowed_types'] = 'jpg|jpeg|png|gif';  
            $this->load->library('upload', $config);  
            $this->upload->do_upload('image') ; 
            $data = $this->upload->data();  
            $starting_date= date("Y-m-d", strtotime($_POST['starting_date']));
            $expiry_date= date("Y-m-d", strtotime($_POST['expiry_date']));

            $picture = array(
                'image'=>'assets/images/offers/'.$_FILES['image']['name'],'name'=>$_POST['name'],'promo_code'=>$_POST['promo_code'],
               'clinic_id'=>$_POST['clinic_id'],'starting_date'=>$starting_date,'expiry_date'=>$expiry_date,
                'description'=>$_POST['Ck_editor_value'],'updated_date'=>date("Y-m-d H:i:s")       
                );
           
            $this->Offers_model->updateOffer($picture,$id);
           
            }
             else{
                $id=$_POST['id'];
                 $this->db->where('id',$id);
                $image_exist= $this->db->get('sc_special_offer')->result()[0]->image;
                $starting_date= date("Y-m-d", strtotime($_POST['starting_date']));
                $expiry_date= date("Y-m-d", strtotime($_POST['expiry_date']));

                        $picture = array(
                            'image'=>$image_exist,'name'=>$_POST['name'],'promo_code'=>$_POST['promo_code'],
                           'clinic_id'=>$_POST['clinic_id'],'starting_date'=>$starting_date,'expiry_date'=>$expiry_date,
                            'description'=>$_POST['Ck_editor_value'],'updated_date'=>date("Y-m-d H:i:s")       
                            );
                        // $this->db->where('id',$id);
                        // $this->db->update('doctor',$data);
                        $this->Offers_model->updateOffer($picture,$id);
                    }
        echo true ;
    }


   
     
  


}

