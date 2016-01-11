<?php
/**
 * Date: 2016-01-11
 * Author: Awei.tian
 * Description: 
 */
require_once 'vendor/PHPExcel/PHPExcel.php';
include "vendor/PHPExcel/PHPExcel/Writer/Excel2007.php";
class dlView extends view{
	public function outputExcel($fd,$data){
		$objExcel = new PHPExcel(); 
		$objWriter = new PHPExcel_Writer_Excel5($objExcel);
		
		$objExcel->setActiveSheetIndex(0);
		$objActSheet = $objExcel->getActiveSheet();
		
		$h = array_combine($_POST["col"], $_POST["col"]);
		
		$url_col_index = 0;
		$mwd_col_index = 0;
		$res_col_index = 0;
		//求出
		$row = 1;
		$col = 1;
		foreach ($fd as $fk => $fv){
			if(array_key_exists($fk, $h)){
				$cn = chr(64+$col);
				if($fk == "url"){
					$url_col_index = $col;
				}
				if($fk == "ma_word"){
					$mwd_col_index = $col;
				}
				if($fk == "result"){
					$res_col_index = $col;
				}
				$objActSheet->setCellValue($cn.$row,$fv);
				$col++;
			}
		}
		$row = 2;
		foreach ($data as $item){
			$col = 1;
			foreach ($item as $i){
				$cn = 64+$col;
				$objActSheet->setCellValue(chr($cn).$row,$i);
// 				if($mwd_col_index){
// 					if($i == 1){
// 						$objActSheet->getCellByColumnAndRow($row-1,$col-1)->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
// 					}
// 				}
				$col++;
			}
			$row++;
		}
		$i = 0;
		if($url_col_index){
			$objActSheet->getColumnDimension(chr(64+$url_col_index))->setWidth("32");
		}
		if($mwd_col_index){
			$objActSheet->getColumnDimension(chr(64+$mwd_col_index))->setWidth("22");
		}
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header('Content-Disposition:attachment;filename="resume.xls"');
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
	}
}