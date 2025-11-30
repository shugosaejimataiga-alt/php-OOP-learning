① Task クラス

タイトル（title）
期限（dueDate：DateTime）
進捗（progress：0〜100）
完了判定（isDone：progress === 100）

getter / setter を適切に使う
→ setter 内でバリデーションを入れること

<?php

class Task {
  private $title;
  private $dueDate;
  private $progress = 0;
  private $isDone = false;

  public function __construct($title, $dueDateString) {
    $this-title = $title;
    $this->setDuedate($dueDateString);
  }

  public function setdueDate($dueDateString) {
    $date = Datetime::createFromFormat("Y-m-d", $dueDateString)

    if (!$date) {
      echo "不正な日付です。\n";
      return;
    } else {
      $this->dueDate = $date;
    }
  }

  public function getdueDate() {
    return $this->dueDate->format("Y-m-d");
  }

  public function setProgress($value) {
    if ($value < 0 || $value >100) {
      echo "0から100の値で設定してください\n";
      return;
    } else {
      $this->progress = $value;
    }
  }

  public function getProgress() {
    return $this->progress;
  }

  public function setmarkDone() {
    if ($this->isDone = true) {
      $this->progress = 100;
      return;
    }
  }

  public function getmarkDone() {
    return $this->isDone;
  }
}
?>

確認しました。
結論から言うと 構造理解は合格ライン ですが、文法ミス＋設計ミスが複数あります。
順に 端的に指摘 → 正しい考え方 を示します。



❌ 文法ミス（致命的）
① $this-title はエラー
$this-title = $title;

→ 正しくは

$this->title = $title;



② メソッド名の不一致
$this->setDuedate($dueDateString);

定義：

public function setdueDate($dueDateString)

→ PHPは大文字小文字を区別しないが、設計上NG
setDueDate / getDueDate に統一すべき



③ セミコロン抜け
$date = Datetime::createFromFormat("Y-m-d", $dueDateString)

→ ; が必要



④ DateTime のクラス名
Datetime

→ 正しくは

DateTime



❌ 設計ミス（OOP的に重要）
⑤ $isDone は不要
private $isDone = false;

要件：

完了判定（isDone：progress === 100）

つまり
✅ 状態を2重管理してはいけない

public function isDone() {
    return $this->progress === 100;
}



⑥ setmarkDone() が代入になっている
if ($this->isDone = true)

→ = は代入
→ 条件式になっていない
→ 常に true

そもそも このメソッド自体が不要 です。


要するに、1つのタスクが出来たか出来ていないかの判定基準をisDoneかprogressの2つを持ってしまったことが問題である。

また、isDone()のメソッドがなぜ必要か。getProgressだけでいいと思う。という疑問に対して、if ($task->getProgress() === 100) {を
毎回聞くことにより、100が終わりであると外にわかってしまうという点と今どれくらいかと終わったかという聞き方の細分化をすることにより
設計が楽になる。保守性が上がる。
1. 外に内部ルール（100＝完了）を漏らしたくない
2. getProgress と isDone は質問が違う
3. isDone() に判定ロジックを閉じ込めるのは OOP の基本：仕様変更が簡単（100 → 90 でも外は変えない）、外部はただ「終わった？」と聞くだけ

✔ 「==」との違い（1番大事）
記号	比較内容
==	値だけ比較（型を無視する）
===	値と型の両方を比較（厳密）
ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

<?php

class Task {
  private $title;
  private $dueDate;
  private $progress = 0;

  public function __construct($title, $dueDateString) {
    $this->title = $title;
    $this->setDueDate($dueDateString);
  }

  public function setDueDate($dueDateString) {
    $date = DateTime::createFromFormat("Y-m-d", $dueDateString);

    if (!$date) {
      echo "不正な日付です。\n";
      return;
    } else {
      $this->dueDate = $date;
    }
  }

  public function getDueDate() {
    return $this->dueDate->format("Y-m-d");
  }

  public function setProgress($value) {
    if ($value < 0 || $value >100) {
      echo "0から100の値で設定してください\n";
      return;
    } else {
      $this->progress = $value;
    }
  }

  public function getProgress() {
    return $this->progress;
  }

  public function isDone() {
    return $this->progress === 100;
  }

}
?>

いいですね。
今の Task クラスは Day15 の要件を“完全に満たしています”。
ここまで仕上げられたのは本当に素晴らしいです。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

📝 TaskManager クラス 要件（あなたはこれを実装する）

① addTask(Task $task)

タスクを配列に追加する。

② listTasks()

全てのタスクを一覧表示（echo）
表示内容は自由だが、最低限：

タイトル
期限
進捗
完了フラグ（progress===100）

<?php

class TaskManager {
  private $tasks = [];

  public function addTasks(Task $task) {
    $this->tasks [] = $task;
  }

  public function listTasks() {
  foreach($this->tasks as $task) {
    echo "タイトル: " . $task->getTitle() . "\n";
    echo "期限: " . $task->getDueDate() . "\n";
    echo "進捗: " . $task->getProgress() . "\n";
    echo "完了: " . ($task->isDone() ? "はい" : "いいえ") . "\n\n";
  }
  }
}

?>

(Task, $task)の$taskはインスタンスを作るとき、変数名は何でもいい。
for文は回数が決まっている時に使う。
while文は無限ループで、条件を変えた時終わる
foreachは配列の中身を取り出したい時、オブジェクトの集合を扱うとき

($task->isDone() ? "はい" : "いいえ")は三項演算子というもので、
if ($task->isDone()) {
    echo "完了: はい";
} else {
    echo "完了: いいえ";
}
を1行に省略して書いているのが($task->isDone() ? "はい" : "いいえ")である。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✔ Day15 テスト③：SaverInterface

📝 SaverInterface の要件

メソッドは save(array $tasks) の1つだけ

戻り値は自由（void でOK）

型定義だけ行い、処理は書かない

<?php

interface SaverInterface  {
  public function save(array $tasks);
}

?>

array は「配列しか受け取らない」という型指定
save「保存する」という意味のメソッド名

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー

✔ Day15 テスト④：ConsoleSaver

これは 「保存＝画面に出すだけ」 の実装です。

📝 ConsoleSaver 要件

SaverInterface を implements する
save(array $tasks) を実装
foreach で Task を順に表示
表示内容は簡単でOK（タイトル＋進捗くらいで十分）

<?php

class ConsoleSaver implements SaverInterface {
  public function save(array $tasks) {
    foreach ($tasks as $task) {
      echo $task->getTitle() . " : " . $task->getProgress() . "%\n";
    }
  }
}

?>

interface は「保存という行為の約束」を定義し、
実装クラスが「実際の保存先と手順」を担当する。

ーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー
TaskManager に SaverInterface を注入（DI）


<?php

class TaskManager {
  private $tasks = [];
  private $saver;

  public function __construct(SaverInterface $saver) {
    $this->saver = $saver;
  }

  public function addTasks(Task $task) {
    $this->tasks [] = $task;
  }

  public function listTasks() {
  foreach($this->tasks as $task) {
    echo "タイトル: " . $task->getTitle() . "\n";
    echo "期限: " . $task->getDueDate() . "\n";
    echo "進捗: " . $task->getProgress() . "\n";
    echo "完了: " . ($task->isDone() ? "はい" : "いいえ") . "\n\n";
    }
  }

  public function save() {
    $this->saver->save($this->tasks);
  }
}

?>

this->saverにSaverInterfaceを継承しているものを
変数$saverとして受け入れ、それをthis->saverに入れる。
その後saveメソッドでthis->saverの中のsaveを使って$tasksを保存する。
そのクラスを、インスタンス生成時に指定する。