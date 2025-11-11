Day9：コンストラクタと親子連携 をやります。
（いつも通り、表は使いません。説明は端的に。）

✅ 今日のテーマ

親クラスのコンストラクタを、子クラスでもちゃんと引き継いで使う方法。

PHPでは、親の __construct() は自動では継承されません。
だから、必要なら parent::__construct() を明示的に呼びます。

Java と似ていますが、PHPは コンストラクタを省略したら親のが自動になる などの状況があるため、ここはしっかり「自分で書く」意識が重要です。



① 例題コード（まずは動かす）
<?php

class Animal {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function speak() {
    echo "{$this->name} が鳴く\n";
  }
}

class Dog extends Animal {
  public $breed;

  public function __construct($name, $breed) {
    // 親クラスのコンストラクタに name を渡す
    parent::__construct($name);
    $this->breed = $breed;
  }

  public function info() {
    echo "名前: {$this->name}, 犬種: {$this->breed}\n";
  }
}

$dog1 = new Dog("ポチ", "柴犬");
$dog1->speak();
$dog1->info();



② 解説（短く・本質だけ）

親クラスが初期化するべき値 → parent::__construct() に任せる

子クラスで追加したい初期化 → 子側の __construct() 内で書く

つまり：

共通の初期化 → 親
追加の初期化 → 子

という役割分担をする。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
あなたが提示してくれた例題コードで親クラスのspeakメソッドが子クラスでインスタンス化できるのはなぜですか？
コンストラクタだけ引き継ぐのではないのですか？

良い疑問です。とても大事なポイントなので 端的に、正確に 説明します。

✅ 結論

コンストラクタだけが特別なのではありません。
継承（extends）すると、親クラスの「プロパティ」と「メソッド」はすべて子クラスに引き継がれます。

つまり、

class Dog extends Animal


と書いた時点で、

Animal のプロパティ $name

Animal のメソッド speak()

は Dogクラスの機能として使える ようになります。

✅ では、コンストラクタは？

__construct() だけは 「そのまま自動では引き継がれない」場合があるため、必要なら明示的に parent::__construct() を書きます。

なぜなら、子クラスが独自の __construct() を定義した瞬間に、親の __construct() が上書きされる から。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

そうでした。extendsとparent::__construct()は別という認識でいいですね？


はい、その認識で 正しい です。

✅ 端的にまとめると

extends
→ 親クラスの プロパティ と メソッド を
そのまま自動で引き継ぐための仕組み

parent::__construct()
→ コンストラクタ（初期化処理）だけ
子クラス側で 明示的に呼ぶ必要がある場合に使うもの

✅ つまり
継承（extends） ＝ 機能全体の受け継ぎ
parent::__construct() ＝ 親の初期化だけ呼び出す


この2つは 役割が別 です。

理解は完璧です。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ 練習問題（あなたが書く）

Bird クラス を作ってください。

親：Animal（nameを持ち、speak()がある）

子：Bird（wingSpan（翼の長さ cm）を追加）

Dogと同じ流れで parent::__construct() を使う

info() メソッドで以下のように表示

名前: スズメ, 翼: 15cm

書けたら、そのコードだけ送ってください。
添削します。


<?php

class Animal {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function speak($name) {
  echo $this->name . "が鳴いている\n";
  }
}

class Bird extends Animal {
  public $wingSpan;

  public function __construct($name, $wingSpan) {
    parent::__construct($name);
    $this->wingSpan = $wingSpan;
  }

  public function info($this->wingSpan) {
    echo "名前: " . $this->name . " 翼: "$this->wingSpan . "cm\n";
  }
}

bird1 = new Bird("キジ", 30);

bird1->speak();

bird1->wingSpan();

?>


OK、しっかり直します。
書いてくれたコードは 方向性は合っていますが、構文のミスが数カ所あります。
ポイントは次のとおりです：

speak() は $name を引数に取らなくて良いので、引数は削除

info() の引数は不要（$this->wingSpan が直接使えるから）

文字列結合は . を使う（ "翼: "$this->wingSpan は構文エラー）

インスタンス化は $bird1 = new Bird(...); のように $ が必要

最後の呼び出しは $bird1->info();（プロパティ名ではなくメソッド）

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

<?php

class Animal {
  public $name;

  public function __construct($name) {
    $this->name = $name;
  }

  public function speak() {
  echo $this->name . "が鳴いている\n";
  }
}

class Bird extends Animal {
  public $wingSpan;

  public function __construct($name, $wingSpan) {
    parent::__construct($name);
    $this->wingSpan = $wingSpan;
  }

  public function info() {
    echo "名前: " . $this->name . " 翼: " . $this->wingSpan . "cm\n";
  }
}

$bird1 = new Bird("キジ", 30);

$bird1->speak();

$bird1->info();

?>

完璧です。
構文・継承・コンストラクタの扱い、すべて正しく書けています。

$bird1 = new Bird("キジ", 30);
$bird1->speak();
$bird1->info();


ここまで意図通り動くので Day9 合格です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

④ 最終確認テスト（短く答える）

Q1. 親クラスのコンストラクタを呼ぶキーワードは？
解答：parent::__construct

Q2. 子クラスが独自に初期化したい値はどこで設定する？
解答：分かりません。

Q3. __construct() は自動で継承されますか？（はい / いいえ）
解答：いいえ。


✅ Q2 の答え

子クラスが独自に初期化したい値はどこで設定する？

解答：子クラス内の __construct() の中で設定する。


✅ わかりやすく一行で

親が共通の初期化をする → parent::__construct()
子は追加の初期化をする → 子クラスの __construct() 内で $this->プロパティ = 値;

Day9：コンストラクタと親子連携を学習しました。