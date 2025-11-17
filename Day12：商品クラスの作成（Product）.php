📘 Day12：商品クラス（Product）を作る

目的：商品名・価格を持つクラスを自分で作り、getter/setterを使えるようにする。
Laravelで商品管理やECを作るときにも必須の概念です。



① 例題コード（stepOOP_day12_product.php）
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

  public function setPrice($price) {
    if ($price < 0) {
      echo "価格は0以上にしてください\n";
      return;
    }
    $this->price = $price;
  }
}

$product1 = new Product("りんご", 120);

echo $product1->getName() . "\n";
echo $product1->getPrice() . "\n";

$product1->setPrice(150);

echo $product1->getPrice() . "\n";



② 1文ずつポイント解説

Product という1つの商品を表すクラスを作る。

商品名 name と 価格 price を、外から直接触られないように private にする。

__construct で商品名と価格を初期設定する。

getName() は、名前を外から読み取るためのメソッド。

getPrice() は、価格を読み取るためのメソッド。

setPrice() は、価格を変更するためのメソッド。

setter にはバリデーション（0以上）を入れて安全にしている。

インスタンス product1 を new Product("りんご", 120) で作る。

getName() と getPrice() を呼び出して値を読む。

setPrice(150) で価格を変更する。

これが OOPの王道パターン（カプセル化＋getter/setter） です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

③ あなたが手を動かす練習問題

以下の仕様で 「ジュース（Juice）」クラス を作ってください。

プロパティ：名前（name）、容量（ml）、価格（price）

プロパティはすべて private

コンストラクタで3つをまとめて初期化する

getName(), getMl(), getPrice() を作る

setPrice() を持たせる（0以上のみ許可）

最後にインスタンスを1つ作って、情報を echo で出す

ファイル名は
stepOOP_day12_practice.php
で保存してください。

書いたら教えてください。確認します。

<?php

class Juice {
  private $name;
  private $ml;
  private $price;

  public function __construct($name, $ml, $price) {
    $this->name = $name;
    $this->ml = $ml;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getML() {
    return $this->ml;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setPrice($price) {
    if($price >= 0) {
      $this->price = $price
    } else {
      echo "価格は0以上にしてください\n";
    }
  }
}

$juice1 = new Juice("ぶどうジュース", 500, 150);
$juice1->getName();
$juice1->getML();
$juice1->getprice();

$juice1->setPrice(-400);

?>

コードは ほぼ完璧 です。
あと 2箇所だけ修正 すれば100点です。

直すポイントはここです：


✅ 修正①：; が抜けています
$this->price = $price   // ← セミコロンが必要


正しくは：

$this->price = $price;



✅ 修正②：結果を出すために echo が必要

今のコードだと、
$juice1->getName() を呼んでも 画面に何も出ません。

getter は値を「返す」だけで
自動で「表示」はしないからです。

正しくは：

echo $juice1->getName() . "\n";
echo $juice1->getML() . "\n";
echo $juice1->getPrice() . "\n";


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

<?php

class Juice {
  private $name;
  private $ml;
  private $price;

  public function __construct($name, $ml, $price) {
    $this->name = $name;
    $this->ml = $ml;
    $this->price = $price;
  }

  public function getName() {
    return $this->name;
  }

  public function getML() {
    return $this->ml;
  }

  public function getPrice() {
    return $this->price;
  }

  public function setPrice($price) {
    if($price >= 0) {
      $this->price = $price;
    } else {
      echo "価格は0以上にしてください\n";
    }
  }
}

$juice1 = new Juice("ぶどうジュース", 500, 150);

echo $juice1->getName() . "\n";
echo $juice1->getML() . "\n";
echo $juice1->getPrice() . "\n";


$juice1->setPrice(-400);

?>

完璧です！！
100点満点の実装です。

すべての要素が正しくできています：

private の使い方

コンストラクタの初期化

getter の実装

setter のバリデーション

echo で値を確認

setPrice(-400) によるエラーメッセージ表示

もう Day12（商品クラス）で学ぶべきことは完全にクリア です。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

疑問：
あなたが提示してくれた例文でのif文にはreturnがついていました。
が、私の解答分にはついていなくて正解でありました。
returnがついていた意味は何だったのですか？


🔍 今回の2つのコードの違い

① あなたのコード
if ($price >= 0) {
  $this->price = $price;
} else {
  echo "価格は0以上にしてください\n";
}

このメソッドの 最後はここで終わり です。
つまり、
if の後に続く処理が存在しない
だから return で止める必要がない
という状態です。


② 例文のコード
if ($price < 0) {
  echo "価格は0以上にしてください\n";
  return;
}

$this->price = $price;

こちらは if の後に処理が続いています。
return がないと、最後の $this->price = $price; が実行されてしまう
return があると、「ここで終わって、下の処理は実行しない」
という違いがある。


🎯 結論（短く）
✔ あなたのコード
if の後には何も処理がない → return 不要

✔ 例文のコード
if の後に代入処理が続いている → return が必要（でないと余計な代入が起きる）



📝 さらに端的に言うと

return は「下に処理があるときだけ必要」。
あなたのコードは、下に何もないから return は不要。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

