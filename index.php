<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'db.php';

$id = $_GET['id'] ?? 'lista';
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Okręty</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="menu">
        <h2>Menu</h2>
        <a href="index.php?id=lista">Lista okrętów</a>
        <a href="index.php?id=zad1">Zad 1</a>
        <a href="index.php?id=zad2">Zad 2</a>
    </div>

    <div class="main">
        <?php
        switch ($id) {
            case 'lista':
                echo '<h2>Lista okrętów</h2>';
                $stmt = $pdo->query(
                    "SELECT o.id_okretu, o.nazwa, o.typ, k.klasa, k.kraj, o.rok_zawodowania
                    FROM okrety o
                     JOIN klasy_okretow k ON o.typ = k.typ
                     ORDER BY o.id_okretu ASC"
                );
                echo '<table>
                        <tr>
                          <th>ID</th><th>Nazwa</th><th>Typ</th>
                          <th>Klasa</th><th>Kraj</th><th>Rok zwodowania</th>
                        </tr>';
                if ($stmt->rowCount()) {
                    foreach ($stmt as $row) {
                        echo "<tr>
                                <td>{$row['id_okretu']}</td>
                                <td>{$row['nazwa']}</td>
                                <td>{$row['typ']}</td>
                                <td>{$row['klasa']}</td>
                                <td>{$row['kraj']}</td>
                                <td>{$row['rok_zawodowania']}</td>
                              </tr>";
                    }
                } else {
                    echo '<tr><td colspan="6">Brak danych.</td></tr>';
                }
                echo '</table>';
                break;

            case 'zad1':
                echo '<h2>Zad 1</h2>';
                $stmt = $pdo->query(
    "SELECT typ, rok_zawodowania
     FROM okrety
     WHERE rok_zawodowania > 1920
     ORDER BY rok_zawodowania ASC"
);
                echo '<table>
                        <tr><th>Typ</th><th>Rok zwodowania</th></tr>';
                if ($stmt->rowCount()) {
                    foreach ($stmt as $row) {
                        echo "<tr>
                                <td>{$row['typ']}</td>
                                <td>{$row['rok_zawodowania']}</td>
                              </tr>";
                    }
                } else {
                    echo '<tr><td colspan="2">Brak wyników.</td></tr>';
                }
                echo '</table>';
                break;

            case 'zad2':
                echo '<h2>Zad 2</h2>';
                $stmt = $pdo->query(
    "SELECT k.typ, k.kraj, COUNT(o.id_okretu) AS liczba
     FROM klasy_okretow k
     LEFT JOIN okrety o ON k.typ = o.typ
     GROUP BY k.typ, k.kraj
     ORDER BY k.typ ASC"
);
                echo '<table>
                        <tr><th>Typ</th><th>Kraj</th><th>Liczba okrętów</th></tr>';
                if ($stmt->rowCount()) {
                    foreach ($stmt as $row) {
                        echo "<tr>
                                <td>{$row['typ']}</td>
                                <td>{$row['kraj']}</td>
                                <td>{$row['liczba']}</td>
                              </tr>";
                    }
                } else {
                    echo '<tr><td colspan="3">Brak danych.</td></tr>';
                }
                echo '</table>';
                break;

            default:
                echo '<h2>Strona okrętów</h2>';
                echo '<p>Wybierz jedną z opcji w menu po lewej stronie.</p>';
        }
        ?>
    </div>
</div>
</body>
</html>
