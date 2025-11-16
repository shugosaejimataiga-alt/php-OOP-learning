📘 Day11：名前空間（namespace）と use

目的：Laravelのような大規模アプリでもクラス名が衝突しない仕組みを理解する。



① 例題コード（実行しながら理解）

まず、同じ「User」というクラスが2つある状況を考えます。
名前空間がないと衝突してエラーになるので、namespace を使います。



▼ ファイル1：App/Models/User.php
<?php

namespace App\Models;

class User {
  public function info() {
    echo "App\Models\User の情報です\n";
  }
}



▼ ファイル2：App/Services/User.php
<?php

namespace App\Services;

class User {
  public function info() {
    echo "App\Services\User のサービス用情報です\n";
  }
}



▼ 実行ファイル：stepOOP_day11_namespace.php
<?php

require_once 'App/Models/User.php';
require_once 'App/Services/User.php';

use App\Models\User as ModelUser;
use App\Services\User as ServiceUser;

$modelUser = new ModelUser();
$serviceUser = new ServiceUser();

$modelUser->info();
$serviceUser->info();



② 解説（端的に）
● namespace とは？

「このクラスはどのフォルダ（領域）のものか」を示すラベル

Laravelの App\Models, App\Http\Controllers がそれ



● 何が嬉しい？

クラス名が重複しても問題なくなる

自動読み込み（Laravelの仕組み）と相性がいい



● use とは？

長いパスを書くのが面倒なので、短く呼ぶための宣言

エイリアス（as）で名前を変えることも可能

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


✅ なぜ namespace / use が必要なのか（端的に）

PHPは複数のファイルにクラスを分けて使うが、同じクラス名が色々な場所で作られるため、名前が衝突して混乱する。それを防ぐための仕組みが namespace。
そして、長いパスを書くのが面倒なので短く呼べるようにするのが use。



🔍 もう少しだけ丁寧に（短く）

PHPは多くのクラスを別々のファイルに置く
開発が大きくなると「User」「Product」など同じ名前のクラスが必ず出てくる
名前が同じだとエラーになる

そこで
　App\Models\User
　App\Services\User
　のように「住所」をつける仕組み＝namespace が必要になる

そしてそのまま書くと長いので、

use App\Models\User;

と書いて「短い名前」で呼べるようにする。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


◆ まず最初に：namespace の本当の意味
❗ namespace は「クラスの住所」です。

PHPは複数のファイルにクラスを分けます。

しかし、クラス名はよく かぶる
（User / Book / Product など）

そこで、
“どこのフォルダの Book なのか” を表すのが namespace。



◆ 1. namespace には何を書けばいい？

結論：
フォルダ構造の「名前」を書く。

実際のフォルダ名と揃えるのが普通。

▼ 例：フォルダ構造
Library/
  Book.php
  Admin/
    Book.php

これを「住所」として書くとこうなる

Library/Book.php

namespace Library;  

Library/Admin/Book.php

namespace Library\Admin;



◆ 2. require_once は何を書く？

結論：
“実際のファイルの場所” を書く。

namespace ではありません

実際のファイルパスを書きます

実行ファイルから見たパスで指定します。
require_once "Library/Book.php";
require_once "Library/Admin/Book.php";


つまり、
namespace と require_once は全く別物です。

namespace → 住所（ラベル）

require_once → 物理ファイルを読み込む命令



◆ 3. use は何をしているのか？

結論：
長い住所を、短い名前に変換するための宣言です。

PHP内部では…

Library\Book

Library\Admin\Book

これは全く別のクラスです。
でも名前は同じ「Book」。

なので、呼ぶときに困ります。

そこで use + as を使う。

▼ use 文の意味（丁寧Ver）
use Library\Book as BookA;

これはこう言っているのと同じ：

「Library\Book を BookA として扱います」

だから…

$book1 = new BookA();

と書ける。

同様に

use Library\Admin\Book as BookB;

は

「Library\Admin\Book を BookB として扱います」

もし use を使わない場合…

毎回こう書く必要があります：

$book1 = new \Library\Book();
$book2 = new \Library\Admin\Book();

長くて見づらいので、
use で短く別名にするのが一般的。



◆ ここで一度まとめ（短く）

namespace … クラスの住所

require_once … 実際のファイルを読み込む

use … 長い住所を短く呼び出すための設定

as … 別の名前を付けて衝突を避ける




ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー


③ 練習問題（あなたが手を動かす）

問1：
Library/Book.php と Library/Admin/Book.php を作り、
どちらにも show() メソッド（内容は違ってOK）を作ってください。

問2：
実行ファイルで use を使い、
Book クラスを2つ呼び分けて show() を実行してください。



Library/Book.php
<?php

namespace Library/Book;

class Book {
  public function show() {
    echo "あいうえお\n";
  }
}

?>


Library/Admin/Book.php
<?php

namespace Library/Admin;

class Book {
  public function show() {
    echo "かきくけこ\n";
  }
}

?>



実行ファイル
<?php

require_once "Library/Book.php";
require_once "Library/Admin/Book.php";

use Library/Book as Book();
use Library/Admin/Book as AdminBook();

$Book = new Book();
$adminBook = new AdminBook();

$Book->show();
$adminBook->show();

?>

❌ あなたのコードで間違っている箇所
① namespace の区切り方

namespace Library/Book;
これは スラッシュ(/) ではなく バックスラッシュ(\) を使います。


② use の書き方

use Library/Book as Book();
これは完全に誤りです。

/ → \

as Book() → as Book（カッコ不要）


③ クラス名の指定

new Book() は OK ですが
use で名前をエイリアスにする場合は正しく合わせる必要があります。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

Library/Book.php
<?php

namespace Library;

class Book {
  public function show() {
    echo "あいうえお\n";
  }
}

?>


Library/Admin/Book.php
<?php

namespace Library\Admin;

class Book {
  public function show() {
    echo "かきくけこ\n";
  }
}

?>



実行ファイル
<?php

require_once "Library/Book.php";
require_once "Library/Admin/Book.php";

use Library\Book as Book1;
use Library\Admin\Book as Book2;

$book1 = new Book1();
$book2 = new Book2();

$book1->show();
$book2->show();

?>



完璧です。
文法も構造もすべて正しく書けています。
実行ファイルも、namespace も、use も、エイリアス（as）も正しい。

あなたのコードは 100点満点で完全に正しい動作をします。

🔍 仕組みの確認（あなたのコードがなぜ正しいか）
① namespace
namespace Library;
namespace Library\Admin;


→ フォルダ構造をそのまま「住所」として書けている。

② require_once
require_once "Library/Book.php";
require_once "Library/Admin/Book.php";


→ 実際のファイルを読み込んでいる。OK。

③ use
use Library\Book as Book1;
use Library\Admin\Book as Book2;


→ 同名の Book クラスを区別するためにエイリアスをつけている。OK。

④ インスタンス化
$book1 = new Book1();
$book2 = new Book2();


→ 宣言したエイリアスを正しく使えている。OK。

⑤ メソッド呼び出し
$book1->show();
$book2->show();


→ それぞれ別の Book クラスが動く。OK。


ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

① Animals/Cat.php

namespace：Animals

メソッド：speak() → 「にゃー」

② Animals/Wild/Cat.php

namespace：Animals\Wild

メソッド：speak() → 「ガオー（野生のネコ）」など好きにしてOK

③ 実行ファイル

require_once で 2つの Cat.php を読み込む

use + as でエイリアス（別名）をつける

インスタンスを2つ作って speak() を呼び分けること



Animals/Cat.php
<?php

namespace Animals;

class Cat {
  public function speak() {
    echo "にゃー\n";
  }
}

?>


Animals/Wild/Cat.php
<?php

namespace Animals\Wild;

class Cat {
  public function speak() {
    echo "がおー\n";
  }
}

?>


実行ファイル
<?php

require_once "Animals/Cat.php";
require_once "Animals/Wild/Cat.php";

use Animals\Cat as cat1;
use Animals\Wild\Cat as cat2;

$cat1 = new cat1();
$cat2 = new cat2();

$cat1->speak();
$cat2->speak();

?>

⚠ 改善点：クラス名のエイリアスは大文字が一般的

PHPでは、クラス名は 必ず大文字始まり（パスカルケース） が一般的な慣習です。

あなたの書き方：

use Animals\Cat as cat1;

動きはするけど、
クラス名に小文字は推奨されません。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

問題修正版：

Animals/Cat.php
<?php

namespace Animals;

class Cat {
  public function speak() {
    echo "にゃー\n";
  }
}

?>


Animals/Wild/Cat.php
<?php

namespace Animals\Wild;

class Cat {
  public function speak() {
    echo "がおー\n";
  }
}

?>


実行ファイル
<?php

require_once "Animals/Cat.php";
require_once "Animals/Wild/Cat.php";

use Animals\Cat as Cat1;
use Animals\Wild\Cat as Cat2;

$cat1 = new Cat1();
$cat2 = new Cat2();

$cat1->speak();
$cat2->speak();

?>

修正版、完全に正しいです。

文法・構造・設計、すべて100%正しく書けています。
あなたの Day11 の理解はもう十分すぎるレベルです。

✅ 良いところ（最終チェック）

namespace Animals;

namespace Animals\Wild;
→ 正しい



require_once "Animals/Cat.php";

require_once "Animals/Wild/Cat.php";
→ ファイルの実パスを正しく読み込めている



use Animals\Cat as Cat1;

use Animals\Wild\Cat as Cat2;
→ 衝突回避のためのエイリアスの付け方も正しい



$cat1 = new Cat1();

$cat2 = new Cat2();
→ use で付けたエイリアスと一致している



$cat1->speak(); / $cat2->speak();
→ 正しく呼び分けられている



何も直す必要がありません。

🎉 完全クリアです

Day11 の内容は、Laravel のコントローラ・モデル・サービス層で必ず使う超重要スキルですが、あなたはすでに十分理解できています。







Day11：名前空間（namespace）と useを学習しました