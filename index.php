<?php
require 'db.php';

$id = $_GET['id'] ?? 'home';

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
            $conn = new mysqli("localhost", "root", "", "nazwa_bazy");

            if ($conn->connect_errno) {
                echo "<p>Błąd połączenia z bazą danych: " . $conn->connect_error . "</p>";
                exit();
            }

            $id = $_GET['id'] ?? 'lista';

            if ($id == 'lista') {
                echo "<h2>Lista okrętów</h2>";
                $res = $conn->query("
                    SELECT o.id_okretu, o.nazwa, o.typ, k.klasa, k.kraj, o.rok_zawodowania
                    FROM okrety o
                    JOIN klasy_okretow k ON o.typ = k.typ
                ");

                echo "<table>
                    <tr><th>ID</th><th>Nazwa</th><th>Typ</th><th>Klasa</th><th>Kraj</th><th>Rok</th></tr>";
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id_okretu']}</td>
                        <td>{$row['nazwa']}</td>
                        <td>{$row['typ']}</td>
                        <td>{$row['klasa']}</td>
                        <td>{$row['kraj']}</td>
                        <td>{$row['rok_zawodowania']}</td>
                    </tr>";
                }
                echo "</table>";
            }

            elseif ($id == 'zad1') {
                echo "<h2>Okręty zwodowane po 1920 roku</h2>";
                $res = $conn->query("
                    SELECT typ, rok_zawodowania
                    FROM okrety
                    WHERE rok_zawodowania > 1920
                ");

                echo "<table>
                    <tr><th>Typ</th><th>Rok zwodowania</th></tr>";
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['typ']}</td>
                        <td>{$row['rok_zawodowania']}</td>
                    </tr>";
                }
                echo "</table>";
            }

            elseif ($id == 'zad2') {
                echo "<h2>Statystyka typów okrętów</h2>";
                $res = $conn->query("
                    SELECT k.typ, k.kraj, COUNT(o.id_okretu) AS liczba
                    FROM klasy_okretow k
                    LEFT JOIN okrety o ON k.typ = o.typ
                    GROUP BY k.typ, k.kraj
                ");

                echo "<table>
                    <tr><th>Typ</th><th>Kraj</th><th>Liczba okrętów</th></tr>";
                while ($row = $res->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['typ']}</td>
                        <td>{$row['kraj']}</td>
                        <td>{$row['liczba']}</td>
                    </tr>";
                }
                echo "</table>";
            }

            else {
                echo "<h2>Witamy na stronie okrętów</h2>";
                echo "<p>Wybierz podstronę z menu po lewej stronie.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
