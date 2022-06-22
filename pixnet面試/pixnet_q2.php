<?

/**
 * Q2.運用 Adapter design pattern 撰寫運費計算程式，輸入參數包含貨運商 Adapter、地區及公
 * 斤數，輸出運費，這個程式要在不修改運費計算程式的情況下，只靠增加新的貨運商 Adapter
 * ，即可以達成新的運費計算
 */

//計費規則
class BillingRules {
	public $基本運費;
	public $加收需要公斤數;
	public $加收費用;
	public $免額重量;

	public function __construct($基本運費=0, $加收需要公斤數=1, $加收費用=0, $免額重量=0) {
		$this->基本運費 = $基本運費;
		$this->加收需要公斤數 = $加收需要公斤數;
		$this->加收費用 = $加收費用;
		$this->免額重量 = $免額重量;
	}
}

//貨運商
class Adapter {
	public $name; //貨運商名
	public $area; //地區
	public BillingRules $rule; //計費規則

	public function __construct($name, $area, BillingRules $rule) {
		$this->name = $name;
		$this->area = $area;
		$this->rule = $rule;
	}

	//計算費用
	public function calcBill($公斤數):int {
		$rule = $this->rule;
		return $rule->基本運費 + 
				ceil(max($公斤數 - $rule->免額重量, 0) / $rule->加收需要公斤數) * $rule->加收費用;
	}
}

//建立貨運商
$adapter1 = new Adapter('Dog', '美國', new BillingRules(0, 1, 60, 0));
$adapter2 = new Adapter('Falcon', '大陸', new BillingRules(200, 1, 20, 0));
$adapter3 = new Adapter('Falcon', '台灣', new BillingRules(150, 1, 30, 5));
$adapter4 = new Adapter('Cat', '台灣', new BillingRules(100, 3, 10, 0));


?>