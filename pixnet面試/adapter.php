<?php

// namespace RefactoringGuru\Adapter\Conceptual;

// Target 定義了客戶端代碼使用的特定於域的接口。
class Target {
	public function request(): string {
		return "目標：默認目標的行為。";
	}
}

/**
 * Adaptee 包含一些有用的行為，但它的接口不兼容
 * 使用現有的客戶端代碼。 Adaptee 在客戶端代碼可以使用它。
 */
class Adaptee {
	public function specificRequest(): string {
		return ".eetpadA eht fo roivaheb laicepS";
	}
}

/**
 * Adapter 使 Adaptee 的接口與 Target 的接口兼容界面。
 */
class Adapter extends Target {
	private $adaptee;

	public function __construct(Adaptee $adaptee) {
		$this->adaptee = $adaptee;
	}

	public function request(): string {
		return "適配器：（翻譯） " . strrev($this->adaptee->specificRequest());
	}
}

/**
 * 客戶端代碼支持所有遵循 Target 接口的類。
 */
function clientCode(Target $target) {
	echo $target->request();
}

echo "客戶：我可以很好地處理目標對象：\n";
$target = new Target();
clientCode($target);
echo "\n\n";

$adaptee = new Adaptee();
echo "客戶端：Adaptee 類有一個奇怪的接口。看不懂：\n";
echo "Adaptee: " . $adaptee->specificRequest();
echo "\n\n";

echo "客戶：但我可以通過適配器使用它：\n";
$adapter = new Adapter($adaptee);
clientCode($adapter);

?>