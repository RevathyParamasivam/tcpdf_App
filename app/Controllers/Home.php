<?php

namespace App\Controllers;
use TCPDF;
use App\Models\Main_Model;
use App\Models\Attach_Model;

class Home extends BaseController
{
    public function __construct(){
    
        $this->store = new Main_Model();
        $this->storeAttach = new Attach_Model();       
    }

    public function index()
    {
        if(isset($_POST['message']))
        {
            $attachmenName=array();
            $url=$_POST['url'];
            $i=0;
            $picURL="";
            $to='test_work_mail@yahoo.com';
            $cc='bennyjarvishsixbakshara@gmail.com';
            $bcc='adiksha8evvp@gmail.com';
            $subject=$_POST['subject'];
            $message=$_POST['message'];
            $mailMessage="Subject:".$subject."<br> Message :".$message."<br> Name :".$_POST['name']."<br> Mail Id :".$_POST['email'];
            
            if(!empty($url))
                {       
                $picURL=$_POST['url'];
                $mailMessage.="<br>visit URL: ".$picURL;
                $attachmenName[$i]=$picURL;
                $i++;
                }
           
        //$mailMessage="Subject:".$subject."<br> Message :".$message."<br> Name :".$_POST['name']."<br> Mail Id :".$_POST['email'];
        
        //Email instance creation;
        $email=\Config\Services::email();
        $email->setFrom('test_work_mail@yahoo.com');
        $email->setTo($to);
        $email->setCC($cc);
        $email->setBCC($bcc);
        $email->setSubject($subject);
        $email->setMessage($mailMessage);
        
        $upload_dir = './uploads'.DIRECTORY_SEPARATOR;
            if(!empty(array_filter($_FILES['attach']['name']))) {
            foreach ($_FILES['attach']['tmp_name'] as $key => $value) {
             
                $file_tmpname = $_FILES['attach']['tmp_name'][$key];
                $file_name = $_FILES['attach']['name'][$key];
                //$file_size = $_FILES['attach']['size'][$key];
                //$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $filepath = $upload_dir.$file_name;
                

                //echo $filepath;
                if(file_exists($filepath)) {
                    $filepath = $upload_dir.time().$file_name;
                       $attachmenName[$i]=time().$file_name;$i++;
                        
                    if( move_uploaded_file($file_tmpname, $filepath)) {
                        echo "";                     }
                    else {                    
                        echo "Error uploading {$file_name} <br />";
                    }
                }
                else {
                     $attachmenName[$i]=$file_name;$i++;
                    if( move_uploaded_file($file_tmpname, $filepath)) {
                        
                        echo "";
                        }
                    else {                    
                        echo "Error uploading {$file_name} <br />";
                    }
                }
              

                $email->attach($filepath);
            }
            }

            
        
        $session=session();
        if($email->send())
        {
            
            $session->setFlashdata('status',"Message Sent Successfully");
            $insertdata=['name'=>$_POST['name'],'email'=>$_POST['email'],'subject'=>$subject,'message'=>$_POST['message'],'status'=>1,'cc'=>$cc,'bcc'=>$bcc];
            $this->store->save($insertdata);
            $email_id = $this->store->getInsertID();
            $status=1; 
            
                     
        }
        else
        {
            $data=$email->printDebugger(['headers']);
            $session->setFlashdata('status',"Message not sent");
            $insertdata=['name'=>$_POST['name'],'email'=>$_POST['email'],'subject'=>$subject,'message'=>$_POST['message'],'status'=>0,'cc'=>$cc,'bcc'=>$bcc];
            $this->store->save($insertdata);
            $status=0;              
            $email_id = $this->store->getInsertID();    
            //echo $email_id."Inserted ID \n\n";
        }

        $attachmentCount=count($attachmenName);
        for ($x = 0; $x < $attachmentCount; $x++) { 
                        $image_data=['id_mail'=>$email_id,'file_name'=>$attachmenName[$x],'status'=>$status];
                        $this->storeAttach->save($image_data);
                        }

        }
        return view('email_form');
    }
    public function printpdf()
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
        $pdf->AddPage();
        $data=$this->store->findAll();
        $pdf->SetFont('freeserif', '', 14, '', true);
        $output='
            <table width="100%" cellspacing="5" cellpadding="5">
            <tr>
                <td><img src="https://img.search.brave.com/zmt6hyCqmsUQ_yOU_FuKxPkr_5168ahu5yW9p1urjFg/rs:fit:312:225:1/g:ce/aHR0cHM6Ly90c2U0/Lm1tLmJpbmcubmV0/L3RoP2lkPU9JUC5X/T094RTVDeHFMREw0/Q05yWDBmcGh3SGFM/USZwaWQ9QXBp"/></td>
                <td>
                    <p><b>Name:</b>'.$data[0]['email'].'</p>
                    <p style="font-family: DejaVu Sans Mono" ><b>Address:</b></p>
                    <p id="add">revathy'.$data[0]['message'].'</p>
                    <p><b>City:</b>'.$data[0]['cc'].'</p>
                    <p style="font-family: bboo">Test Data'.$data[0]['bcc'].'Test Data</p>
                    <p><b>Pin:</b>'.$data[0]['status'].'</p>
                </td>
            </tr></table>
            ';
            $pdf->WriteHTML($output, true, 0, true, 0);
            $utf8text='அந்திமாலையில், العربية REVATHY அந்திமாலையில் revathy அந்திமாலையில்';
            $pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
            $this->response->setContentType('application/pdf');
            $pdf->Output('example_001.pdf', 'I');
    }
    
}
