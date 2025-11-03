Day2：コンストラクタ（__construct） をやります。
説明は端的に、正確な情報のみで進めます。
表形式は使いません。


🧭 今日の目的

インスタンス生成時に自動で実行される処理を理解する
初期値を渡せるクラスを作れるようにする



✅ まず最小の例（概念）
<?php

class Person {
  public $name;

  // これがコンストラクタ
  public function __construct($username) {
    $this->name = $username;
  }

  public function greet() {
    echo "こんにちは、" . $this->name . "です。\n";
  }
}

$user = new Person("太郎");
$user->greet();


解説（短く正確に）

__construct() は new された瞬間に呼ばれる特別なメソッド

$this->name = $username; は
引数で受け取った値をプロパティに代入している

Javaでいうところのコンストラクタとほぼ同じ挙動



🧪 あなたの作業

<?php

class Car {
  public $brand;
  public $model;

  // コンストラクタで初期値を受け取る
  public function __construct($brand, $model) {
    $this->brand = $brand;
    $this->model = $model;
  }

  public function getInfo() {
    echo "車種：{$this->brand} / モデル：{$this->model}\n";
  }
}

// インスタンス生成時に値を渡す
$car1 = new Car("Toyota", "Prius");
$car1->getInfo();

$car2 = new Car("Honda", "Civic");
$car2->getInfo();

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

🎯 練習問題（短く）
以下の仕様通りに新しいクラスを作ってください。
クラス名：Animal

プロパティ：type（動物の種類 / 例: "猫"）

コンストラクタで type を受け取って初期化

speak() メソッドで
私は〇〇です と表示する

準備できたら、
どうぞ、作って実行してみてください。
終わったら「できました」と書いてください。

class Animal {
  public $type;

  public function construct($type) {
    $this->type = $type;
  }

  public function speak() {
    echo "私は{$this->type}です\n";
  }
}

$animal1 = new Animal("猫");
$animal1->speak();

惜しいです。
コンストラクタ名が間違っています。

PHPのコンストラクタは、必ず __construct（アンダースコア2つ） です。
あなたのコードは construct になっているため、コンストラクタとして認識されません。

また、インスタンス生成時に引数を渡しているので、
__construct が正しく動けないと $this->type に値が入りません。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

class Animal {
  public $type;

  public function __construct($type) {
    $this->type = $type;
  }

  public function speak() {
    echo "私は{$this->type}です\n";
  }
}

$animal1 = new Animal("猫");
$animal1->speak();

OKです。
コードは正しく書けています。
Day2（コンストラクタ）の理解は問題ありません。

出力はこうなります：

私は猫です


✨ 今日学んだこと（短く）

__construct() は インスタンス生成時に自動で実行される

引数を受け取り、$this->プロパティ に初期値を設定できる

Javaのコンストラクタと役割はほぼ同じ