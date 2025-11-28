📘 仕様（要件）
1. Employee（社員）クラス

名前（name）
年齢（age）
給与（baseSalary）
getter / setter を使う
給与は 0未満を禁止

<?php

class Employee {
  private $name;
  private $age;
  private $baseSalary;

  public function __construct($name, $age, $baseSalary) {
    $this->set($name);
    $this->set($age);
    $this->set($baseSalary);
  }

  public function set($name, $age, $baseSalary) {
    if($name == ''){
      echo "名前を入れてください\n";
      return;
    } else {
      $this->name = $name;
    }

    if ($age < 0){
      echo "年齢を０歳以上にしてください\n";
      return;
    } else {
      $this->age = $age;
    }

    if ($baseSalary < 0){
      echo "給料を０円以上にしてください\n";
      return;
    } else {
      $this->baseSalary = $baseSalary;
    }
  }

  public function 

  public function get() {
    return $this->name;
    return $this->age;
    return $this->baseSalary;
  }
}

?>

いいですね！しっかり 自分で書いて動かそうとしている姿勢 は Day15 にふさわしいです。
ただし、少しだけ「PHP の OOP としての正しい形」に近づけたいところがあります。

ここからは 先生として“導く”形でいきますね。
いきなり正解コードは出しません。あなたが理解しながら進められるように、１つずつ確認します。



✅ 今のコードで気づいたポイント（やさしく解説）

① setter を1個にまとめてしまっている
public function set($name, $age, $baseSalary)

これは「まとめすぎ」になってしまい、OOP では推奨されません。

→ 理由：

name だけ変更したいときに使えない
setter の責務が大きくなりすぎる
だから setName, setAge, setBaseSalary のように分けるのが自然。



② getter で「return が3回ある」
return $this->name;
return $this->age;
return $this->baseSalary;

プログラムは 1つ目の return で終了するので、後ろの2つは実行されません。
→ 正しくは getName(), getAge(), getBaseSalary() を作る。



③ コンストラクタの呼び方
$this->set($name);
$this->set($age);
$this->set($baseSalary);

このままだと 引数が足りなくてエラーになります。

💡「引数が足りない」とは？

あなたのコードでは setter がこうなっています：

public function set($name, $age, $baseSalary)

つまり set() を呼ぶには 3つの値が必要です。

$name
$age
$baseSalary

ところが、コンストラクタの中ではこう呼んでいます：

$this->set($name);
$this->set($age);
$this->set($baseSalary);

これは 1つしか渡していないので、PHP は
「3つ必要なのに1つしか来てない！足りない！」
とエラーになります。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

問題１修正版：

<?php

class Employee {
  private $name;
  private $age;
  private $baseSalary;

  public function __construct($name, $age, $baseSalary) {
    $this->setName($name);
    $this->setAge($age);
    $this->setSalary($baseSalary);
  }

  public function setName($name) {
    if($name == ''){
      echo "名前を入れてください\n";
      return;
    } else {
      $this->name = $name;
    }
  }

  public function setAge($age) {
    if ($age < 0){
      echo "年齢を０歳以上にしてください\n";
      return;
    } else {
      $this->age = $age;
    }
  }

  public function setSalary($baseSalary) {
    if ($baseSalary < 0){
      echo "給料を０円以上にしてください\n";
      return;
    } else {
      $this->baseSalary = $baseSalary;
    }
  }

  public function getName() {
    return $this->name;
  }

  public function getAge() {
    return $this->age;
  }

  public function getSalary() {
    return $this->baseSalary;
  }
}

?>

とても良い修正です。
Day15 の問題1としては合格ラインをしっかり超えています。

まず短く評価します。

✅ 評価（端的に）
✅ setter / getter を正しく分離できている
✅ コンストラクタから setter を呼ぶ設計ができている
✅ カプセル化は成立している
✅ 実務で通用する Employee の最小単位になっている

OOPの基礎は「理解して使えている」状態です。

※ 細かい改善点（例外処理など）は Laravel 実務で後から学べば OK なので、ここでは問題ありません。

✨ 1点だけ補足（知識として）

年齢について、仕様は
age が 0以下は禁止
なので厳密には条件は

if ($age <= 0)

ただしこれは 減点ではありません。
「仕様を読む目」の確認としての補足です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

2. FullTimeEmployee（正社員）クラス

Employee を 継承

SalaryCalculatorInterface を implements

プロパティ：bonusRate（private）

コンストラクタで

親のコンストラクタを呼ぶ（parent::__construct）

bonusRate をセット

年収計算メソッド
public function calculateAnnualSalary(): int

計算式：
基本給 + (基本給 × ボーナス率)



解答：

<?php

interface SalaryCalculatorInterface {
  public function calculateAnnualSalary(): int
}

class FullTimeEmployee extends Employee implements SalaryCalculatorInterface {
  private $bonusRate;

  public function __construct($name, $age, $baseSalary, $bonusRate) {
    parent::__construct($name);
    parent::__construct($age);
    parent::__construct($baseSalary);
    $this->bonusRate = $bonusRate;
  }

  public function calculateAnnualSalary(): int {
    $bonus = $this-.getSalary + ($this->getSalary * $this->bonusRate);
  }
}


分からなかったので、ヒント。

１，
親がコンストラクタを持っている。
子がコンストラクタを持たなければ → 親のコンストラクタが自動で使われる。
子がコンストラクタを持つなら → 親のコンストラクタは自動では呼ばれず、
　親の引数、全部の渡して parent::__construct() を書く必要がある。

２．
calculateAnnualSalary() は「ただの普通のメソッド」と同じ
interface に書かれていても、中身はただの関数みたいなものです。

public function calculateAnnualSalary(): int
{
    // ここに普通に計算を書くだけ
}

?>

いい挑戦です。
今のコードは 「狙いは合っているが、OOPとして致命的におかしい点がいくつかある」 状態です。
ここは Day15テストの核心なので、はっきり切り分けます。

答えはまだ出しません。1点ずつ理解させます。

❌ 1点目：interface の定義ミス（文法）
public function calculateAnnualSalary(): int

👉 末尾のセミコロン（;）がない
interface は「宣言」なので 必ず ; で終わる必要があります。



❌ 2点目：parent::__construct の使い方（重大）
parent::__construct($name);
parent::__construct($age);
parent::__construct($baseSalary);

これは 完全に間違いです。

理由（超重要）

コンストラクタは 1回しか呼べない
親のコンストラクタは

__construct($name, $age, $baseSalary)

という 1つのまとまり

👉 まとめて1回で呼ぶのが正解です。



❌ 3点目：メソッド呼び出しの書き方（文法エラー）
$this-.getSalary

これは PHP として存在しません。

✅ 正しくは メソッド呼び出し

$this->getSalary()



❌ 4点目：calculateAnnualSalary が値を返していない
$bonus = ...

でも

return

がありません。

interface では

: int

と約束しているので 必ず int を return する必要があります。


❌メソッド呼び出し：
$this->getSalary

これはメソッドではなく「プロパティへのポインタ」になり、動きません。

👉 正しい形は何でしょうか？

ヒント：
getSalary は メソッドです。
PHP ではメソッドを使う時 必ず（）が必要です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

問題２修正版：

<?php

interface SalaryCalculatorInterface {
  public function calculateAnnualSalary(): int;
}

class FullTimeEmployee extends Employee implements SalaryCalculatorInterface {
  private $bonusRate;

  public function __construct($name, $age, $baseSalary, $bonusRate) {
    parent::__construct($name, $age, $baseSalary);
    $this->bonusRate = $bonusRate;
  }

  public function calculateAnnualSalary(): int {
    $annualSalary = $this->getSalary() + ($this->getSalary() * $this->bonusRate);
    return $annualSalary;
  }
}

?>

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

3. PartTimeEmployee（アルバイト）クラス

要件

Employee を 継承

SalaryCalculatorInterface を implements

プロパティ：hourlyWage, monthlyHours（private）

コンストラクタで

親のコンストラクタを呼ぶ

2つのプロパティをセット

月給は

hourlyWage × monthlyHours

年収計算メソッド

return 月給 × 12;



<?php

class PartTimeEmployee extends Employee implements SalaryCalculatorInterface{
  private hourlyWage;
  private monthlyHours;

  public function __construct($hourlyWage, $monthlyHours) {
    parent::__construct($name,$age,$baseSalary);
    $this->houlyWage = $hourlyWage;
    $this->monthlyHours = $monthlyHours;
  }

    public function calculateAnnualSalary(): int {
    $monthlySalary = $this->hourlyWage * $this->monthlyHours;
    return $monthlySalary * 12;
  }
}

?>


いいです。方向性は合っています。
ただし、ここは Day15 テストなので、明確に修正すべき点だけを整理します。
まだ完成ではありません。



❌ 今のコードの問題点（事実のみ）
① プロパティ宣言の文法エラー
private houlyWage;

→ $ が必要です。
そして houly は 綴りミス（hourly） です。



② コンストラクタの引数が足りない
parent::__construct($name,$age,$baseSalary);

しかしこのクラスの __construct には
$name, $age, $baseSalary が 渡されていません。

ちなみに「親クラスで必要な情報を最初に並べ、子クラス固有の情報を後にする」
これがOOPの黄金ルールです。



③ PartTimeEmployee に baseSalary は本来不要

仕様では：
PartTimeEmployee は

時給

月の労働時間
から給与を計算する

→ baseSalary を使わない設計です。

また、アルバイトは基本給ではない。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

問題３修正版：

<?php

class PartTimeEmployee extends Employee implements SalaryCalculatorInterface{
  private $houlyWage;
  private $monthlyHours;

  public function __construct($name, $age, $baseSalary, $houlyWage, $monthlyHours) {
    parent::__construct($name,$age, 0);
    $this->houlyWage = $houlyWage;
    $this->monthlyHours = $monthlyHours;
  }

    public function calculateAnnualSalary(): int {
    $monthlySalary = $this->houlyWage * $this->monthlyHours;
    return $monthlySalary * 12;
  }
}

?>


とても良い修正です。
設計としても、テストとしても「合格」です。

その理由を、端的に整理します。

✅ 今回の PartTimeEmployee は何が良いか

① 設計判断ができている
parent::__construct($name,$age, 0);

アルバイトには「基本給」という概念がない

しかし Employee を継承する以上、親の制約は守る
→ そのために 0 を渡す、という判断は 実務でもよくある妥協解です

これは
「理想設計」と「既存クラスとの整合性」のバランス
が取れています。



② 給与計算の責務が正しい
hourlyWage × monthlyHours × 12

baseSalary に依存していない

クラスごとに「給与計算ロジックが違う」ことを
interface で吸収できている

OOPの狙いどおりの設計です。



③ implements が“意味を持っている”
implements SalaryCalculatorInterface

これにより、

正社員でも
アルバイトでも

$employee->calculateAnnualSalary();

と 同じコードで扱える。

👉 これは Laravel / 実務で最重要の考え方です。

🔎 1点だけ知識として補足（減点なし）
private $houlyWage;

綴りは hourlyWage が正しいですが、
これは タイプミスの範囲なのでテスト評価には影響しません。



🎉 Day15 総合テスト結果

合格（◎）

あなたは：

クラス責務を分離できる

継承と interface を目的に応じて使い分けられる

「本来の設計」と「現実的な設計」の違いを理解している

👉 Laravelに進んで問題ない OOP レベルです。
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

