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
        $pdf = new mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
        $pdf->AddPage();
        $pdf->Ln(40);
        $pdf->SetFont('freeserif', '', 12, '', true);
        $output='
            <table width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <td><b>Ref:</b> FO/6/SRD/New Sponsor/Allotment </td>
                <td style="text-align:right">Tuesday, February 15, 2022</td>
            </tr>
            <br>
            <tr><td><b>To :</b></td></tr>
            <tr>
                <td style="width:10%"></td>
                <td>
                    <p>Mr./Ms. Franklin L</p>
                    <p>No 5/2 Leela Mahal,Justice Ramanujam,Rbi Colony</p>
                    <p>Thiruvanmiyur,Tamil Nadu (Zone)</p>
                    <p>India Email: lfranklin121@gmail.com</p>
                    <p>Ph: 600.141121</p>
                </td>
            </tr>
            <tr><td style="width:100%">Dearly beloved in Christ Jesus,</td></tr>
            </table>
            ';
            $pdf->WriteHTML($output, true, 0, true, 0);
            //$utf8text='அந்திமாலையில், العربية REVATHY அந்திமாலையில் revathy அந்திமாலையில்';
            //$pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
            
            $this->response->setContentType('application/pdf');
            $pdf->Output('example_001.pdf', 'I');
            
    }
    
}

class mypdf extends TCPDF {

    


    //Page header
    public function Header() {
        // Logo
        $this->Image("./assets/img/gems_logo_withtext.png", 11, 9, 40, 27.5);
        
        // Title
        $this->SetFont('BebasNeueBold','',29);
        $this->SetXY(60, 18);
        $this->SetTextColor(5, 106, 162);
        $this->Cell(0, 15, 'GOSPEL ECHOING MISSIONARY SOCIETY (GEMS)', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetXY(60, 23);
        $this->SetFont('MonotypeCoversia','',11);
        $this->SetTextColor(230, 0,0);
        $this->Cell(140,5,'Transforming Peoples to Transform Nations',0,1,'C');
        $this->Ln();

        $this->SetXY(60, 30);
        $this->SetFont('ArialBold','B',11);
        $this->SetTextColor(0);
        $this->Cell(140,10,'GEMS, Sikaria, Indrapuri PO, Dehri On Sone, Rohtas Dist. Bihar 821308',0,1,'C');
        $this->Ln();

        $this->SetFont('Arial','',11);
        $this->SetXY(60, 36);
        $this->Cell(140,10,'+916184 234567 - gems@gemsbihar.org | sponsors@gemsbihar.org',0,1,'C');

        $this->Ln();

        $this->SetFont('Times','I',12);
        $this->SetXY(10, 33);
        $this->Cell(45,5,'D. Augustine Jebakumar ',0,1,'L');
        $this->SetFont('Times','B',12);
        $this->Cell(45,5,'General Secretary ',0,1,'C');
        $this->Ln();


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
