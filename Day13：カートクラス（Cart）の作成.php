📘 Day13：Cart クラスを作る

（目的：複数の商品を扱う「入れ物」を作り、合計金額を計算できるようにする）

このDay13で学ぶ内容は、Laravelでカート処理を作るときに そのまま使える基本ロジック です。



① 例題コード（あなたのレベルに合わせた実務寄り）

stepOOP_day13_cart.php

<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add(Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("ノート", 300);

$cart = new Cart();
$cart->add($product1);
$cart->add($product2);

echo $cart->totalPrice();



② 1つずつ丁寧な説明

最初に Product クラスを読みます。
Product は「商品名」と「価格」を private で保持します。
価格も名前も private なので、外から勝手に変更されません。
取り出したいときだけ getter が使えます。


次に Cart クラスがあります。
Cart の items は空の配列でスタートします。
add() メソッドは Product 型だけ受け入れます。
これにより、Cart に間違った型が入らないようにできます。
add() された商品は items[] に追加されます。

totalPrice() は合計金額を計算する処理です。
$sum = 0; で合計値をゼロからスタートします。
foreach で items 内の商品を1つずつ取り出します。
取り出した商品$pから getPrice() で値段を取得します。
$sum に足していきます。
最後に $sum を返します。

下に実行パートがあります。
Product を2つ作っています（本1500円とノート300円）。
Cart を new します。
add() で2つの商品を追加します。
echo totalPrice() で合計金額が表示されます。
結果は 1800 になります。

これは実務でよくある「カートの仕組み」の最小版です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：

🍎 ① add() がやっていること

public function add(Product $product) {
  $this->items[] = $product;
}

✔ items は「カートの中身」です
items = []
（最初は空）



✔ add() は “Product型の商品” を受け取るメソッド
add(商品A)
add(商品B)
add(飲み物C)

つまり「カートに商品を入れてください」という合図。



✔ $this->items[] = $product;

ここが一番わかりにくいですが、意味は たった1つ。

👉 items という箱の “一番うしろに” 新しい商品を追加している



図にすると：

最初：[]

add(本1500円) 後：
[ 本 ]

add(ノート300円) 後：
[ 本, ノート ]

add(ペン100円) 後：
[ 本, ノート, ペン ]

✔ 「items に商品を並べていく」だけの動作です

難しいことはしていません。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

🍎 ② foreach の totalPrice() がやっていること

foreach ($this->items as $p) {
  $sum += $p->getPrice();
}
return $sum;



この処理は、図にすると ただの足し算。

items の中にはこう並んでいます：

[ 本1500円, ノート300円, ペン100円 ]

foreach は「順番に1個ずつ取り出す」だけ
1回目：$p = 本1500円
2回目：$p = ノート300円
3回目：$p = ペン100円



✔ $p->getPrice()

これは「その商品の値段を取り出す」という意味。

本 → 1500
ノート → 300
ペン → 100



✔ $sum += 値

これは「足していく」。

動作ログとして書くと：

sum = 0（スタート）

1回目： 0 + 1500 → 1500
2回目：1500 + 300  → 1800
3回目：1800 + 100  → 1900

最終的に：

return 1900;

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
(Product $product)こんなこともしていいのですか？
複数クラスを用いて、それらを両方使ってやったことが無いので、わかりませんが、プロ
ダクトクラスのプロダクトのインスタンスを用いているわけですよね？



✅ まず結論
✔（Product $product）は「Product 型のインスタンスしか受け取らない宣言」

つまり：

add() メソッドは、
Product クラスで作られたオブジェクトだけ
受け取ると決めている

という意味です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ あなたが書く練習問題（レベル調整済み）

以下を自分でコードを書いてみてください。

🔹 練習1：
Cart に add() を3回呼び出してみてください。
商品は内容自由でかまいません。

<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add(Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("ノート", 300);
$product3 = new Product("ボール", 3000);

$cart = new Cart();
$cart->add($product1);
$cart->add($product2);
$cart->add($product3);

echo $cart->totalPrice();

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

🔹 練習2：

Cart に「入っている商品名をすべて表示する」displayItems() を追加してください。
中で foreach を使います。

<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add(Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }

  public function displayItems() {
    foreach ($items as $name) {
      echo "入っている商品" . $name . "\n";
    }
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("ノート", 300);
$product3 = new Product("ボール", 3000);

$cart = new Cart();
$cart->add($product1);
$cart->add($product2);
$cart->add($product3);

echo $cart->totalPrice();

$cart->displayItems();

よくここまで書けました。
あと 2ヶ所だけ修正すれば完全に動きます。

修正ポイントは次の2つです：



✅ 修正① $items ではなく $this->items を使う

Cart クラスの中で items を使うときは 常に $this->items です。

理由：
Cart のプロパティだから $this が必要。



✅ 修正② foreach の中で「Productオブジェクト」が入っている

Cart の items の中身は 文字列ではなく Productインスタンス です。

だから $name ではなく $product にして、
中から getName() で商品名を取り出す 必要があります。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習２修正版：


<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add(Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }

  public function displayItems() {
    foreach ($this->items as $product) {
      echo "入っている商品" . $product->getName() . "\n";
    }
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("ノート", 300);
$product3 = new Product("ボール", 3000);

$cart = new Cart();
$cart->add($product1);
$cart->add($product2);
$cart->add($product3);

echo $cart->totalPrice();

$cart->displayItems();





ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

🔹 練習3：

Cart に「商品数を返す」countItems() を追加してください。



<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add(Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }

  public function displayItems() {
    foreach ($this->items as $product) {
      echo "入っている商品" . $product->getName() . "\n";
    }
  }

  public function countItems() {
    return count ($this->items);
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("ノート", 300);
$product3 = new Product("ボール", 3000);

$cart = new Cart();
$cart->add($product1);
$cart->add($product2);
$cart->add($product3);

echo $cart->totalPrice();

$cart->displayItems();

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
なぜrerurnなのですか？


✅ ① 「なぜ return なのか？」

結論
メソッドの結果（答え）を、外に渡すためです。

たとえば：

$cart->countItems();

これは
「カートの中には何個入っていますか？」
と聞いている行です。
だからメソッドは数を 返さないといけません。

返す＝return です。



✔ なぜ echo ではダメなの？

echo はただの「画面に表示するだけ」。

でも countItems() は：
表示目的ではなく
「数値を取り出す」ことが目的

だから echo ではなく return が必要。

Laravelでも
数を返す
文字を返す
配列を返す
オブジェクトを返す
全部 return です。

return は「値を返す（外へ渡す）」ための唯一の手段。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
あと商品の数を返すメソッドってこんな簡単でしたっけ？なんかsum++とかなかったでしたっけ？


✅ ② 「商品数を返すメソッドってこんなに簡単？？」

はい。
めちゃくちゃ簡単です。

なぜなら PHP には count() があるからです。



count(配列)

これだけで配列の要素数を数えられます。

例：

[本, ノート, ボール] → count = 3

だから：

return count($this->items);

これだけで終わりです。



🔥 「sum++ を使う書き方」との違い

あなたが昔覚えたのは、こういう形ですね：

$sum = 0;
foreach (...) {
  $sum++;
}
return $sum;

これは ループで1個ずつ数える方法 です。

PHPでは便利な関数があるから短縮できるだけで、
本質的には同じ意味。

つまり：

✔ ① 自力で1つずつ数える方法（sum++）
✔ ② PHPの count() を使って一瞬で数える方法（今回）

どちらでも正しいです。

でも実務では count() が100%使われます。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

📘 Day13 本質練習 — 完全版テスト

以下の仕様を満たす Product クラス と Cart クラス を自分で書いてください。

🟦 【仕様1】Product クラス

private プロパティ
　- name
　- price

コンストラクタで
　- name
　- price
　を設定すること

名前を取り出す getter（getName）

価格を取り出す getter（getPrice）


🟧 【仕様2】Cart クラス

private プロパティ items（空の配列）

add メソッド

public function add(Product $product)

で Product のインスタンスだけ 追加できるようにすること

totalPrice メソッド
items に入っている すべての商品の価格を合計して返すこと


🟪 【仕様3】実行コード

Product を3つ作る

Cart に add() で追加する

totalPrice() を echo する

<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this-price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items{};

  public function add (Product $product) {
    $this->items[] += $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("スコップ", 500);
$product3 = new Product("ボール", 3000);

$cart1 = new Cart();
$cart1->add($product1);
$cart1->add($product2);
$catt1->add($product3);

eccho $cart1->totalPrice(); . "\n";


🔥 まず修正ポイントだけ一覧で示します

$this-price は $this->price

private $items{} は private $items = [];

$this->items[] += $product; は $this->items[] = $product;

foreach ($items as $p) は foreach ($this->items as $p)

$catt1 は $cart1

eccho は echo

echo $cart1->totalPrice(); . "\n"; は echo $cart1->totalPrice() . "\n";

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

本質練習修正版：

<?php

class Product {
  private $name;
  private $price;

  public function __construct($name, $price) {
    $this->name = $name;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}

class Cart {
  private $items = [];

  public function add (Product $product) {
    $this->items[] = $product;
  }

  public function totalPrice() {
    $sum = 0;
    foreach ($this->items as $p) {
      $sum += $p->getPrice();
    }
    return $sum;
  }
}

$product1 = new Product("本", 1500);
$product2 = new Product("スコップ", 500);
$product3 = new Product("ボール", 3000);

$cart1 = new Cart();
$cart1->add($product1);
$cart1->add($product2);
$cart1->add($product3);

echo $cart1->totalPrice() . "\n";


完璧です。
Day13 の本質を完全にクリアしました。

あなたが今書いたコードは、
・構造
・プロパティの扱い
・コンストラクタ
・getter
・private
・配列への追加
・foreach を用いた総計処理
・型指定（Product $product）
すべて正しく書けています。

🔥 このコードは「OOP の基礎」が揃った実務レベル

実際に Laravel で

Product モデル

Cart サービス
を作る時、まさに これと同じ形 で始まります。

あなたは「クラスを組み合わせて処理を作る」という
本質的なOOP思考 を完全に掴みました。

🧠 最後に確認してほしい動作のイメージ

あなたが書いたコードはこう動いています：

1. Product を3つ作る
本（1500）
スコップ（500）
ボール（3000）

2. Cart に追加する
items = [
  Product("本",1500),
  Product("スコップ",500),
  Product("ボール",3000)
]

3. totalPrice()
sum = 0
本 → +1500 → sum = 1500
スコップ → +500 → sum = 2000
ボール → +3000 → sum = 5000

4. 最終的に 5000 を返す

流れが完全に成立しています。

これで Day13 合格です

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
$this->items[] += $product; は $this->items[] = $product;はなんで+ではないのですか？


$this->items[] += $product; がダメな理由

items の中に入れたいのは
Product オブジェクト です。

オブジェクトは 足し算できません。

つまり：

空の場所に（オブジェクトを足し算して代入する）

という意味不明な処理になります。



✅ 正しいのは「代入」＝ =

配列に要素を追加するときは
足し算ではなく、“その場所に入れる” だけ です。

だから

$this->items[] = $product;

になります。


📌 まとめ（短く）

+= は「数値の足し算」
配列に要素を追加するときに「足し算」はしない
配列へ入れるのは「代入」なので =
よって正解は $this->items[] = $product;