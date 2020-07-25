<?php    
class Chat_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_users';
        $this->column_order = array( 'name','lastname','email','phone','desired_clinic.desired_clinic');
        // Set searchable column fields
        $this->column_search = array('name','lastname','phone','email','desired_clinic.desired_clinic');
        // Set default order
        $this->order = array('sc_users.created_date' => 'asc');  
    }
 
    public function getRows_users($postData){
        $this->_get_datatables_query_users($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        // $this->db->where('usertype',2);
        $query = $this->db->get();
        return $query->result();
 
    }
    
    
    public function countAll_users(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_users($postData){
        $this->_get_datatables_query_users($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_users($postData){
        // $this->db->where('usertype',3);


        $this->db->select('sc_users.*,sc_desired_clinic.desired_clinic ');
        $this->db->from($this->table);
        $this->db->join('sc_desired_clinic', 'sc_users.desired_clinic = sc_desired_clinic.id'); 
        $this->db->where('sc_users.status',1);


        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_users.desired_clinic', $_SESSION['clinic']);
            $this->db->where('usertype',3);


        } else if($_SESSION['usertype'] == 2){
            $this->db->where('!usertype',1);
            // $this->db->where('usertype',2);


        }

        // $this->db->from($this->table);
 
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function message($id)
    {
        $this->db->where('user_id',$id);
        $q= $this->db->get('sc_message_table')->result();
        return $q;
    }

    public function messageRefresh($id)
    {
        $this->db->where('from_user_id',$id);
        $this->db->order_by('created_date','DESC');
        $q= $this->db->get('sc_message_table')->result();
        return $q;
    }

    public function countAll_messaage($id){
        // if ($_SESSION['usertype'] == 2) {
        //     $this->db->where('clinic_id', $_SESSION['clinic']);
        // }
        // $this->db->select()
        $this->db->where('from_user_id',$id);
        $this->db->from('sc_message_table');
        
        return $this->db->get()->num_rows();
    }
}