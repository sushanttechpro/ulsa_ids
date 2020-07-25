<?php    
class Braces_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_Braces_post_op';
        $this->column_order = array( 'Braces_post_op','desired_clinic','link');
        // Set searchable column fields
        $this->column_search = array('Braces_post_op','desired_clinic','link');
        // Set default order
        $this->order = array('id' => 'asc');
    }
 
    public function getRows_braces($postData){
        $this->_get_datatables_query_braces($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function countAll_braces(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    
    
    public function countFiltered_braces($postData){
        $this->_get_datatables_query_braces($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    private function _get_datatables_query_braces($postData){
        $this->db->where('sc_Braces_post_op.status',1);
        $this->db->select('sc_Braces_post_op.*,sc_desired_clinic.desired_clinic');
        $this->db->from($this->table);
        $this->db->join('sc_desired_clinic', 'sc_Braces_post_op.clinic_id = sc_desired_clinic.id'); 
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('clinic_id', $_SESSION['clinic']);
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

    public function edit_braces($id){
        $this->db->where('id',$id);
        $q=$this->db->get('sc_Braces_post_op');
        return $q->result();
    }
   
    public function update_braces_data($inputs,$id){
        $this->db->where('id',$id);
        $output = $this->db->update('sc_Braces_post_op',$inputs);
        return $output;
    }

    public function delete_braces_data($id,$status){
        // $this->db->where('id',$id);
        // $this->db->delete('Braces_post_op');

        $this->db->where('id',$id);
       $q= $this->db->update('sc_Braces_post_op',$status);
        if ($q==true){
            echo true;
            }
          else{
            echo false;
            }
    }

    public function add_braces_data($inputs){
        $this->db->insert('sc_Braces_post_op',$inputs);
        return true;
    }

    public function getClinic()
    {
       

        if ($_SESSION['usertype'] == 2) {
            $this->db->where('id', $_SESSION['clinic']);
            $q= $this->db->get('sc_desired_clinic')->result();
     
        return $q;
        }  else{
            $q= $this->db->get('sc_desired_clinic')->result();
     
        return $q;

        }
    }
  
}
