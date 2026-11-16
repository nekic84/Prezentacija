<?php
function odrediOcjenu(int $bodovi): int
{
    if ($bodovi >= 85) {
        return 5;
    } elseif ($bodovi >= 75) {
        return 4;
    } elseif ($bodovi >= 60) {
        return 3;
    } elseif ($bodovi >= 46) {
        return 2;
    } else {
        return 1;
    }
}

$ljestvica = [
    5 => ["Odličan", "85 – 100"],
    4 => ["Vrlo dobar", "75 – 84"],
    3 => ["Dobar", "60 – 74"],
    2 => ["Dovoljan", "46 – 59"],
    1 => ["Nedovoljan", "0 – 45"],
];

$ime    = ""; 
$bodovi = null; 
$ocjena = null;  
$greska = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ime = trim($_POST["ime"] ?? "");

    $bodovi = filter_var($_POST["bodovi"] ?? "", FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 0, "max_range" => 100],
    ]);

    if ($ime === "") {
        $greska = "Unesi ime.";
    } elseif ($bodovi === false) {
        $greska = "Bodovi moraju biti cijeli broj od 0 do 100.";
    } else {
        $ocjena = odrediOcjenu($bodovi);
    }
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kalkulator ocjene</title>
</head>
<body>
<main>
  <h1>Kalkulator ocjene</h1>

  <form action="ocjena.php" method="post">
    <label for="ime">Ime</label>
    <input type="text" id="ime" name="ime" value="<?= htmlspecialchars($ime) ?>">

    <label for="bodovi">Bodovi (0 – 100)</label>
    <input type="number" id="bodovi" name="bodovi" min="0" max="100"
           value="<?= htmlspecialchars($_POST["bodovi"] ?? "") ?>">

    <button type="submit">Izračunaj</button>
  </form>

  <?php if ($greska !== ""): ?>
    <p><?= htmlspecialchars($greska) ?></p>
  <?php elseif ($ocjena !== null): ?>
    <p>
      <?= htmlspecialchars($ime) ?>, s <?= $bodovi ?> bodova ocjena je
      <strong><?= $ljestvica[$ocjena][0] ?> (<?= $ocjena ?>)</strong>.
    </p>
  <?php endif; ?>

  <table border="1">
    <tr><th>Bodovi</th><th>Ocjena</th></tr>
    <?php foreach ($ljestvica as $broj => $podaci): ?>
      <tr>
        <td><?= $podaci[1] ?></td>
        <td><?= $podaci[0] ?> (<?= $broj ?>)<?= $broj === $ocjena ? " ← tvoja ocjena" : "" ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</main>
</body>
</html>
