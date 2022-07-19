<?php 

require_once(DOCUMENT.'/lib/tcpdf/tcpdf.php');


class COEPDF extends TCPDF{

    public $logo = IMG_WEB . '/mega_coe.png';
    public $address = '25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634';
    public $address2 = 'Trunkline: (632) 905-2900 • (632) 905-2800';
    public $address3 = 'www.megaworldcorp.com • Email: infodesk@megaworldcorp.com';

    public function Header(){
        $logo = $this->logo;

        $this->Image($logo, 10, 10, 0, 15, 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('helvetica', '', 8);
        // footer text
        $address = $this->address;
        $address2 = $this->address2;
        $address3 = $this->address3;

        // $this->Cell(0, 10, 'page ' .$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 20, $address, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 15, $address2, 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, $address3, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    

}