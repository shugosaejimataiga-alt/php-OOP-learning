今日のテーマは「アプリの保存処理を、きれいに分離できる設計力を身につけること」です。

🔥 Day14：インターフェースで保存処理を分離する

🎯 今日の目的
保存処理（ファイル保存、DB保存など）を クラス本体から切り離す 設計を学びます。
これにより、コードの変更に強くなり、Laravelの設計にもつながります。



① 例題コード（SaverInterface → FileSaver / DatabaseSaver）

まず、保存処理の共通ルールを作ります。

<?php

interface SaverInterface {
  public function save($data);
}



次に、ファイルに保存するクラスです。

class FileSaver implements SaverInterface {
  public function save($data) {
    echo "ファイルに保存しました: " . $data . "\n";
  }
}



次に、データベースに保存するクラスです。

class DatabaseSaver implements SaverInterface {
  public function save($data) {
    echo "データベースに保存しました: " . $data . "\n";
  }
}



最後に、どの保存方法を使うかを外部から決められるクラスです。

class Product {
  private $name;
  private $saver;

  public function __construct($name, SaverInterface $saver) {
    $this->name = $name;
    $this->saver = $saver;
  }

  public function save() {
    $this->saver->save($this->name);
  }
}

$product = new Product("ノートPC", new FileSaver());
$product->save();

$product2 = new Product("キーボード", new DatabaseSaver());
$product2->save();



② 解説（短い文章）

・インターフェースは「必ず実装しなければいけないメソッドの型」を決めるために使います。
・FileSaver と DatabaseSaver は、どちらも save() を必ず作らなければいけません。
・Product クラスは、保存のやり方には関わらず、saver の save() に任せるだけです。
・保存方法を変えるときは Product のコードを一切触りません。
・これは「依存性の逆転（DIP）」という、実務で超重要な原則に近い動きです。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
public function save() { $this->saver->save($this->name); }
が理解できません。


✔ ① 引数の型に SaverInterface と書く
public function __construct($name, SaverInterface $saver)

これはただの「入口条件」。
SaverInterface を実装したものしか入れません
（FileSaver・DatabaseSaver が入れる）
それだけ。



✔ ② constructor の中で受け取る
$this->saver = $saver;

ここが 唯一のつながり です。

つまり：
FileSaver や DatabaseSaver のオブジェクトが
Product のプロパティ $saver に 保存されるだけ
です。


✔ ③ Product の save() のときに “保存先の実体” が動く
$this->saver->save($this->name);

これは：
「Product の中に保存しておいた Saver（実体）に save をやってもらう」
という意味。

インターフェースは呼ばれていません。
実際に動いているのは FileSaver や DatabaseSaver の save() です。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ 練習問題（あなたが手を動かす）

次の仕様でコードを書いてください。

LoggerInterface を作る

FileLogger と ConsoleLogger を作る

メッセージをログに出力する log() メソッドをそれぞれに実装する

User クラスを作り、ログ処理をインターフェースに任せる

User("Taro", new ConsoleLogger()) → log する


<?php

interface LoggerInterface {
  public function log(string $message);
}

class FileLogger implements LoggerInterface {
  public function log(string $message) {
    echo "ファイルに保存しました\n";
  }
}

class ConsoleLogger implements LoggerInterface {
  public fanction log(string $message) {
    echo "コンソールに保存しました\n";
  }
}

class User {
  private $name;
  private $log;

  public function __construct($name, LoggerInterface $log) {
    $this->name = $name;
    $this->log = $log;
  }

  public function save() {
    $this->log->save($this->name);
  }
}

$user1 = new User("Taro", new ConsoleLogger());
$use1->save();

すごいです。
自分でここまで形にできたのは本当に大きい進歩です。
あともう少しだけ修正すれば完璧になります。

🔥 修正ポイント（端的に）

以下の4つだけ修正すれば動きます。

fanction → function（スペルミス）

ConsoleLogger は log() を実装するべきなのに log の中身が違う

User の save() の中で $this->log->save() と書いているけど、正しくは $this->log->log()

$use1 → $user1（変数名ミス）

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

interface LoggerInterface {
  public function log(string $message);
}

class FileLogger implements LoggerInterface {
  public function log(string $message) {
    echo "ファイルに保存しました: \n" . $message;
  }
}

class ConsoleLogger implements LoggerInterface {
  public function log(string $message) {
    echo "コンソールに保存しました: \n" . $message;
  }
}

class User {
  private $name;
  private $log;

  public function __construct($name, LoggerInterface $log) {
    $this->name = $name;
    $this->log = $log;
  }

  public function save() {
    $this->log->log($this->name);
  }
}

$user1 = new User("Taro", new ConsoleLogger());
$user1->save();


璧です。
もう100点です。
ついに「インターフェース × 注入 × 実態の切り替え」の仕組みを、自力で正しく書けています。

🎯 動作内容も正しく設計できています

User はログ処理を知らない
LoggerInterface がルールを定義
ConsoleLogger と FileLogger がそのルールを実装
User にどのログ方法を使うかは 外から渡す
save() の中で $this->log->log() を呼び出し
選んだログクラスのメソッドが動く
OOP の「依存性の逆転（DIP）」を完全に体験できています。

🔥 このコードができているということは……

Laravel の以下の仕組みがすべて理解しやすくなります。

Serviceクラス
Repository パターン
依存性注入（DI）
InterfaceとImplementationの分離
テストがしやすい設計

すべて今回の仕組みの延長です。

🎉 本当にすごい進歩です。

もう Day14 の理解は完全にクリアしています。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
User はログ処理を知らないのですか？


User は
・自分の名前を用意して
・どの保存先（ConsoleLogger か FileLogger）を使うか指定したら
あとはその保存先のクラスが全部やってくれるので、
User はその後の中身は一切知らなくていい。


🎯 なぜ「その後は知らなくていい」のか？

理由は短く2つです。

✔ ① 責任分担

User の仕事は「名前をログに出すこと」。
ログの出し方（どう保存するか）は User の仕事ではないから。


✔ ② 保存処理は Logger の責任

ConsoleLogger も FileLogger も
log() の中に保存処理の中身が書いてある。

だから、その“中身”を User が知る必要はゼロ。



Day14：インターフェースで保存処理を分離するを学習しました。