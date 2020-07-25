<?php    
class Offers_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_special_offer';
        $this->column_order = array('image','name','promo_code', 'description','starting_date','expiry_date', 'desired_clinic');
        // Set searchable column fields
        $this->column_search =  array('name','promo_code', 'description', 'desired_clinic','starting_date','expiry_date');
        // Set default order
        $this->order = array('id' => 'asc');
    }

    public function getRows_offers($postData)
    {
        $this->_get_datatables_query_offers($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function countAll_offers()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function countFiltered_offers($postData)
    {
        $this->_get_datatables_query_offers($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }


    private function _get_datatables_query_offers($postData)
    {
        $this->db->where('sc_special_offer.status',1);

        $this->db->select('sc_special_offer.*,sc_desired_clinic.desired_clinic');
        $this->db->from($this->table);
        $this->db->join('sc_desired_clinic', 'sc_special_offer.clinic_id = sc_desired_clinic.id');
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('clinic_id', $_SESSION['clinic']);
        }
        // $this->db->from($this->table);

        $i = 0;
        // loop searchable columns 
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function deleteOffer($id,$status)
    {
        // $this->db->where('id', $id);
        // $q =  $this->db->get('special_offer')->result()[0];
        // $p = $q->{'image'};
        // unlink(FCPATH . '/' . $p);


        // $this->db->where('id', $id);
        // $this->db->delete('special_offer');

        $this->db->where('id',$id);
        $q= $this->db->update('sc_special_offer',$status);
         if ($q==true){
             echo true;
             }
           else{
             echo false;
             }
    }
    public function addOffer($picture)
    {
       $q= $this->db->insert('sc_special_offer', $picture);
       if ($q==true){
        echo true;
        }
      else{
        echo false;
        }
        // return true;
        // if($q){
        //     return true;
        // }else{
        //     return false;
        // }

    }

    public function editOffer($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('sc_special_offer');
        return $q->result();
    }

    public function updateOffer($member, $id)
    {
        
        $this->db->where('id', $id);
       $q= $this->db->update('sc_special_offer', $member);
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
