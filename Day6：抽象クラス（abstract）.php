Day6：抽象クラス（abstract）

今日の目的

「共通する性質をまとめて、必ず実装すべきメソッドを強制できる設計」を理解する。
Javaにも同じ仕組みがあるので、感覚は似ているはずです。



抽象クラスとは

クラスの上に abstract をつけると抽象クラスになる。

抽象クラスは 「直接インスタンス化できない」

抽象メソッドを持てる（中身がないメソッド）

抽象クラスを継承した子クラスは、抽象メソッドを必ず実装しないといけない



例題コード

📄 stepOOP_day06_abstract.php

<?php

abstract class Animal {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  // 抽象メソッド：中身は書かない
  abstract public function speak();

  public function introduce() {
    echo "私は{$this->name}です\n";
  }
}

class Dog extends Animal {
  public function speak() {
    echo "ワン！\n";
  }
}

class Cat extends Animal {
  public function speak() {
    echo "ニャー！\n";
  }
}

$dog = new Dog("ポチ");
$dog->introduce();
$dog->speak();

$cat = new Cat("タマ");
$cat->introduce();
$cat->speak();



ここで重要な点（最低限覚えること）

abstractクラスは new できない

abstractメソッドは中身を書かない

子クラスは抽象メソッドを“必ず”実装する

これだけでOKです。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題（あなたが書く番）

以下の仕様でコードを書いてください：

抽象クラス Vehicle を作る

プロパティ name

run() を抽象メソッドとする

子クラス Car と Bike を作る

Car → 「車が走る」

Bike → 「バイクが走る」

インスタンスを作ってメソッドを呼ぶこと

<?php

class Vehicle {
  public $name;

  abstract public function run();
}

class Car extends Vehicle {
  public $name;

  public function run($name) {
    $this->name = $name;
    echo $this->name . "が走る\n";
  }
}

class Bike extends Vehicle {
  public $name;

  public function run($name) {
    $this->name = $name;
    echo $this->name . "が走る\n";
  }
}

car1 = new Car();
car1->run("車");

bike1 = new Bike();
bike1->run("バイク");

?>

✔️ 修正ポイント（最低限おさえる）

abstract class Vehicle と書かないと抽象クラスにならない

抽象メソッド run() は 親で引数を決めたら、子も同じ形に必ず合わせる

new Car(); は $car1 のように $ が必須

名前はコンストラクタで渡すと設計がきれいになる（Day2と統一）

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

<?php

abstract class Vehicle {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  abstract public function run();
}

class Car extends Vehicle {
  public function run() {
    echo $this->name . "が走る\n";
  }
}

class Bike extends Vehicle {
  public function run() {
    echo $this->name . "が走る\n";
  }
}

$car1 = new Car("車");
$car1->run();

$bike1 = new Bike("バイク");
$bike1->run();

完璧です。
このコードは 抽象クラスの設計・継承・強制実装 の意図を正しく押さえています。

修正の必要はありません。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
端的に教えてください。
親クラスのコンストラクタで$this->〇〇とインスタンス個別の変数を決めると、子クラスで宣言しなくてもいいのでしょうか？


はい、そうです。
親クラスで $this->name をプロパティとして用意し、コンストラクタで値を設定しているなら、子クラスで同じプロパティを宣言する必要はありません。

端的に
プロパティは親クラスに1回だけ書けば、子クラスにも引き継がれる。
子クラスで同じ名前のプロパティを 改めて宣言する必要はない。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✅ 最終確認テスト（短く答えてください）

Q1. 抽象クラスは直接 new できますか？
解答：できない。

Q2. 抽象メソッドは子クラスでどうしなければなりませんか？
解答：絶対に使わなければならない。制約をされている。

Q3. 抽象クラスを使う目的を一言で。
解答：開発を効率良くするため


回答ありがとう。
とても良いです。
ただ Q2 と Q3 を端的に本質に寄せて、少しだけ調整します。


✅ 模範的に短くまとめると

Q1. 抽象クラスは直接 new できますか？
→ できない

Q2. 抽象メソッドは子クラスでどうしなければなりませんか？
→ 必ず実装する

Q3. 抽象クラスを使う目的を一言で。
→ 共通の形を強制して、設計を統一する




あなたの理解（確認）

「制約する」→ その通り
「開発を効率よくする」→ 本質的には「設計を統一する」ことが効率化につながる

理解は完全に OK です。