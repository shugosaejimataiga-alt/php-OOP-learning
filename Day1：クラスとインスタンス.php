📘 Day1：クラスとインスタンス
🎯 今日の目標

PHPでクラスとインスタンスの基本構造を理解し、使えるようになる。
$this の意味をつかむ。



① 例題コード（基礎）

ファイル名：stepOOP_day01_class_instance.php

<?php

// 📌 クラスの定義
class Dog {
  // プロパティ（属性）
  public $name;
  public $breed;

  // メソッド（動作）
  public function bark() {
    echo "{$this->name}（{$this->breed}）がワン！と吠えた\n";
  }
}

// 📌 インスタンスの生成
$dog1 = new Dog();
$dog1->name = "ポチ";
$dog1->breed = "柴犬";
$dog1->bark();  // → ポチ（柴犬）がワン！と吠えた

$dog2 = new Dog();
$dog2->name = "レオ";
$dog2->breed = "ゴールデンレトリバー";
$dog2->bark();  // → レオ（ゴールデンレトリバー）がワン！と吠えた

?>



② 解説（丁寧に）

class Dog { ... }
→ 「Dog」という名前の設計図（クラス）を定義している。

public $name;
→ インスタンスごとに異なる「名前」を持てるプロパティ。アクセス修飾子 public で外部からも読み書き可能。

$this->name
→ 今のインスタンス自身（例：$dog1や$dog2）の name にアクセスするという意味。

$dog1 = new Dog();
→ 設計図をもとに1匹の犬（インスタンス）を作成。

$dog1->bark();
→ その犬の「barkメソッド（吠える）」を実行。



③ 練習問題

次のような「猫（Cat）」クラスを作成してください：

name（名前）とcolor（毛色）をプロパティとして持つ。

meow() メソッドで「[名前]（[毛色]）がニャーと鳴いた」と表示。

📄 ファイル名：stepOOP_day01_practice.php


class Cat {
  public $name;
  public $color;

  public function meow() {
    echo "{$name}({$color})がニャーと鳴いた\n";
  }
}

cat1 = new Cat();
cat1->name = "chacha";
cat1->color = "茶色";
cat1->meow();

コードありがとうございます！
しかし、2箇所の修正が必要です：

❌ 修正ポイント

① {$name} と {$color} は $this->name、$this->color に直す必要があります。
→ $this は「このインスタンス自身」という意味なので、プロパティにアクセスするには $this->プロパティ名 と書きます。

② インスタンス生成時に $ が抜けています。
→ cat1 = new Cat(); は正しくは $cat1 = new Cat();

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

練習問題修正版：

class Cat {
  public $name;
  public $color;

  public function meow() {
    echo "{$this->name}({$this->color})がニャーと鳴いた\n";
  }
}

$cat1 = new Cat();
$cat1->name = "chacha";
$cat1->color = "茶色";
$cat1->meow();

完璧です！🎉
しっかり $this->name / $this->color を使い、インスタンス $cat1 にプロパティを設定してメソッドを呼び出せています。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✅ Day1：確認テスト

次の要件を満たす Car クラスを作ってください：

プロパティ：$maker（メーカー名）、$model（車種名）

メソッド：info()
　→「この車は [メーカー名] の [車種名] です」と出力

例：期待される出力例

この車は トヨタ の プリウス です

できたら「できました」と送ってください。確認してDay2へ進みます。

class Car {
  public $maker;
  public $model;

  public function info() {
    echo "この車は{$this->maker}の{$this->model}です\n";
  }
}

$car1 = new Car();
$car1->maker = "トヨタ";
$car1->model = "プリウス";
$car1->info();

素晴らしいです！✨
Day1 の確認テスト「Car クラス」も完璧に実装されています。

✅ 出力結果も期待通り
この車はトヨタのプリウスです

クラス定義、プロパティの設定
$this->プロパティ の使用
new によるインスタンス生成
メソッド呼び出し

すべて正しく理解できています。

🟢 Day1 完了！