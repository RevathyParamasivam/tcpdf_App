<?php

namespace App\Controllers;
use TCPDF;

class Home extends BaseController
{
    public function index()
    {
        
        return view('table');
    }
    public function printpdf()
    {
        
        $html=view('table');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'utf-8', false);
        $pdf->SetFont("bamini", '', 10);
        $pdf->AddPage();
        // set some language dependent data:
        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

        // set some language-dependent strings (optional)
        //$pdf->setLanguageArray($lg);

        // ---------------------------------------------------------

        // set font
        
$pdf->SetFont('bamini', '', 12);
// Persian and English content
$htmlpersian = '<span color="#660000">Revathy Stalin</span><br />.';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
//$pdf->setRTL(false);
//$pdf->SetFont('arial', '', 12);
$pdf->SetFontSize(10);

// print newline
$pdf->Ln();

// Persian and English content
$htmlpersiantranslation = '<span color="#0000ff">Hi, At last Problem of Persian PDF Solved completely. This is a example for it.<br /> இணையத்தில் எங்கிருந்தாலும் நீங்கள் தேர்வுசெய்யும் மொழியில் தட்டச்சு செய்வதை Google உள்ளீட்டு கருவி எளிதாக்குகிறது. மேலும் அறிக

இதை முயற்சிக்க, கீழே உங்கள் மொழி மற்றும் உள்ளீட்டு கருவியைத் தேர்வுசெய்து, தட்டச்சு செய்யத் தொடங்கவும். Problem of "jeh" letter in some word like "ویژه" (=special) fix too.<br />The joining of laa and alf letter fix now.<br />Special thanks to "Nicola Asuni" and "Mohamad Ali Golkar" for Persian support.</span>';
//$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// Restore RTL direction
//$pdf->setRTL(true);

// set font
 $pdf->SetFont('aefurat', '', 18);

// print newline
$pdf->Ln();
$pdf->SetFont('freeserif', '', 14, '', true);
// Arabic and English content
//$pdf->Cell(0, 12, 'بِسْمِ اللهِ الرَّحْمنِ الرَّحِيمِ அந்திமாலையில், அலைகள்',0,1,'C');
//$htmlcontent = 'تمَّ بِحمد الله حلّ مشكلة الكتابة باللغة العربية في ملفات الـ<span color="#FF0000">PDF</span> مع دعم الكتابة <span color="#0000FF">من اليمين إلى اليسار</span> و<span color="#009900">الحركَات</span> .<br />تم الحل بواسطة <span color="#993399">صالح المطرفي و Asuni Nicola</span>  . ';
//$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

// print newline
$pdf->Ln();

//$pdf->SetFont('aealarabiya', '', 18);

//$utf8text = file_get_contents('vendor\tecnickcom\tcpdf\examples\data\utf8test.txt', false);
$pdf->SetFont('freeserif', '', 14, '', true);
$utf8text='அந்திமாலையில், العربية REVATHY அந்திமாலையில் revathy அந்திமாலையில்';
$pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);

        //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $this->response->setContentType('application/pdf');
        $pdf->Output('example_001.pdf', 'I');
    }
    
}
