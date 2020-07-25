<?php
class Doctors_model extends CI_Model
{
    public function __construct()
    {

        // Set orderable column fields
        $this->table = 'sc_doctor';
        $this->column_order = array('image', 'Lname','FName', 'phone', 'doctor_description', 'desired_clinic');
        // Set searchable column fields
        $this->column_search = array('Lname','FName', 'phone', 'doctor_description', 'desired_clinic');
        // Set default order
        $this->order = array('id' => 'asc');
    }

    public function getRows_doctor($postData)
    {
        $this->_get_datatables_query_doctor($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getclinicRows_doctor($postData)
    {
        $this->_get_datatables_query_doctorTiming($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function countAll_doctor()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function countFiltered_doctor($postData)
    {
        $this->_get_datatables_query_doctor($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function _get_datatables_query_doctor($postData)
    {
        // $this->db->where('doctor.status',1);
        $this->db->select('sc_doctor.*,sc_desired_clinic.desired_clinic,sc_doctor_working.clinic_id,sc_doctor_working.status as doctstatus,
        sc_doctor_working.id as doctid');
        $this->db->from($this->table);
        $this->db->join('sc_doctor_working', 'sc_doctor.id = sc_doctor_working.doctor_id', 'left');

        $this->db->join('sc_desired_clinic', 'sc_doctor_working.clinic_id = sc_desired_clinic.id', 'left');

        // $this->db->join('schedule', 'sc_doctor.ProvNum = schedule.ProvNum', 'left');

        if ($_SESSION['usertype'] == 2) {
            $this->db->where('sc_doctor_working.clinic_id', $_SESSION['clinic']);
        }
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



    public function addDoctor($picture)
    {
        $q = $this->db->insert('sc_doctor', $picture);

        $insert_id = $this->db->insert_id();


        if ($this->session->userdata('usertype') == 1) {

            foreach ($_POST['clinic_id'] as $clinic_id) {

                $data = array(
                    'clinic_id' => $clinic_id, 'doctor_id' => $insert_id
                );
            }
        } else {
            $data = array(
                'clinic_id' => $_POST['clinic_id'], 'doctor_id' => $insert_id
            );
            $this->db->insert('sc_doctor_working', $data);
        }
    }

    public function editDoctor($id)
    {
        $this->db->where('id', $id);
        $q = $this->db->get('sc_doctor');
        return $q->result();
    }

    public function updateDoctor($data, $id)//// abhi working wali condition hta de
    {
        $this->db->where('id', $id);
        $q = $this->db->update('sc_doctor', $data);
        // if ($this->session->userdata('usertype') == 1) {
        //     if (!empty($_POST['clinic_id'])) {
        //         $this->db->where('doctor_id', $id);
        //         $q = $this->db->delete('sc_doctor_working');

        //         foreach ($_POST['clinic_id'] as $clinic_id) {
        //             $doctorUpdate = array(
        //                 'clinic_id' => $clinic_id, 'doctor_id' => $id
        //             );
        //             $this->db->insert('sc_doctor_working', $doctorUpdate);
        //         }
        //     }
        // }
    }


    public function deleteDoctor($id, $status)
    {
        $this->db->where('id', $id);
        $q = $this->db->update('sc_doctor', $status);
        if ($q == true) {
            echo true;
        } else {
            echo false;
        }
    }

    public function getClinic()
    {
        if ($_SESSION['usertype'] == 2) {
            $this->db->where('id', $_SESSION['clinic']);
            $q = $this->db->get('sc_desired_clinic')->result();
            return $q;
        } else {
            $q = $this->db->get('sc_desired_clinic')->result();
            return $q;
        }
    }

    public function fetch_all_event($id)
    {
        // $this->db->where('status',1);
        $this->db2 = $this->load->database('second', TRUE); 
        // $this->db2->where('ProvNum',$id);
        // // $this->db->order_by('id');
        // return $this->db2->get('appointment')->result();


        $this->db2->select('appointment.*,patient.*,schedule.*');
        $this->db2->from('appointment'); 
        // $this->db2->join('appointment', 'schedule.ProvNum=appointment.ProvNum', 'left');
        // ek kaam kar ...abhi ye rehne de...aur clinic wala kaam kr.. kaise kru wo
        $this->db2->join('schedule', 'schedule.ProvNum=appointment.ProvNum',  'left');
        $this->db2->join('patient', 'appointment.PatNum = patient.PatNum', 'left');


        $this->db2->where('appointment.ProvNum',$id);
        $this->db2->where('schedule.ProvNum',$id);
        // $this->db2->where('patient.ProvNum',$id);




        $data = $this->db2->get();
        return $data;
        // print_r($data);die;


   

      

    }

    // public function fetch_all_events($id)
    // {


    //     $this->db2 = $this->load->database('second', TRUE);

    //     $this->db2->select('appointment.*,schedule.*');
    //     $this->db2->from('schedule'); 
    //     $this->db2->join('appointment', 'schedule.ProvNum=appointment.ProvNum',  'left');



    //     $this->db2->where('schedule.ProvNum',$id);
    //     return $this->db2->get();



    // //     $this->db2->select('appointment.*,patient.*');
    // //     $this->db2->from('appointment'); 
    // //     $this->db2->join('patient', 'appointment.PatNum = patient.PatNum', 'left');
    // //     $this->db2->where('appointment.ProvNum',$id);


    // //     $data = $this->db2->get();
    // //     return $data;
    // }

    public  function insert_event($data)
    {
        $this->db->insert('sc_doctor_appointment', $data);
    }

    public  function update_event($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('sc_doctor_appointment', $data);
    }

    public  function delete_event($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('sc_doctor_appointment', $data);
    }
    public function insertdoc($data)
    {
        $this->db->insert('sc_doctor_working', $data);
    }

    public function checkMobile($mobile)
    {
        $sql = "SELECT count(*) as count From sc_doctor Where phone = '$mobile'";
        $select = $this->db->query($sql);
        echo $select->result_array()[0]['count'];
    }

    public function add_doctor()
    {
        $data = $this->db2->get('provider')->result_array();
        foreach ($data as $row) {
            $id = $row['ProvNum'];
            // print_r($id);
            $this->db->where('ProvNum', $id);
            $q = $this->db->get('sc_doctor')->num_rows();
            $sc_doc_data = $this->db->get('sc_doctor')->result();
            // print_r($sc_doc_data);
            // if(!empty($sc_doc_data)){ ab krde bind
            // foreach ($sc_doc_data as $key) {
            if (array_search($id, array_column($sc_doc_data, 'ProvNum')) === false) {
                $providerdata = array('ProvNum' => $row['ProvNum'], 'LName' => $row['LName'], 'FName' => $row['FName']);
                $this->db->insert('sc_doctor', $providerdata);
                echo true;
            }else{
                echo false;
            }
         
        }
    }
}
