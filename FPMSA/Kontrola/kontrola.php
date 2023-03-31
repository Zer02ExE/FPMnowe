<?php
require_once "../config.php"
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Strona z menu pionowym</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../all.css">
    <link rel="stylesheet" href="kontrola.css">
</head>
<body>
<div class="sidebar" onmouseover="openNav()" onmouseout="closeNav()">
  <img src="../logo.png" id="logo">
    <a href="../glowna/glowna.php">Strona Główna</a>
    <a href="../odczyt/odczyt.php">Odczyty </a>
    <a href="../faktury/faktury.php">Faktury </a>
    <p class = "active">Kontrola</p>
  <div id="datetime">
  </div>
</div>
    <div id="contentm">  
        <div id="form">
        <form action="kontrola.php" method="post">
          <table>
            <tr>
              <th colspan="4">
                <?php include "odczyt.php"?>
            </th>
            </tr>
            <tr>
                <td>LICZNIK</td>
                <td>ZUZYCIE W M3</td>
                <td>KWOTA</td>
                <td>UTRZYMANIE</td>
            </tr>
            <?php
              if (isset($_POST['data'])) {
                $data = $_POST['data'];
                if ($data == 'Grudzień 2022') {
                  $numer_miesiaca = '1';
                } else {
                  $numer_miesiaca = substr($data, 5);
                }
                setcookie("numer",$numer_miesiaca,time()+(86400*30),"/");
                $sql = "SELECT SUM(`{$numer_miesiaca}`) AS `suma_miesiac`, SUM(`{$numer_miesiaca}` * 21.5) AS `suma_kwota`, SUM($numer_miesiaca) AS `suma_calosci`, SUM(CASE WHEN id >= 1 AND id <= 7 THEN `{$numer_miesiaca}` ELSE 0 END) AS `suma_id_1_7` FROM kontrola";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $suma_miesiac = $row['suma_miesiac'];
                $suma_kwota = $row['suma_kwota'];
                $summk = $suma_miesiac + $suma_kwota;
                $suma_id_1_7 = $row['suma_id_1_7'];
                $licznik_woda = array();
                $result = mysqli_query($conn, "SELECT * FROM kontrola");
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) { 
                    echo '<tr>';
                    echo '<td>' . $row['Licznik'] . '</td>';
                    echo '<td><input type="text" name="miesiac" value='.$row[$numer_miesiaca].'></td>';
                    echo "<td><p>".$row[$numer_miesiaca]*21.5."</p></td>";
                    echo "<td><p>".$row[$numer_miesiaca]*13.7."</p></td>";
                    echo '<input type="hidden" name="licznik_woda[]" value="' . $row['Licznik'] . '">';
                    echo '</tr>';
                    array_push($licznik_woda, $row['Licznik']);
                  }
                }
                $sqll = "SELECT `$numer_miesiaca` FROM kontrola WHERE id = 17";
                $resultt = mysqli_query($conn, $sqll);
                $roww = mysqli_fetch_assoc($resultt);
                $sumpod = $roww[$numer_miesiaca];
                $suma_pozostala = $suma_miesiac - $suma_id_1_7;
                $sumwoda = $suma_pozostala * 21.5;
                $sumcena = $sumpod * 8.08;
                $sumall = $sumwoda + $sumcena;
                $sumzuz = $suma_pozostala + $sumpod;
                echo '<tr><td>Zużycie wody - rozliczenie(m3)</td><td>'.$suma_miesiac.'</td><td></td><td></td></tr>';
                echo '<tr><td>Cena wody - rozliczenie(kwota)</td><td>'.$suma_kwota.'</td><td></td><td></td></tr>';
                echo '<tr><td>Suma</td><td>' . $suma_pozostala . '</td><td></td><td></td></tr>';
                echo '<tr><td>Zużycie wody podkladka + działki  </td><td>'.$sumzuz.'</td><td></td><td></td></tr>';
                echo '<tr><td>Cena wody podkladka + działki  </td><td>'.$sumall.'</td><td></td><td></td></tr>';
                echo '<tr><td>Zuzycie + cena Rozliczenie </td><td>'.$summk.'</td><td></td><td></td></tr>';
              }
                else {
                  echo '<tr><td colspan="4">Brak danych dla wybranego miesiąca.</td></tr>';
                }
            ?>
          </table>
          <button type="submit" class="chaged" name="submit" value="save_changes">Zapisz zmiany</button>
        </form>
        <?php
          if (isset($_POST['submit_woda']) && $_POST['submit_woda'] == 'save_changes_woda') {
            // Zapisz zmiany w bazie danych
            if (isset($_POST['licznik_woda']) && isset($_POST['kwota_woda'])) {
              $liczniki_woda = $_POST['licznik_woda'];
              $kwoty_woda = $_POST['kwota_woda'];
              for ($i = 1; $i < count($liczniki_woda)+1; $i++) {
                $licznik_woda = mysqli_real_escape_string($conn, $liczniki_woda[$i-1]);
                $kwota_woda = mysqli_real_escape_string($conn, $kwoty_woda[$i-1]);
                $sql_woda = "UPDATE stanlicznikowwoda SET `$numer_miesiaca_woda` = '$kwota_woda' WHERE id = '$i'";
                mysqli_query($conn, $sql_woda);
              }
              echo"zmieniono";
            }
            else {
              echo "Nie wprowadzono żadnych zmian.";
            }
          }
        ?>
        </div>
        <table style="width:30%;">
          <tr>
            <th>PDF</th>
            <th>PRZYCISK</th>
          </tr>

          <tr>
            <td>BESET</td>
            <td><a href="../pdf/besetpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>METROB</td>
            <td><a href="../pdf/metrobpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>PLASTOMIX</td>
            <td><a href="../pdf/plastomixpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>KAREL</td>
            <td><a href="../pdf/karelpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>PKP</td>
            <td><a href="../pdf/pkppdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>SORYKS</td>
            <td><a href="../pdf/sorykspdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>LESTER</td>
            <td><a href="../pdf/lesterpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>Dzialki POD "Kolejarz"</td>
            <td><a href="../pdf/dzialkipdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>MAR-PLAST</td>
            <td><a href="../pdf/marplastpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>JAWO</td>
            <td><a href="../pdf/jawopdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>PALSERWIS WODa</td>
            <td><a href="palserwiswosapdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>PALSERWIS GAZ</td>
            <td><a href="../pdf/palserwisgaz.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>STOR</td>
            <td><a href="../pdf/storpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>TRANSPROJECT</td>
            <td><a href="../pdf/transprojectpdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>OLSZYNKA</td>
            <td><a href="../pdf/olszynkapdf.php">Przejdź</a></td>
          </tr>
          <tr>
            <td>RZEPKA</td>
            <td><a href="../pdf/rzepkapdf.php">Przejdź</a></td>
          </tr>
        </table>
    </div>
    <script src="../all.js"></script>
  </body>
</html>