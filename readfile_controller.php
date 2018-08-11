<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class readfile extends CI_Controller
{
	public function __construct()
	{
		parent ::__construct();
	}
	
	function import()
	{		
		$file_mimes = array('text/x-comma-separated-values',
							'text/comma-separated-values',
							'application/octet-stream',
							'application/vnd.ms-excel', 
							'application/x-csv',
							'text/x-csv',
							'text/csv', 
							'application/csv',
							'application/excel',
							'application/vnd.msexcel',
							'text/plain', 
							'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');			
			if(isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes))
			{
				$arr_file = explode('.', $_FILES['file']['name']);
				$extension = end($arr_file);
				if('csv' == $extension) 
				{
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} 
				else 
				{
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
				foreach($spreadsheet->getWorksheetIterator() as $worksheet)
				{
					$highestRow=$worksheet->getHighestRow();
					$highestColumn=$worksheet->getHighestColumn();
					for($row=10;$row<=$highestRow;$row++)
					{
							$विभाग_का_नाम=$worksheet->getCellByColumnAndRow(2,$row)->getCalculatedValue();
							$जनपद_का_नाम=$worksheet->getCellByColumnAndRow(3,$row)->getCalculatedValue();
							$वार्षिक_लक्ष्य_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(4,$row)->getCalculatedValue();
							$माह_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(5,$row)->getCalculatedValue();
							$माह_की_उपलब्धि_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(6,$row)->getCalculatedValue();
							$माह_तक_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(7,$row)->getCalculatedValue();
							$क्रमिक_उपलब्धि_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(8,$row)->getCalculatedValue();
							$क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(9,$row)->getCalculatedValue();
							if($क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष==0)
							{
								$क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष="N";
							}
							$वार्षिक_लक्ष्य_गत_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(10,$row)->getCalculatedValue();
							$क्रमिक_उपलब्धि_गत_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(11,$row)->getCalculatedValue();
							$क्रमिक_उपलब्धि_प्रतिशत_10_9_गत_वित्तीय_वर्ष=$worksheet->getCellByColumnAndRow(12,$row)->getCalculatedValue();
							$गत_वर्ष_की_उपलब्धि_के_सापेक्ष_वृद्धि_प्रतिशत_7_minus_10_10=$worksheet->getCellByColumnAndRow(13,$row)->getCalculatedValue();
							$अभ्युक्ति=$worksheet->getCellByColumnAndRow(14,$row)->getCalculatedValue();
							$data=array(
								'विभाग_का_नाम'=>$विभाग_का_नाम,
								'जनपद_का_नाम'=>$जनपद_का_नाम,
								'वार्षिक_लक्ष्य_वर्तमान_वित्तीय_वर्ष'=>$वार्षिक_लक्ष्य_वर्तमान_वित्तीय_वर्ष,
								'माह_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष'=>$माह_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष,
								'माह_की_उपलब्धि_वर्तमान_वित्तीय_वर्ष'=>$माह_की_उपलब्धि_वर्तमान_वित्तीय_वर्ष,
								'माह_तक_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष'=>$माह_तक_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष,
								'क्रमिक_उपलब्धि_वर्तमान_वित्तीय_वर्ष'=>$क्रमिक_उपलब्धि_वर्तमान_वित्तीय_वर्ष,
								'क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष'=>$क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष,
								'वार्षिक_लक्ष्य_गत_वित्तीय_वर्ष'=>$वार्षिक_लक्ष्य_गत_वित्तीय_वर्ष,
								'क्रमिक_उपलब्धि_गत_वित्तीय_वर्ष'=>$क्रमिक_उपलब्धि_गत_वित्तीय_वर्ष,
								'क्रमिक_उपलब्धि_प्रतिशत_10_9_गत_वित्तीय_वर्ष'=>$क्रमिक_उपलब्धि_प्रतिशत_10_9_गत_वित्तीय_वर्ष,
								'गत_वर्ष_की_उपलब्धि_के_सापेक्ष_वृद्धि_प्रतिशत_7_minus_10_10'=>$गत_वर्ष_की_उपलब्धि_के_सापेक्ष_वृद्धि_प्रतिशत_7_minus_10_10,
								'अभ्युक्ति'=>$अभ्युक्ति
								);						
						$this->db->insert('कर_एवं_करेत्तर_राजस्व_संग्रह',$data);
					}			
					echo "Data Imported Successfully";
				}
			}
	}
	
	function fetch()
	{
		$output="";
		$count=0;
		$query=$this->db->get('कर_एवं_करेत्तर_राजस्व_संग्रह');
		$output.='
		<table border="2">
				<tr>
					<th>क्र0 सं0</th>
					<th>विभाग का नाम</th>
					<th>जनपद का नाम</th>
					<th>वार्षिक लक्ष्य वर्तमान वित्तीय वर्ष</th>
					<th>माह का लक्ष्य वर्तमान वित्तीय वर्ष</th>
					<th>माह की उपलब्धि वर्तमान वित्तीय वर्ष</th>
					<th>माह तक का लक्ष्य वर्तमान वित्तीय वर्ष</th>
					<th>क्रमिक उपलब्धि वर्तमान वित्तीय वर्ष</th>
					<th>क्रमिक उपलब्धि प्रतिशत 7/3 वर्तमान वित्तीय वर्ष</th>
					<th>वार्षिक लक्ष्य गत वित्तीय वर्ष</th>
					<th>क्रमिक उपलब्धि गत वित्तीय वर्ष</th>
					<th>क्रमिक उपलब्धि प्रतिशत 10/9 गत वित्तीय वर्ष</th>
					<th>गत वर्ष की उपलब्धि के सापेक्ष वृद्धि प्रतिशत (7-10)/10</th>
					<th>अभ्युक्ति</th>
				</tr>
				';
				foreach($query->result() as $row)
				{
					$output.='
			<tr>
				<td>'.++$count.'</td>
				<td>'.$row->विभाग_का_नाम.'</td>
				<td>'.$row->जनपद_का_नाम.'</td>
				<td>'.$row->वार्षिक_लक्ष्य_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->माह_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->माह_की_उपलब्धि_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->माह_तक_का_लक्ष्य_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->क्रमिक_उपलब्धि_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->क्रमिक_उपलब्धि_प्रतिशत_7_3_वर्तमान_वित्तीय_वर्ष.'</td>
				<td>'.$row->वार्षिक_लक्ष्य_गत_वित्तीय_वर्ष.'</td>
				<td>'.$row->क्रमिक_उपलब्धि_गत_वित्तीय_वर्ष.'</td>
				<td>'.$row->क्रमिक_उपलब्धि_प्रतिशत_10_9_गत_वित्तीय_वर्ष.'</td>
				<td>'.$row->गत_वर्ष_की_उपलब्धि_के_सापेक्ष_वृद्धि_प्रतिशत_7_minus_10_10.'</td>
				<td>'.$row->अभ्युक्ति.'</td>
			</tr>
			';
				}
				$output.='</table>';
				echo $output;
	}

	function index()
	{
		$this->load->view('readfile');
	}
}

?>