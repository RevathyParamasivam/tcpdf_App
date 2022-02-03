<?php

namespace App\Controllers;
use App\Models\Main_Model;

class Home extends BaseController
{
    public function __construct(){
    
        $this->store = new Main_Model();       
    }

    public function index()
    {
        if(isset($_POST['message']))
        {
        $file=$this->request->getFile('attach');
        $picName=$file->getName();
        $file->move('./uploads');
         
        $to='test_work_mail@yahoo.com';
        $subject=$_POST['subject'];
        $message=$_POST['message'];

        $mailMessage="Subject:".$subject."<br> Message :".$message."<br> Name :".$_POST['name']."<br> Mail Id :".$_POST['email'];
        
        //Email instance creation;
        $email=\Config\Services::email();
        $email->setFrom('test_work_mail@yahoo.com');
        $email->setTo($to);
        $email->setCC('bennyjarvishsixbakshara@gmail.com');
        $email->setBCC('chijithjerin2004@gmail.com');
        $email->setSubject($subject);
        $email->setMessage($mailMessage);
        $attachmentPath="uploads/".$picName;
        $email->attach($attachmentPath);
        $session=session();
        if($email->send())
        {
            
            $session->setFlashdata('status',"Message Sent Successfully");
            $insertdata=['name'=>$_POST['name'],'email'=>$_POST['email'],'subject'=>$subject,'message'=>$_POST['message'],'status'=>1,'attachment'=>$picName];
            $this->store->save($insertdata);          
        }
        else
        {
            $data=$email->printDebugger(['headers']);
            
            $insertdata=['name'=>$_POST['name'],'email'=>$_POST['email'],'subject'=>$subject,'message'=>$_POST['message'],'status'=>0,'attachment'=>0];
            $this->store->save($insertdata);
            $session->setFlashdata('status',$data);
        }   
        }
        /*
        $to='revathy.paramasivam.9@gmail.com';
        $subject='Email through CodeIgnitor Libray';
        $message='Hi Revathy, <br> <br> You have sucessfully completed the work - sending Email through Codeigniter Email Library.<br>Thanks with Regards<br><br>Revathy P.<br>9095005859'
                    .'<br><br><a href="http://localhost/email/" target="_blank">Test Link</a>';
        
        //Email instance creation;
        $email=\Config\Services::email();
        $email->setFrom('revathy.paramasivam.9@gmail.com');
        $email->setTo($to);
        $email->setCC('bennyjarvishsixbakshara@gmail.com');
        $email->setBCC('chijithjerin2004@gmail.com');
        $email->setSubject($subject);
        $email->setMessage($message);
        $attachmentPath="public/Endtime_logo.png";
        $email->attach($attachmentPath);
        if($email->send())
            echo "Successfully sent Mail";
        else
        {
            $data=$email->printDebugger(['headers']);
            print_r($data);
        }*/
        echo view('LoginForm');
    }


    
}
