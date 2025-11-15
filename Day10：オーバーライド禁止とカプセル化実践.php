今日は Day10：オーバーライド禁止とカプセル化実践 を扱います。

🎯 学習目的

final を使って「上書き禁止」を理解する

private と protected の違いを整理して、カプセル化の設計力を鍛える



🧩 ① 例題コード：final とアクセス修飾子
<?php

class Animal {
  protected $name;

  public function __construct($name) {
    $this->name = $name;
  }

  final public function eat() {
    echo "{$this->name}が食べています\n";
  }

  protected function sleep() {
    echo "{$this->name}が寝ています\n";
  }
}

class Dog extends Animal {
  // finalメソッドはオーバーライドできない！
  // public function eat() {
  //   echo "{$this->name}がドッグフードを食べています\n";
  // }

  public function bark() {
    echo "{$this->name}が吠えています！\n";
  }

  public function action() {
    $this->sleep(); // protectedだから呼び出せる（同じクラス系統内）
  }
}

$dog = new Dog("ポチ");
$dog->eat();   // OK（親のまま）
$dog->bark();  // OK
$dog->action(); // protected呼び出し（OK）
// $dog->sleep(); // NG（外部からprotectedはアクセス不可）

?>



💡 ② 解説（要点まとめ）

final：子クラスでオーバーライドを禁止したいときに使う。

protected：継承先（子クラス）までは使えるが、外部（インスタンス）からは呼べない。

private：同じクラスの中だけで使用可。子クラスにも引き継がれない。

これにより、
「必要な情報だけを外部に見せる」＝カプセル化
を実現できる。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
子クラスでオーバーライドを禁止したいときとはどういうことですか？


とても良い質問です。
これは「親クラスの動作を絶対に変えてほしくないとき」に使います。



🔹 具体例で説明します

たとえば「銀行の口座」を考えてみましょう。

class BankAccount {
  public final function closeAccount() {
    echo "口座を閉じました。\n";
  }
}

この closeAccount() メソッドは、全ての口座で共通して「閉じる処理」を同じように行う必要があるとします。

もし子クラスが勝手に上書きしてしまうと…

class SavingAccount extends BankAccount {
  public function closeAccount() {
    echo "口座を閉じずに残高を移行しました。\n"; // ←勝手に変えた
  }
}

銀行システムとしてルールが壊れてしまう可能性があります。
だから、親クラス側で「このメソッドは上書き禁止！」と明示するために final をつけます。



🔹 要するに

子クラスが間違って処理を変えないようにする「安全装置」。

大規模なシステムや共通ライブラリで特に重要。

「この機能は絶対に同じ動作であってほしい」ときに使う。

わかりやすく言うと、

「親の設計者が“ここはいじらないでね”とロックをかけるための仕組み」
です。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
全ての口座で共通して「閉じる処理」を同じように行う必要があるとします。という例を出していて、この共通するというのにpublicがあるからという事だと思うのですが、publicって外部にも見せられるという事ですよね？何でしょう。意味の齟齬というか。外部にも見せられるから何という事を知りたいのですが。


非常に良い着眼点です。
まさにここが「カプセル化と公開のバランス」というOOPの本質的な部分です。

順を追って、丁寧に整理しますね。



🧩 1. publicとは

「誰でも呼べるように外に公開する」という意味です。

たとえば：

$account = new BankAccount();
$account->closeAccount(); // ← 外から呼べる（public）

このように、public にしているメソッドは、
システムの外部（ユーザーや他のプログラム）から使ってもらうための“入り口” になります。



🧩 2. では、なぜ「publicでfinal」にするのか？

final は「上書き禁止」
public は「外部から呼び出し可能」

つまりこの組み合わせは、

「外からは呼んでいいけど、中身は変えちゃダメ」

という意味になります。

💡 たとえるなら…

銀行システムの「口座を閉じる」ボタン。

ボタンは誰でも押せる（public）

でも、そのボタンを押したときに行われる「口座閉鎖の仕組み」は、
どの支店・どの種類の口座でも統一されたルールでなければならない（final）

これが「public + final」の意味です。



🧩 3. publicをつける理由は「使ってもらうため」

外部から呼べないと、
ユーザーや他のクラスが BankAccount を操作できなくなるからです。

つまり public は “APIとしての窓口” であり、
final は “中の仕組みを守る鍵” です。



🧠 まとめると

public … 誰でもアクセスできる入口をつくる

private / protected … 内部の仕組みは隠す

final … 外部公開したとしても、動作の一貫性を守るために中身を変えさせない

言い換えると：

「publicは“見せる自由”、finalは“壊させない安全”」
この2つが合わさると、“安全に使える共通の機能”を提供できるのです。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
その、あなたはよく、誰が見るかという表現でpublic,private,protectedを使いますが、表現として見られるかという表現ではなく、使われたり使うかの表現が適切ではないですか？



…まさにその通りです。
あなたの指摘は非常に本質的です。



✅ 正確に言うと

public / private / protected は
「誰が“見られるか”」というよりも、
「誰が“使えるか（アクセスできるか）」を制御する仕組みです。



🔹「見られる」よりも「使える」

たとえば：

class Sample {
  private $data = "秘密";

  public function show() {
    echo $this->data;
  }
}

このとき、外部から $data の中身を直接“見られない”（参照できない）だけでなく、
$data を 操作（使う）こともできません。

なので、正確には：

private：外部・子クラスは使えない（操作できない）

protected：外部は使えないが、子クラスは使える（操作できる）

public：誰でも使える（操作できる）



💡 なぜ「見る」表現が多いのか

OOPの世界では「データの隠蔽（information hiding）」という考えが根底にあります。

それで「内部の状態を見せない」＝「隠す」＝「カプセル化」という表現が広まり、
自然と「見られる・見られない」という言葉がよく使われてきました。

でも、あなたの言う通り、
実際にコードを書く上では「アクセスできるかどうか」「呼び出せるかどうか」の方が正確です。


つまり、あなたの感覚は正しいです。

「見られるか」ではなく、「使えるか（アクセスできるか）」
これがより正確で、実務でも通じる表現です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
外部（インスタンス）からは呼べない。とはどういうことですか？


とても良い質問です。
「外部（インスタンス）から呼べない」という表現は、
オブジェクト指向の中でも少し抽象的に聞こえるので、具体的に説明しますね。



🧩 1. 「外部（インスタンス）」とは？

まず、クラスから作られた具体的なモノ（＝オブジェクト）を「インスタンス」と呼びます。

class Human {
  private function secret() {
    echo "これは秘密です\n";
  }

  public function greet() {
    echo "こんにちは\n";
  }
}

$hito = new Human(); // ← これがインスタンス（＝外部の存在）


ここで $hito は Human クラスの外側にある実体です。
これが「外部（インスタンス）」にあたります。



🧩 2. 「外部から呼べない」とは

外部（インスタンス）から
$hito->secret(); のように呼び出すと――

Fatal error: Uncaught Error: Call to private method Human::secret()


というエラーになります。
つまり、クラスの外側（インスタンス経由）からはアクセスできないという意味です。
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

🧠 ③ 練習問題

次の条件を満たすクラスを作ってください。

BankAccount クラスを作る。

プロパティ：balance（残高）を private で定義。

deposit() メソッドで入金できるように。

withdraw() メソッドでは引き出せるが、残高が足りない場合は「残高不足」と表示。

口座を閉じる final メソッド closeAccount() を作り、「口座を閉じました」と表示。

子クラス SavingAccount を作り、final メソッドの上書きを試すとエラーになることを確認。

📄 ファイル名：stepOOP_day10_override_control.php

<?php

class BankAccount {
  private $balance = 0;

  public function deposit($deposit) {
    $this->balance = $balance;
    $tihs->balance += $deposit;
    echo "残高" . $this->balance "\n";
  }

  public function withdraw($withdraw) {
    $this->balance = $balance;
    if ($this->balance < $withdraw) {
      echo "残高不足です\n";
    } else {
      $this->balance -= $withdraw;
    }
  }

  public final function closeAccount() {
    echo "口座を閉じました\n";
  }
}

class SavingAccount extends BankAccount {
  public final function closeAccount() {
    echo "口座を閉じました\n";
  }
}

$bankaccount1 = new BankAccount();
$bankaccount1->deposit(5000);
$bankaccount1->withdraw(7000);
$bankaccount1->closeAccount();

$savingaccount1 = new SavingAccount();
$savingaccount1->closeAccount();

?>


💡 主な修正点の解説

$this->balance = $balance; は不要
→ $balance という変数は存在していません。
$this->balance がすでにプロパティなので、それだけでOKです。


$tihs → $this のスペルミス
→ 小さなtypo（PHPは厳密に区別するのでエラーになります）


echo "残高" . $this->balance "\n"; の構文ミス
→ 文字列の結合には「.」が必要：

正しくは
echo "残高" . $this->balance . "\n";


final の確認
→ SavingAccount 側で closeAccount() を再定義すると
「Fatal error: Cannot override final method BankAccount::closeAccount()」
と出て、上書き禁止が確認できます。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
そもそも$this->balanceとかの$this->〇〇ってなんで必要なんですか？


クラスに属する変数（＝プロパティ）を
メソッドの中で使いたいときは、
$this->プロパティ名 と書くことで
そのインスタンス（＝自分自身）が持つ値を使うことができる。
そしてその後、「$this->〇〇 はクラスのプロパティに“戻って登録する”」



疑問：
コンストラクタに一回書いたら、別にそのクラス、もしくは継承した、上書きしたクラスには$this->〇〇=$〇〇って書く必要がないという事は分かっているのですが、今回はコンストラクタで定義していないうえでの、$this->〇〇=$〇〇もやる必要がないという事ですけど。
どういうことですか？

結論外部から値をもらっていないから、$this->〇〇=$〇〇を書く必要がない。
コンストラクタは、値を最初から登録する前提の物で、値を外部からもらい、登録するから$this->〇〇=$〇〇のように書いて、クラスに属しているプロパティに繋げる必要がある



疑問：
すみません。今疑問に思ったのですが、$depositは$this->〇〇にしなくていいのですか？


$this-> は「そのオブジェクトの中にある変数（プロパティ）」を指すためのもの。

$deposit は「関数の引数として一時的に渡された値」だから、
$this-> をつける必要はない。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：


<?php

class BankAccount {
  private $balance = 0;

  public function deposit($deposit) {
    $this->balance += $deposit;
    echo "残高" . $this->balance . "\n";
  }

  public function withdraw($withdraw) {
    if ($this->balance < $withdraw) {
      echo "残高不足です\n";
    } else {
      $this->balance -= $withdraw;
    }
  }

  public final function closeAccount() {
    echo "口座を閉じました\n";
  }
}

class SavingAccount extends BankAccount {
  public final function closeAccount() {
    echo "口座を閉じました\n";
  }
}

$bankaccount1 = new BankAccount();
$bankaccount1->deposit(5000);
$bankaccount1->withdraw(7000);
$bankaccount1->closeAccount();

$savingaccount1 = new SavingAccount();
$savingaccount1->closeAccount();

?>



ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✅ ④ 確認テスト（短く答えてください）

Q1. final をつけたメソッドは、子クラスでどうなりますか？
解答：エラーになる

Q2. private と protected の違いを一言で。
解答：前者はアクセスが自クラスだけ。後者が自クラスと子クラスだけ。

Q3. カプセル化の目的を一言で。
解答：外に見せていい情報と中だけの情報を区別すること。


完璧です。💯

すべての回答が短く・正確・本質を突いています。
確認テストとしての回答精度は申し分ありません。



Day10：オーバーライド禁止とカプセル化実践を学習しました。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー























































<?php

class Employee {
  private $salary; // 完全に外から守りたい
  protected $name; // 子クラスでは使わせたい

  public function __construct($name, $salary) {
    $this->name = $name;
    $this->setSalary($salary);
  }

  // final：子クラスで絶対に上書きされてはいけないメソッド
  final public function getSalary() {
    return $this->salary;
  }

  // setter：外から勝手に書き換えられないようにする
  public function setSalary($salary) {
    if ($salary < 0) {
      throw new Exception("給料は0以上である必要があります");
    }
    $this->salary = $salary;
  }

  public function introduce() {
    echo "{$this->name} の自己紹介です\n";
  }
}

class Manager extends Employee {

  // // ❌ 禁止：getSalary() は final なので上書きできない
  // public function getSalary() {
  //   return 9999999;
  // }

  public function work() {
    echo "{$this->name} が管理業務をしています\n";
  }
}

$emp = new Manager("山田", 300000);
$emp->introduce();
echo $emp->getSalary();



② 解説（端的に・重要ポイントだけ）

■ final の本質

「このメソッドは絶対に変えられては困る」 という部分を守るために使う。
Laravelのコア部分でも多用される。

例：
給料の取得
IDの生成
セキュリティに関わる処理
フレームワークの内部構造

→ 上書きされると危険な処理は final にする。



■ private の本質

「そのクラスの中だけで完結させたい」
外部からも子クラスからも絶対に触らせない。

例：
直接変更されると危険なデータ
内部処理だけで使う補助メソッド
変更されるとアプリが壊れる部分



■ protected の本質

「外からは触らせないが、子クラスには使わせたい」

例：
名前、住所、IDなどの基本情報
子クラスでロジックを拡張したい時



■ setter の役割

データの書き換えを制御し、「不正な値のセットを防ぐ」。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ 練習問題（あなたが書く）

次を満たす Employee → Manager のコードを書いてください。

Employee

private $salary

protected $name

salaryは外部から直接変更不可

setSalary() で 0 以上であることをチェック

getSalary() は final

Manager（Employeeを継承）

work() メソッドを持つ

introduce() を Manager風にオーバーライドしてOK

getSalary() は上書き禁止（final の理解チェック）


<?php

class Employee {
  private $salary;
  protected $name;

  private function __construct($salary, $name) {
    $this->name = $name;
    $this->setSalary($salary);
  }

  private function setSalary($salary) {
    if ($salary >= 0) {
      $this->salary += $salary;
    } else {
      echo "0円以上でお願いします。\n";
    }
  }

  public final function getSalary() {
    return $this->salary;
  }
}

class Manager extends Employee {
  private function work() {
    echo "働いています。\n";
  }

}

?>


❗ まずコードの問題点

あなたのコードには以下の問題があります。


1. コンストラクタが private

→ これだと Employee を new できません。
子クラスも new できません。


2. setSalary が private

→ コンストラクタ以外で salary を変更できない。
→ これは良い場面もあるが、Day10の趣旨とズレています。
（setter は public か protected が一般的）


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

1はそうでした。 たしかにprivateにすると外からアクセスできなく、値すらも入れられないのですね。


2は分かりません。

✔ まず結論（最短で理解）

private の setSalary() は “Employee の中だけ” でしか使えない。
そのため、

子クラス（Manager）からも使えない

外部からも使えない

つまり “給料を変更するための唯一の入り口” が 完全に封じられる。

結果として：

「給料をセットする仕組みなのに、誰も使えなくなる」

という矛盾が発生します。



✔ もっと丁寧に説明（端的）
■ setter を作る目的とは？

外から値を書き換える時に、ルールを通すため。

たとえば：

マイナス禁止

1億以上は禁止

値の変化をログに記録する

テストしやすくする

こういう “フィルター” の役割が setter。



■ private にするとどうなる？

private は クラス内部だけで使用できるアクセス修飾子。

つまり：

new Employee() のとき → OK（コンストラクタ内から呼べる）

外から setSalary() → ❌ 呼べない

子クラス（Manager）から setSalary() → ❌ 呼べない






<?php

class Employee {
  private $salary;
  protected $name;

  public function __construct($name, $salary) {
    $this->name = $name;
    $this->setSalary($salary);
  }

  protected function setSalary($salary) {
    if ($salary < 0) {
      echo "0円以上でお願いします。\n";
      return;
    }
    $this->salary = $salary;
  }

  final public function getSalary() {
    return $this->salary;
  }

  public function introduce() {
    echo "{$this->name} の自己紹介です。\n";
  }
}

class Manager extends Employee {

  // introduce はオーバーライド可能 → Manager風に変更
  public function introduce() {
    echo "{$this->name}（マネージャー）の自己紹介です。\n";
  }

  public function work() {
    echo "{$this->name} が管理業務をしています。\n";
  }
}

$mgr = new Manager("山田", 300000);
$mgr->introduce();
echo $mgr->getSalary();
