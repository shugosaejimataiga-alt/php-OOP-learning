今日は Day7：インターフェース（interface） を進めます。

端的に、わかりやすく、そして Java 経験を活かす形で進めます。

🎯 今日のテーマ：インターフェースとは何か

共通のルール（型）だけを決めるもの
中身の処理は書かない（抽象メソッドだけ）
実際の処理は「実装クラス」が書く
PHPは多重継承ができないが、インターフェースは複数実装できる
Javaの interface とほぼ同じです。



① 例題コード

📄 stepOOP_day07_interface.php

<?php

interface Animal {
  public function speak();
}

class Dog implements Animal {
  public function speak() {
    echo "ワン！\n";
  }
}

class Cat implements Animal {
  public function speak() {
    echo "ニャー！\n";
  }
}

$dog = new Dog();
$dog->speak();

$cat = new Cat();
$cat->speak();



🔍 ポイント解説（端的に）

interface は メソッド名だけ定義する

implements を使ってクラスがインターフェースを 実装 する

実装したクラスは 必ずそのメソッドを定義しなければならない



② 実行しながら理解するポイント

インターフェース自体は new できない

Dog/Cat は Animal という 共通型 を持つ

コードの中では 「Animal型の何か」 として扱える
→ 多態性（ポリモーフィズム） がここで効く。

function makeSpeak(Animal $animal) {
  $animal->speak();
}

makeSpeak($dog);
makeSpeak($cat);

1つの関数で両方動く。
→ 実務で「共通インターフェースでまとめて扱う」ために使う。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問： 前回学んだabstractと今回のinterfaceの違いを教えてください。



✅ 抽象クラス（abstract）の特徴

共通の基盤（親）としての役割
プロパティ（変数）を持てる
普通のメソッド（中身あり）も書ける
抽象メソッド（中身なし）も書ける
子クラスは 1つだけ継承できる（単一継承）

つまり：

「共通の機能も持ちつつ、一部は子クラスに任せたいとき使う」

例：
動物は名前を持つ、という「共通部分」は abstract に書いて、
鳴き声だけは子クラスに決めさせる。



✅ インターフェース（interface）の特徴

ルール（型）だけを定義する
プロパティ（状態）は持てない
メソッドは中身を書かない（完全に抽象）
implements で複数同時に実装できる（多重実装 OK）

つまり：

「共通のルールを強制して、同じ動作名を保証したいとき使う」

例：
「speak() を持つもの」とだけ決めて、
中身は各クラスが自由に作る。



🧠 超端的なまとめ（これだけ覚えればOK）

abstract = 部分的に中身がある “親クラス”

interface = 中身ゼロの “ルール”



🎯 実務での使い分け（重要）

「共通の性質や状態を持つもの → abstract」

「共通の操作だけ保証したい → interface」

例：

Laravelの Model は 抽象クラス（共通機能を持つから）

Controller / Middleware / Request / Event などは インターフェース を多用する（動作の型だけ保証したいから）

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ 練習問題（あなたが書く番）

📄 stepOOP_day07_practice.php

問：
Driveable というインターフェースを作り、run() メソッドを必須にしてください。
そして Car と Bike がそれを実装し、実行してみてください。

要点：

interface Driveable

必須メソッド：run()

Car→「車が走る」

Bike→「バイクが走る」

まず自分で書いてください。
（書けたら「できました」とだけ言ってください。コードはその後で確認します。）


<?php

interface Driveable {
  public function run();
}

class Car implements Driveable {
  public function run() {
    echo "車が走る\n";
  }
}

class Bike implements Driveable {
  public function run() {
    echo "バイクが走る\n";
  }
}

$car1 = new Car();
$car1->run();

$bike1 = new Bike();
$bike1->run();

?>


とても良いです。
完全に理解できています。

interface Driveable で「run() を必ず持つこと」をルール化できている

implements Driveable によって Car / Bike がそのルールに従っている

メソッド名・引数・返り値の形をきちんと揃えている

実行結果も期待通り

ここは満点です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

④ 最終確認テスト（短く回答）

Q1. interface の役割は？
→ （一言で）
解答：共通のルール（型）だけ決めるもの。

Q2. implements を使う目的は？
解答：interfaceを使っていると他者にわかりやすくするもの

Q3. 抽象クラスとの違いを一言で。（重要）
例：「状態を持てる / 持てない」など
解答：抽象クラスはルール（型）とそれ以外にも変数であったり、メソッドの中身を書いて子に引き継がことも
可能だが、interfaceはルール（型）だけ。中身は書かけない。



Q2. implements を使う目的は？
あなたの回答：

interfaceを使っていると他者にわかりやすくするもの

惜しいです。
「わかりやすくする」も結果として正しいのですが、本質は 強制力 です。

正しい一言まとめ：
→ そのクラスに “必ず” そのメソッドを持たせるため

言い換え（実務的な言葉）：
→ 「このクラスはこの動作を必ず持つ」という 保証 をつける


✅ 最終版（面接でそのまま言える形）

interface は「ルールだけ決める」

implements は「そのルールをクラスに強制する」

abstract は「共通処理や状態も持てる “土台”」


Day7：インターフェース（interface）を学習