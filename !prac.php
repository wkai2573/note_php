<?php

$fx = "x\"cdd";
echo $fx;
$fx = '"' . str_replace('"', '\"', $fx) . '"';
$fx = eval("return $fx;");
echo "." . $fx;


// $fx = '$f47380 / ($f4725_8 * $PCS)';
// // $fx = '1+1';
// $count = preg_match_all("/\\$(\w+)/", $fx, $matches);
// $fxNames = $matches[1];
// foreach ($fxNames as $fxName) {
// 	$fx = str_replace("$$fxName", "2a", $fx);
// }

// ob_start();
// $result = eval("return $fx;");
// if ('' !== $error = ob_get_clean()) {
// 	$result = $fx;
// }

// die(json_encode([
// 	$count,
// 	$matches,
// 	$fx,
// 	$result
// ]));


// $dateStr = '2022-01-02';
// $dateInt_weekUse = strtotime("$dateStr +1 days");
// $weekCount = date('W', $dateInt_weekUse); //週數
// $week = $weekCount + 0;
// echo $week;

// $text = "RM2220801-01-001-01-0";
// $subId = preg_match("/^(MOP|MOZ|MOB|MOS)/", $text, $ms);
// die(json_encode([
// 	$subId, $ms[1]
// ]));

//! PHPExcel __________________________________________________

// /** PHPExcel */
// require_once __DIR__."/lib/PHPExcel.php";
// /** PHPExcel_IOFactory */
// require_once __DIR__."/lib/PHPExcel/IOFactory.php";

//? 讀excel==
// $phpReader = PHPExcel_IOFactory::createReader('Excel2007');
// $phpReader->setReadDataOnly(true);
// $phpExcel = $phpReader->load(__DIR__."/門禁權限整理.xlsx");
// $sheet = $phpExcel->getActiveSheet();         //讀取工作表
// $sheet = $phpExcel->getSheet(0);              //讀取工作表
// $sheet = $phpExcel->getSheetByName("import"); //讀取工作表
// $maxRowIndex = $sheet->getHighestRow(); 
// $maxCol = $sheet->getHighestColumn();
// $maxColIndex = PHPExcel_Cell::columnIndexFromString($maxCol); 
// //標題
// $TITLE_ROW_NUM = 1;
// $COLUMN_ROW_NUM = $TITLE_ROW_NUM + 1;
// $dateTypeColIndex = [1, 2, 3]; //日期類型的colIndex
// $titles = [];
// for ($ci = 0; $ci < $maxColIndex; $ci++) [ 
// 	$titles[] = $sheet->getCellByColumnAndRow($ci, $TITLE_ROW_NUM)->getCalculatedValue();
// ]
// //資料
// $rows = [];
// for ($ri = $COLUMN_ROW_NUM; $ri <= $maxRowIndex; $ri++) {
// 	$row = [];
// 	for ($ci = 0; $ci < $maxColIndex; $ci++) {
// 		$cell = $sheet->getCellByColumnAndRow($ci, $ri)->getCalculatedValue();
// 		if (in_array($ci, $dateTypeColIndex)) {
// 			$cell = PHPExcel_Style_NumberFormat::toFormattedString($cell, 'yyyy-mm-dd');
// 		}
// 		$row[$ci] = trim($cell);
// 	}
// 	$rows[] = $row;
// }
// return [$phpExcel, $titles, $rows];

//? 匯出
// $phpExcel = new PHPExcel();
// $sheet = $phpExcel->getSheet(0);
// //格式: 欄寬 + 字型大小 + 自動換行 + 水平置中 + 垂直置中
// $sheet->getDefaultColumnDimension()->setWidth(18);
// $phpExcel->getDefaultStyle()->getFont()->setSize(9);
// $phpExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
// $phpExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $phpExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// //寫入標題
// $columns = ['欄位A', '欄位B', '欄位C'];
// foreach ($columns as $ci => $colName) {
// 	$sheet->setCellValueByColumnAndRow($ci, 1, $colName);
// }
// //寫入資料
// $rows = [ [1,2,3], [4,5,6] ];
// foreach ($rows as $ri => $row) {
// 	foreach ($row as $colName => $val) {
// 		$ci = array_search($colName, $columns);
// 		if ($ci!==false) $sheet->setCellValueByColumnAndRow($ci, $ri+2, $val);
// 	}
// }
// $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
// $objWriter->save('export.xlsx');

//! 讀檔案 __________________________________________________

//? 讀json檔案
// $string = file_get_contents(__DIR__."\data.json");
// if ($string === false) die('error');
// $jsonData = json_decode($string, true);
// if ($jsonData === null) die('error');
// foreach ($jsonData as $key => $val) [
// 	echo $val['sn'];
// ]
/*
$jsonData = [
	["sn"=>636, "ZDT_uId"=>22010009, "uid"=>"001075", "uname"=>"鄭文鋒"],
 	["sn"=>676, "ZDT_uId"=>22010103, "uid"=>"002363", "uname"=>"李宏銘"],
]
*/

//! 陣列物件測試 __________________________________________________

//? 陣列push
// $arr = ["a"=>"A", "b"=>"B"];
// $arr = array_merge($arr, ["c"=>"C", "d"=>"D"]);
// var_dump($arr);

//! 正則類 __________________________________________________

//? 拆路徑、檔名
// $picPath = "/upload_dev012808/Sub_network/qj0a22FIS.png";
// list($folder, $fileName) = preg_split("/\/(?=[^\/]*$)/", $picPath, 2, PREG_SPLIT_NO_EMPTY);

//? 基本正則 match 尋找
// $pn = "123456789.SD-0102";
// $matchCount = preg_match("/.+\.(..).*/", $pn, $matches);
// echo isset($matches[1])? $matches[1] : "";

//? preg_match_all 用法
// $a = '(SUM($[781])-SUM($[783])-SUM($[784]))/SUM($[781])';
// $matchCount = preg_match_all("/\\$\\[(\\d+)\\]/", $a, $matches);
// $符合的項目s = $matches[0];
// $符合的第1群組s = $matches[1];
// echo '1';

//? preg_match_all，取得" OR (要取的東西)"
// $a = " OR (s.depSn IN (BBBB) AND n.staffSn IN (0,19))";
// $a = " OR (ABS(s.depSn) IN (AAAA) AND n.staffSn IN (0,58)) OR (s.depSn IN (BBBB) AND n.staffSn IN (0,19))";
// preg_match_all("/(?<= OR \().*?(?=\) OR|\)$)/", $a, $matches);
// $orArr = $matches[0];
// echo '1';

//? preg_replace_callback 用法 (類似js的replacer)
// $str = '111-222|333-444|555-666';
// $newStr = preg_replace_callback("/(\\d[3])-(\\d[3])/", function($matches) [
// 	//$matches[0]=>符合正則項目 [1]=>群組1 [2]=>群組2
// 	return $matches[1] + $matches[2];
// ], $str);
// echo $newStr;

//? 規則=> "Invoice number $YYYY-$MM-$DD $[PIJ\d+](Calamba)"
//? 檔名=> "651-PIJ2080005.pdf"
//? 結果=> "Invoice number PIJ2080005(Calamba)"
// $s = 'Invoice number $YYYY-$MM-$DD $[PIJ\d+](Calamba) - SEA Freight';
// $fileName = "651-PIJ2080005.pdf";
// $s = preg_replace("/\\\$YYYY/", date('Y'), $s);
// $s = preg_replace("/\\\$MM/", date('m'), $s);
// $s = preg_replace("/\\\$DD/", date('d'), $s);
// $s = preg_replace_callback("/\\\$[(.*?)]/", function($matches) use ($fileName) [
// 	return preg_replace("/.*([$matches[1]]).*/", "$1", $fileName) ;
// ], $s);

//? 移除RC，補"-"
// $cell = "RCMOS215001701001";
// $newCell = preg_replace_callback("/^(?:RC)?(\\w{10})-?(\\d{2})-?(\\d{3})$/", function($matches) {
// 	return "{$matches[1]}-{$matches[2]}-{$matches[3]}";
// }, $cell);

//! 其他 __________________________________________________

//? 接收回傳
// $data = json_decode(file_get_contents('php=>//input'), true);
// var_dump($data);
// die();

//? 字串包含
// $a = strpos('MOS_apple', 'MOS')!==false? "是" => "否";
// $b = strpos('MOS_apple', 'MOS')===true? '是' => '否';
// echo $a, $b;

//? 測試用變數接物件屬性
// $obj = (object)['a'=>1, 'b'=>2, 'c'=>3];
// $vv = 'c';
// echo $obj->$vv;

//? 測試 ?=> 功能
// $depSn = '2,4';
// $staffSn = '';
// echo "NOT (depSn IN (".($depSn?=>0).") AND staffSn IN (".($staffSn?=>0)."))";

//? 字串
// echo <<<OuO
// 我最喜歡<br />
// X"D"D
// OuO

//?數字格式化=> 轉成百分比(小數點後兩位)
// $val = 0.456789;
// $persentVal = sprintf("%.2f%%", $val * 100);
// echo $persentVal;

//! 時間類 __________________________________________________

//? 取得今年第幾週，weekOfYear
// $dateInt = strtotime('2021-05-06');
// $weekday = date('w', $dateInt);
// $week = date('W', $dateInt) + (in_array($weekday, [5,6,0])? 1 : 0);
// echo "\n應該是W19: 顯示是$week ，星期$weekday";

//? 取得2時間中，中間所有月份
// function getMonthRange($startDate, $endDate, $format = 'Y-m') [
// 	$month = date('Y-m', strtotime($startDate));  //轉年月
// 	$endMonth = date('Y-m', strtotime($endDate));
// 	$range = [date($format, strtotime($month))];  //第一次給本月
// 	for ($i = 1; $month < $endMonth; $i++) [
// 		$monthDate = strtotime($startDate . ' + ' . $i . ' month');  
// 		$month = date('Y-m', $monthDate);
// 		$range[] = date($format, $monthDate);
// 	]
// 	return $range;
// ]
// $dateS = '2019-12-01 11:22:33';
// $dateE = '2020-01-01 11:22:33';
// $ymArr = getMonthRange($dateS, $dateE, 'Ym');
// var_dump($ymArr);

//? 計算兩時間，小時差(DateTime)
// $date1 = new DateTime('2006-04-14T10:50:00');
// $date2 = new DateTime('2006-04-14T12:00:00');
// $diff = $date2->diff($date1);
// $hours = $diff->h;
// $hours += $diff->days * 24;
// $hours += round($diff->i / 60, 2);
// echo $hours;

//? 計算兩個時間差的方法(字串) 
// $startDate = "2012-12-11 11:40:00";
// $endDate = "2012-12-12 11:45:09";
// $allSecond = (strtotime($endDate)-strtotime($startDate));
// $allHour = $allSecond / 3600;

//?目前時間 -8小時
// $datetime = new DateTime();
// $datetime->modify('-8 hour');
// echo $datetime->format('Y-m-d H:i:s');

//?目前時間 -7天
// $_7daysAgo = date("Y-m-d H:i:s", strtotime("-7 day"));
// echo $_7daysAgo;

//?指定時間
// $string = "2010-11-24";
// $timestamp = strtotime($string);
// echo date("d", $timestamp);

//?指定時間分割
// $date = '2010-11-24';
// list($y, $m, $d) = explode('-', $date);
// echo "$y $m $d";

//?指定時間 加減時間
// $time1 = strtotime('2021-01-01 -1 months');
// $time1_str = date('Y-m-d', $time1);
// $time2 = strtotime('2021-01-01 +2 days');
// $time2_str = date('Y-m-d', $time2);
// echo $time1_str." | ".$time2_str;

//? 取得本週開始與結束(日~六)
// $d = strtotime("today");
// $start_week = strtotime("last sunday midnight",$d);
// $end_week = strtotime("next saturday",$d);
// $start = date("Y-m-d",$start_week);
// $end = date("Y-m-d",$end_week);
// echo '本週開始=>'.$start.'|本週結束=>'.$end;

//! 迴圈類 __________________________________________________
//? usort
// $a = [1,2,3,84,5,6,4879,12,315,15,46];
// $b = [
//     (object) ['sn'=>4879, 'title'=>'xdd'],
//     (object) ['sn'=>2, 'title'=>'xdd'],
//     (object) ['sn'=>3, 'title'=>'xdd'],
//     (object) ['sn'=>315, 'title'=>'xdd'],
//     (object) ['sn'=>5, 'title'=>'xdd'],
//     (object) ['sn'=>1, 'title'=>'xdd'],
//     (object) ['sn'=>84, 'title'=>'xdd'],
//     (object) ['sn'=>46, 'title'=>'xdd'],
//     (object) ['sn'=>6, 'title'=>'xdd'],
//     (object) ['sn'=>12, 'title'=>'xdd'],
//     (object) ['sn'=>15, 'title'=>'xdd'],
// ];
// usort($b, function($x, $y) use($a)[
//     return array_search($x->sn,$a) - array_search($y->sn,$a);
// ]);

?>