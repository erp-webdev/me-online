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

    public function setCompany($company_id)
    {

        switch($company_id){
            case 'MEGA01': 
                $this->logo = IMG_WEB . '/mega_coe.png';
                $this->address1 = '25/F Alliance Global Tower, 36th Street corner 11th Avenue Uptown Bonifacio, Taguig City 1634';
                $this->address2 = 'Trunkline: (632) 905-2900 • (632) 905-2800 ';
                $this->address3 = 'www.megaworldcorp.com • Email: infodesk@megaworldcorp.com';
                break;

            case 'GLOBAL01': 
                $this->logo = IMG_WEB . '/gl_coe.png';
                $this->address1 = 'Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200';
                $this->address2 = 'Tels (632) 5411979 / 8946345';
                $this->address3 = 'www.globalcompanies.com.ph • Email: globalonehr@globalcompanies.com.ph';
                break;

            case 'LGMI01': 
                $this->logo = IMG_WEB . '/lgmi_coe.png';
                $this->address1 = 'Unit G, Ground Floor, 331 Building, 331 Sen. Gil Puyat Avenue, Barangay Bel-Air, Makati City 1200';
                $this->address2 = 'Tels (632) 5411979 / 8946345';
                $this->address3 = 'www.globalcompanies.com.ph • Email: globalonehr@globalcompanies.com.ph';
                break;
                break;

            case 'CITYLINK': 
                $this->logo = IMG_WEB . '/citylink_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'ASIAAPMI': 
                $this->logo = IMG_WEB . '/asiaapmi_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'ECC02': 
                $this->logo = IMG_WEB . '/ecinema_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'ECOC01': 
                $this->logo = IMG_WEB . '/ecoc_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'ERA01': 
                $this->logo = IMG_WEB . '/erex_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'FCI01': 
                $this->logo = IMG_WEB . '/firstcentro_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'GLOBALHOTEL': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'LFI01': 
                $this->logo = IMG_WEB . '/lafuerza_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'LUCK01': 
                $this->logo = IMG_WEB . '/lctm_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'MCTI': 
                $this->logo = IMG_WEB . '/mcti_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'MLI01': 
                $this->logo = IMG_WEB . '/mli_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'MREIT_FMI': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'MREIT_INC': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'MREIT_PMI': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'NCCAI': 
                $this->logo = IMG_WEB . '/nccai_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'NEWTOWN01': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'Rowenta': 
                $this->logo = IMG_WEB . '/blank_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'SIRUS': 
                $this->logo = IMG_WEB . '/sirus_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'SUNT01': 
                $this->logo = IMG_WEB . '/suntrust_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

            case 'TOWN01': 
                $this->logo = IMG_WEB . '/townsquare_coe.png';
                $this->address1 = '';
                $this->address2 = '';
                $this->address3 = '';
                break;

        }
    }




}