<?php
require "db.php"; 

$ime    = "";
$email  = "";
$greska = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime   = trim($_POST["ime"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($ime === "") {
        $greska = "Unesi ime.";
    } elseif (mb_strlen($ime) > 50) {
        $greska = "Ime smije imati najviše 50 znakova.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $greska = "E-mail nije ispravan.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO ucenici (ime, email) VALUES (:ime, :email)");
        $stmt->execute([
            ":ime"   => $ime,
            ":email" => $email,
        ]);

        header("Location: ucenici.php?spremljeno=" . $pdo->lastInsertId());
        exit;
    }
}

$stmt   = $pdo->query("SELECT id, ime, email, upisan FROM ucenici ORDER BY id DESC");
$redovi = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spremljeno = (int) ($_GET["spremljeno"] ?? 0);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upis učenika</title>
</head>
<body>
<main>
  <h1>Upis učenika</h1>

  <form action="ucenici.php" method="post">
    <label for="ime">Ime</label>
    <input type="text" id="ime" name="ime" maxlength="50" value="<?= htmlspecialchars($ime) ?>">

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" maxlength="100" value="<?= htmlspecialchars($email) ?>">

    <button type="submit">Spremi</button>
  </form>

  <?php if ($greska !== ""): ?>
    <p><?= htmlspecialchars($greska) ?></p>
  <?php elseif ($spremljeno > 0): ?>
    <p>Spremljeno! ID novog učenika: <?= $spremljeno ?></p>
  <?php endif; ?>

  <h2>Upisani učenici (<?= count($redovi) ?>)</h2>

  <?php if (count($redovi) === 0): ?>
    <p>Još nema upisanih učenika.</p>
  <?php else: ?>
    <table border="1">
      <tr><th>ID</th><th>Ime</th><th>E-mail</th><th>Upisan</th></tr>
      <?php foreach ($redovi as $r): ?>
        <tr>
          <td><?= $r["id"] ?></td>
          <td><?= htmlspecialchars($r["ime"]) ?></td>
          <td><?= htmlspecialchars($r["email"]) ?></td>
          <td><?= htmlspecialchars($r["upisan"]) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</main>
</body>
</html>
