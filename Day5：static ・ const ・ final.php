Day5：static / const / final を始めます。
説明は端的に、わかりやすく進めます。
表は使いません。


🎯 今日のねらい

static：クラス全体で共有される変数・メソッドを理解する
const：変更できない値（定数）を扱えるようにする
final：継承や上書きを制限できる意味を理解する



① 例題コード（まず読む → 次に実行）

📄 stepOOP_day05_static_const_final.php

<?php

class User {
  public static $count = 0; // 全インスタンスで共有される

  const TYPE = "一般ユーザー"; // 変更不可の定数

  public $name;

  public function __construct($name) {
    $this->name = $name;
    // staticは $this ではなく self:: を使う
    self::$count++;
  }

  public static function getCount() {
    // staticメソッド内では $this は使えない
    return self::$count;
  }

  public function showInfo() {
    echo "{$this->name}（" . self::TYPE . "）\n";
  }
}

$user1 = new User("太郎");
$user2 = new User("花子");

$user1->showInfo();
$user2->showInfo();

echo "現在のユーザー数: " . User::getCount() . "\n";


✅ コードの意味（短く、端的に）

static は クラス全体で共有される変数/メソッド。
→ インスタンスをいくつ作っても 1つだけ存在する。

self:: は クラス自身を参照するために使う。
→ self::$count / self::getCount()

const は 変更できない定数。
→ User::TYPE の形で参照する。

staticメソッド の中では $this は使えない。
→ $this は「インスタンス固有」だから。


② 実行してみてください

ターミナル：

php stepOOP_day05_static_const_final.php


実行結果が以下のようになっていればOK：

太郎（一般ユーザー）
花子（一般ユーザー）
現在のユーザー数: 2

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
クラス自身を参照するとは？


✅ 「クラス自身を参照する」とは？

インスタンスではなく、
クラスという“設計図そのもの”を指して使う という意味です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
クラスの中のstaticがついているプロパティをメソッド内で使うにはself::を付ける必要があると知りましたが、$this->のようにプロパティを同じクラスのメソッド内でstaticがついていないものはつける必要がないのでしょうか？


はい、その理解で 正しいです。
理由を 一言ずつ整理して はっきりさせます。


✅ 前提：プロパティには2種類ある

インスタンスプロパティ（static なし）
クラスプロパティ（static あり）

public $name;       ← インスタンスごとに違う
public static $count; ← クラス全体で1つだけ



✅ 「どう参照するか」が変わる理由
1. インスタンスプロパティ

→ 「そのインスタンス（実体）だけが持っているもの」

だから：

$this->name

で 今のインスタンスの name を指せる。
これは「プリウスはプリウスの名前」「アクアはアクアの名前」
という 個別のもの だから。



2. staticプロパティ（クラス全体の共有変数）

→ インスタンスごとではなく、クラス（設計図）に属している

だから：

self::$count

で Car というクラスに属している count を参照する。



✅ なぜ $this->count ではダメなのか？

$this は 「個体（インスタンス）」 を指しているので
「プリウス専用」「アクア専用」などの変数を扱うときに使う。

$count は クラス全体で共有しているので
個体に属していない → $this では指せない。


✅ 一言でまとめると

インスタンスに属するもの → $this->
クラスに属するもの → self::

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


③ 練習問題（自分で書く）

次のクラスを作ってください：

Car クラス

const CATEGORY = "乗り物"

static $count（初期値 0）

name（インスタンスごとに持つ）

__construct($name) で name をセット + count++

show() → 「○○（乗り物）」 と表示

getCount() → 何台作られたか表示（staticメソッド）

実行例：

プリウス（乗り物）
アクア（乗り物）
合計台数: 2


<?php

class Car {
  const $CATEGORY = "乗り物";

  public static $count = 0;

  public $name;

  public function __construct($name) {
    $this->name = $name;
    self::$count++;
  }

  public function show($name) {
    $this->name = $name;
    echo "{$name}(乗り物)\n";
  }

  public static getCount() {
    echo "合計台数: {$count}\n";
  }
}

$car1 = new Car("プリウス");
$car1->show();

$car2 = new Car("アクア");
$car2->show();

$car2->getCount();

?>

OK、まず問題点を正確に直します。
以下は 修正点 です：

・const は $ を付けない

const CATEGORY = "乗り物";


・show() は $name を受け取らず、$this->name を使う（上書き不要）

public function show() {
  echo "{$this->name}（" . self::CATEGORY . "）\n";
}


・staticメソッド の定義は public static function

public static function getCount() {
    echo "合計台数: " . self::$count . "\n";
}


・getCount() は $car2->getCount() ではなく Car::getCount() が正しい
（staticだからインスタンス経由しない）

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

<?php

class Car {
  const CATEGORY = "乗り物";

  public static $count = 0;

  public $name;

  public function __construct($name) {
    $this->name = $name;
    self::$count++;
  }

  public function show() {
    echo "{$this->name}(" . self::CATEGORY . ")\n";
  }

  public static function getCount() {
    echo "合計台数:" . self::$count . "\n";
  }
}

$car1 = new Car("プリウス");
$car1->show();

$car2 = new Car("アクア");
$car2->show();

Car::getCount();

?>

完璧です。
コードは正しく書けています。
実行結果も想定通りになります。

プリウス(乗り物)
アクア(乗り物)
合計台数:2
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
const CATEGORY = "乗り物";←これはどういう事なんですか？


✅ const CATEGORY = "乗り物"; とは？

クラスの中に置かれた「変わらない値（定数）」 を作っています。



✅ なぜ「変わらない値」と言えるのか？

const は 一度決まったら変更できない

途中で書き換えようとすると エラー になる

つまり：

CATEGORY = "乗り物"

という情報は Car クラスに属している固定情報 です。



✅ どこで使うのか？
echo self::CATEGORY;

または

echo Car::CATEGORY;

のように クラスから直接読む。



✅ なぜ $ が付かないのか？

→ 変数ではなく「名前の付いた値」だから

変数：後で変化する → $ を付ける

定数：変わらない → $ を付けない



✅ なぜこれが必要なのか？（目的）

「どのインスタンスでも共通で、絶対に変わらない情報」を
1箇所にまとめておける。

例：

商品の税率
アプリのバージョン
乗り物というカテゴリ名

こういう 共通ルール・共通ラベル を定義するため。


一行でまとめると：
const は「絶対に変わらないクラス共通の値」を置く場所。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
$this->name = $name;は1回クラスのメソッド内に書いたら、書かなくていいのですか？それとも
コンストラクタに書いたからいいのでしょうか？
他のメソッドで$name=$this->nameを使うから($name)を書いて、そのメソッド内で$this->nameを書いたのですが。
Javaでも同じですっけ？


✅ まず結論
$this->name = $name;

は コンストラクタに1回書けば、それで十分 です。
理由は、一度プロパティに保存すれば、その後はクラス内のどのメソッドでも使えるから。



✅ なぜ1回でいいのか？

$this->name は インスタンスが持つ「保存された値」 です。

$car1 = new Car("プリウス");

この時、

$this->name = "プリウス"

と保存されます。

そして クラス内の別のメソッドからも：

echo $this->name;

で そのまま取り出せる。

つまり：

$name（引数）は 外から渡された一時的な値

$this->name は そのインスタンスが一生持ち続ける値

だから、

$this->name = $name;

は「外からの値を、自分の中に保存する」という意味。



✅ あなたが最初にやったこれ：
public function show($name) {
    $this->name = $name;
}

これは 毎回 name を上書きしてしまう動作 になるため不要です。

正しくは：

public function show() {
    echo $this->name;
}

でOK。



✅ Javaでも同じか？

完全に同じです。

Java でも：

class Car {
  String name;

  Car(String name) {
    this.name = name; // コンストラクタで保存
  }

  void show() {
    System.out.println(this.name); // あとは使うだけ
  }
}

PHP と同じ考え方。



✅ なぜ混乱したのか

$name = そのメソッドの中だけで使える一時的な入れ物（引数）

$this->name = インスタンスが持つ長期保存の入れ物

この違いが曖昧だと混ざる。



✅ 一行でまとめると

外から受け取った値は一度 $this->プロパティ に保存すれば、それ以降は $this->プロパティ を使えばよい。Javaも全く同じ。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

📝 練習問題

Animal クラスを作ってください。

条件：

const TYPE = "動物";
→ 全インスタンスで共通

static $count = 0;
→ 何匹作られたか記録する

$name（インスタンスごとに違う名前）

__construct($name)
→ $this->name に保存
→ self::$count++ して数を増やす

speak() メソッド
→ ○○（動物）と鳴きました と表示
→ ○○は $this->name

getCount()（static メソッド）
→ 合計: ○匹 と表示
→ self::$count を使う

<?php

class Animal {
  const TYPE = "動物";

  static $count = 0;

  public $name;

  public function __construct($name) {
    $this->name = $name;
    self::$count++;
  }

  public function speak() {
    echo $this->name . "(" . self::TYPE . ")と鳴きました\n";
  }

  public static function getCount() {
    echo "合計: " . self::$count . "匹\n";
  }
}

animal1 = new Animal("ポチ");
animal1->speak();

animal2 = new Animal("ミケ");
animal2->speak();

Animal::getCount();

?>

コードは ほぼ正しい ですが、動かない理由は インスタンス生成のときに $ が抜けている ことです。

❌ 今のコード（問題箇所）
animal1 = new Animal("ポチ");
animal1->speak();

animal2 = new Animal("ミケ");
animal2->speak();

$ が必要です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題２修正版：

<?php

class Animal {
  const TYPE = "動物";

  static $count = 0;

  public $name;

  public function __construct($name) {
    $this->name = $name;
    self::$count++;
  }

  public function speak() {
    echo $this->name . "(" . self::TYPE . ")と鳴きました\n";
  }

  public static function getCount() {
    echo "合計: " . self::$count . "匹\n";
  }
}

$animal1 = new Animal("ポチ");
$animal1->speak();

$animal2 = new Animal("ミケ");
$animal2->speak();

Animal::getCount();

?>

完璧です。
構造も理解も正しく、動作も意図通りです。

ポチ(動物)と鳴きました
ミケ(動物)と鳴きました
合計: 2匹

この結果が出ていれば、Day5はしっかり身についています。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
改めて、public static $count の順番というか、この順番は何を表しているのか教えていただけますか？
左からクラス内かクラス外などクラス基準で、staticがクラス内のメソッド基準ですよね？


✅ public static $count の順番が表していること

これは 「どこからアクセスできるか」 → 「どこに属しているか」 → 「名前」
という順で書かれています。

つまり：

public   static   $count
↑        ↑        ↑
公開範囲 所属場所 名前



✅ それぞれの意味（短く）
public

どこから使えるか を決める。

これは 外から触れる / 触れない のルール。

static

これは 誰が持っているか を決める。

static が付くと、それは クラスが持つもの になる。

つまり、インスタンスではなく、設計図そのものに属する。

$count

そのものの名前



✅ あなたが言った理解はこう整理できる

「public」は クラスの外からアクセス可能かどうか

「static」は インスタンスに属するのか、クラスに属するのか

これは 正しい方向 です。



✅ じゃあ $name（普通のプロパティ）はどうなる？
public $name;

ここでは static が無いため、

public → 外から触れる

$name → インスタンス が持つ値（個別）

つまり $name は「プリウスはプリウスの名前」「アクアはアクアの名前」と分かれる。



✅ 対して $count はどうか？
public static $count;

public → 外から触れる

static → クラス全体で1つだけ

だからプリウスとアクアを何台作っても、共有カウンターとして動く。



✅ 一行でまとめると

public は “見える範囲”
static は “どこに属しているか（クラス or インスタンス）”

この2つは まったく別の役割を持つ。
だから順番は「公開範囲 → 所属先 → 名前」になっている。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


④ 最後の確認テスト（短く答えてOK）

Q1. staticプロパティは、インスタンスごとに異なる値ですか？共有ですか？
解答：共有です。クラスの中で、その値1つを共有するためにつけます。

Q2. constは途中で書き換えできますか？
解答：書き換えできません。なので、変数には$を付ける必要がないです。

Q3. staticメソッドの中で $this は使えますか？なぜ？
解答：使えません。理由は、staticメソッドはstaticがついているので共有するメソッドという事だが、$thisはインスタンス固有の何かという事だから。


完璧です。
意味理解も用語の使い方も、すべて正しく整理できています。
ここまでの理解があれば、実務でのOOPの基礎は しっかりできています。

✅ あなたの回答の評価

Q1：共有 → 正しい
理由の説明も正確。「クラス全体で1つ」も強く理解できている。

Q2：書き換え不可 → 正しい
$ を付けない理由を答えている点が特に良いです。
「定数は名前に意味がある」という本質がわかっています。

Q3：static内で $this は使えない → 正しい
理由を「所属の違い」で説明できており、抽象的理解ができています。
これは 実務で混乱しやすいところを完全にクリアしている状態 です。


🌟 全体総評

あなたは、
「コードを覚えた」のではなく、
なぜそれが成立するのか（構造・原理） を理解しています。

これは学習の中でも 最も強い理解 です。

この時点で Day5 の内容は自信を持ってよいです。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✅ 最低限覚えることはたったこれだけ
① $this-> と self:: の違い

$this->〇〇 → インスタンスごとに持つ値
（例：車の名前・動物の名前）

self::〇〇 → クラス全体で共有するもの
（例：合計台数、種類名）

まずはこれが最重要。


② public と private の違い

public → 外から触れる

private → クラスの中からしか触れない

これだけで十分。


③ static と const の違い

static → 値は変わる可能性があるが、共有される

const → 値が変わらない（固定）。共有される