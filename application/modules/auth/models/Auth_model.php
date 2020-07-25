<?php
class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    public function check_user_id($email)
    {
        $sql = "SELECT count(*) as count From sc_users Where email = '$email'";
        $select = $this->db->query($sql);
        echo $select->result_array()[0]['count'];
        //baaki to kahi custom query nhi likhi? nhi likji bs yehi thaok

    }

    public function select_email_login($email_address, $password)
    {

        $this->db->where('email', $email_address);
        $this->db->where('password', $password);
        $result = $this->db->get('sc_users')->result();
        $clinic_id = $result[0]->desired_clinic;
        $this->db->where('id', $clinic_id);
        $r = $this->db->get('sc_desired_clinic')->result();
        if (empty($r)) {
            $des_clinic = '';
            $des_clinics = '';

        } else {
            $des_clinic = $r[0]->desired_clinic;
            $des_clinics = $r[0]->logo;


        }

        // $clinic_name=$this->db->get_where('desired_clinic',array('id'=>$clinic_id))->result()[0]->desired_clinic;

        if ($result) {
            $session_data = array(
                'ulsa_id' => $result[0]->id,
                'name' => $result[0]->name,
                'lastname' => $result[0]->lastname,
                'email' => $result[0]->email,
                'usertype' => $result[0]->usertype,
                'clinic' => $result[0]->desired_clinic,
                'clinic_name' => $des_clinic,
                'clinic_logo'=>$des_clinics
            );

            $this->session->set_userdata($session_data);
            echo 1;
        } else {
            echo 0;
        }
    }
    


    public function reset_pass_link($email)
    {
        $this->load->library('email');
        $emailArray = $this->db->get_where("sc_users", array("email" => $email));
        $emailExist = $emailArray->num_rows();
        if ($emailExist == 1) {
            $id = $emailArray->result_array()[0]['id'];
            $randNumber = $this->generateRandomString();
            $this->db->delete('sc_reset_password', array('user_id' => $id));
            $this->db->insert("sc_reset_password", array("user_id" => $id, "code" => $randNumber));

            $url = $this->config->item("base_url") . "auth/reset/?us=" . base64_encode($id) . "&code=" . $randNumber;
            // <img src="' . $this->config->item("base_url") . '/assets/images/brand/logo.png"/>

            $data = $this->db->get_where("sc_users", array("id" => $id))->result()[0];
            $subject = "Request to change password - ULSA";
            $to = $data->email;
            $message = '<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
        <tr>
            <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">
                <br>
                <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px; margin-bottom:20px;">
                    <tr style="background: white">
                        <td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:0px;color:#DF4726;padding-left:24px;padding-right:24px">
                           <div style="text-align: center; width: 100%; height: auto;padding-top: 25px;">
                           </div>
                           <div class="title" style="max-width: 85%; margin: auto; margin-bottom:10px; background: #0061da; padding-top: 1px; padding-bottom: 1px;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td class="container-padding content" align="left" style="padding-left: 10px; padding-right: 10px;padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:15px;background-color:#ffffff">
                            <div class="body-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: left; color: #000000;">
                            Hello ' . $data->name . ',
                            <br><br><div>
                              A password change request has been made for your account. Please go to<span><a href="' . $url . '"> reset link</a>
                            to enter your new password</span></div><br><br></div></td></tr></table></td></tr></table>';
            $this->sendMail($to, $subject, $message);
            return 1;
        } else {
            return 0;
        }
    }

    public function reset_pass()
    {
        $this->db->update('sc_users', array("password" => base64_encode($_POST['password'])), "id = " . $_POST['us_id']);
        $this->db->delete('sc_reset_password', array('user_id' => $_POST['us_id']));
        return 1;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function sendMail($to, $subject, $message)
    {
        $this->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.sendgrid.net',
            'smtp_user' => 'amankumar11111',
            'smtp_pass' => 'aman11111',
            'smtp_port' => 587,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'crlf' => "\r\n",
            'newline' => "\r\n",
        );
        $this->email->initialize($config);
        $this->email->from('tiwariaman635@gmail.com', 'ULSA');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
    }

}
