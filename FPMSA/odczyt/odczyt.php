<?php
include "../config.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Odczyt Woda</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../all.css">
    <link rel="stylesheet" href="odczyt.css">
  </head>
  <body>
    <div class="sidebar" onmouseover="openNav()" onmouseout="closeNav()">
      <img src="../logo.png" id="logo">
      <a href="../glowna/glowna.php">Strona Główna</a>
      <p class="active">Odczyty</p>
      <a href="../faktury/faktury.php">Faktury</a>
      <a href="../Kontrola/kontrola.php">Kontrola</a>
      <div id="datetime"></div>
    </div>
    <div id="contentm">
      <!-- ----------------------------------------- WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA  WODA --------------------- -->
      <div id="formwoda">
        <form action="odczyt.php" method="post">
          <h1 style="text-align:center;">STAN LICZNIKÓW WODA</h1>
          <table>
            <tr>
              <th colspan="3">
                <?php include "opcjewoda.php"?>
              </th>
            </tr>
            <tr id="lad">
              <th>LICZNIK</th>
              <th>KWOTA</th>
              <th>ZUŻYCIE(M³)</th>
            </tr>
            <?php
              if (isset($_POST['data_woda'])) {
                $data_woda = $_POST['data_woda'];
                if ($data_woda == 'Grudzień 2022') {
                    $numer_miesiaca_woda = '1';
                } else {
                    $numer_miesiaca_woda = substr($data_woda, 5);
                }
                $sql_woda = "SELECT * FROM stanlicznikowwoda";
                $result_woda = mysqli_query($conn, $sql_woda);
                if(mysqli_num_rows($result_woda)>0)
                {
                  $suma_zuzycia_woda = 0;
                  $zuzw_beset2=0;
                  $zuzw_metrob2=0;
                  $zuzw_plastomix2=0;
                  $zuzw_soryks2=0;
                  $zuzw_stor2=0;
                  $zuzw_beset1=0;
                  $zuzw_metrob1=0;
                  $zuzw_plastomix1=0;
                  $zuzw_soryks1=0;
                  $zuzw_stor1=0;
                  $zuzw_stor3=0;
                  $count_stor=0;
                  $star=0;
                  $UMYWALKA_Budynek_1146_NAWA_VII =0;
                  $BUDYNEK_1183_MAGAZYN_FARB =0;
                  $BUDYNEK_1120_NOWY_BIUROWIEC =0;
                  $BUDYNEK_1121_WODA_CIEPLA =0;
                  $BUDYNEK_1121_WODA_ZIMNA =0;
                  $BUDYNEK_1171_WODA_ZIMNA_STAROSTWO =0;
                  $WODA_CIEPLA_1171_ZASILANIE_STAROSTWO =0;
                  $WODA_CIEPLA_1171_POWROT_STAROSTWO =0;
                  $BUDYNEK_1171_WODA_CIEPLA_STAROSTWO =0;
                  $Karel =0;
                  $PKP =0;
                  $LESTER =0;
                  $POD_KOLEJARZ =0;
                  $MAR_PLAST =0;
                  $JAWO =0;
                  $PALSERWIS =0;
                  $TRANSPROJECT =0;
                  $MARTEX_OLSZYNKA =0;
                  $RZEPKA =0;
                  while ($row_woda = mysqli_fetch_assoc($result_woda)) {
                    echo '<tr>';
                    echo '<td>' . $row_woda['Licznik'] . '</td>';
                    echo '<td><input type="text" name="kwota_woda[]" value="' . $row_woda[$numer_miesiaca_woda] . '"></td>';
                    $prev_month_woda = $numer_miesiaca_woda - 1;
                    if ($prev_month_woda <= 0) {
                        echo '<td>0</td>';
                    } else {
                      if($row_woda['Licznik'] == "BESET") 
                    {
                      $zuzw_beset1=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if($zuzw_beset1!=0&&$zuzw_beset2==0)
                      {
                        $zuzw_beset2=$zuzw_beset1;
                      }
                    }
                    if($row_woda['Licznik'] == "METROB") 
                    {
                      $zuzw_metrob1=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if($zuzw_metrob1!=0&&$zuzw_metrob2==0)
                      {
                        $zuzw_metrob2=$zuzw_metrob1;
                      }
                    }
                    if($row_woda['Licznik'] == "PLASTOMIX") 
                    {
                      $zuzw_plastomix1=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if($zuzw_plastomix1!=0&&$zuzw_plastomix2==0)
                      {
                        $zuzw_plastomix2=$zuzw_plastomix1;
                      }
                    }
                    if($row_woda['Licznik'] == "SORYKS") 
                    {
                      $zuzw_soryks1=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if($zuzw_soryks1!=0&&$zuzw_soryks2==0)
                      {
                        $zuzw_soryks2=$zuzw_soryks1;
                      }
                    }
                    $stor1=$row_woda;
                    if($row_woda['Licznik'] == "STOR") 
                    {
                      $count_stor+=1;
                      $zuzw_stor1=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if($zuzw_stor2!=0&&$zuzw_stor3==0&&$count_stor==2)
                      {
                        $zuzw_stor3=$zuzw_stor1;
                      }
                      if($zuzw_stor2==0)
                      {
                        $zuzw_stor2=$zuzw_stor1;
                      }
                    }
                    if($row_woda['Licznik']=="Woda ciepla 1171 - zasilanie - STAROSTWO")
                    {
                      $zas_star=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if(!$zas_star>0)
                      {
                        $zas_star=0;
                      }
                    }
                    if($row_woda['Licznik']=="Woda ciepla 1171 - powrot - STAROSTWO")
                    {
                      $pow_star=$row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                      if(!$pow_star>0)
                      {
                        $pow_star=0;
                      }
                      $star=$zas_star-$pow_star;
                      if(!$star>0)
                      {
                        $star=0;
                      }
                    }
                          $zuzycie_woda = $row_woda[$numer_miesiaca_woda] - $row_woda[$prev_month_woda];
                          $zuzycie_woda = ($zuzycie_woda > 0 ? $zuzycie_woda : 0);
                          echo '<td>' . $zuzycie_woda .'</td>';
                          $suma_zuzycia_woda += $zuzycie_woda;
                          $odejmowanie_woda = $row_woda[$prev_month_woda];
                          if ($row_woda['Licznik'] == 'UMYWALKA - BUDYNEK 1146 NAWA VII') {
                            $UMYWALKA_Budynek_1146_NAWA_VII = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'BUDYNEK 1183 - MAGAZYN FARB') {
                            $BUDYNEK_1183_MAGAZYN_FARB = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'BUDYNEK 1120') {
                            $BUDYNEK_1120_NOWY_BIUROWIEC = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'PIWNICA 1121 ZB. WODY CIEPLEJ ( 1121+1171)') {
                            $BUDYNEK_1121_WODA_CIEPLA = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'PIWNICA 1121 ZB. WODY ZIMNEJ ( 1121+1171)') {
                            $BUDYNEK_1121_WODA_ZIMNA = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'Woda zimna 1171 - STAROSTWO') {
                            $BUDYNEK_1171_WODA_ZIMNA_STAROSTWO = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'Woda ciepla 1171 - zasilanie - STAROSTWO') {
                            $WODA_CIEPLA_1171_ZASILANIE_STAROSTWO = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'Woda ciepla 1171 - powrot - STAROSTWO') {
                            $WODA_CIEPLA_1171_POWROT_STAROSTWO = $zuzycie_woda;
                        } if ($row_woda['Licznik'] == 'Karel'){
                          $Karel = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'PKP'){
                          $PKP = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'LESTER'){
                          $LESTER = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'POD KOLEJARZ'){
                          $POD_KOLEJARZ = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'MAR-PLAST'){
                          $MAR_PLAST = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'JAWO'){
                          $JAWO = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'PALSERWIS'){
                          $PALSERWIS = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'TRANSPROJECT'){
                          $TRANSPROJECT = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'MARTEX-OLSZYNKA'){
                          $MARTEX_OLSZYNKA = $zuzycie_woda;
                        }if ($row_woda['Licznik'] == 'RZEPKA'){
                          $RZEPKA = $zuzycie_woda;
                        }
                    }
                    echo '<input type="hidden" name="licznik_woda[]" value="' . $row_woda['Licznik'] . '">';
                    echo '</tr>';
                }
                
                  $zuzw_beset=$zuzw_beset1+$zuzw_beset2;      
                  echo "<tr><td colspan='3'></td></tr>";
                  if($zuzw_beset>0)
                  {
                  echo '<tr><td colspan="2">BESET:</td><td>' . $zuzw_beset . '</td></tr>';
                  }
                  else {
                    $zuzw_beset=0;
                    echo '<tr><td colspan="2">BESET:</td><td>0</td></tr>';
                  };
                  $zuzw_metrob=$zuzw_metrob1+$zuzw_metrob2;
                  if($zuzw_metrob>0)
                  {
                  echo '<tr><td colspan="2">METROB:</td><td>' . $zuzw_metrob . '</td></tr>';
                  }
                  else {
                    $zuzw_metrob=0;
                    echo '<tr><td colspan="2">METROB:</td><td>0</td></tr>';
                  };
                  $zuzw_plastomix=$zuzw_plastomix1+$zuzw_plastomix2;
                  if($zuzw_plastomix>0)
                  {
                  echo '<tr><td colspan="2">PLASTOMIX:</td><td>' . $zuzw_plastomix . '</td></tr>';
                  }
                  else {
                    $zuzw_plastomix=0;
                    echo '<tr><td colspan="2">PLASTOMIX:</td><td>0</td></tr>';
                  };
                  $zuzw_soryks=$zuzw_soryks1+$zuzw_soryks2;
                  if($zuzw_soryks>0)
                  {
                  echo '<tr><td colspan="2">SORYKS:</td><td>' . $zuzw_soryks . '</td></tr>';
                  }
                  else {
                    $zuzw_soryks=0;
                    echo '<tr><td colspan="2">SORYKS:</td><td>0</td></tr>';
                  };
                  $zuzw_stor=$zuzw_stor1+$zuzw_stor2+$zuzw_stor3;
                  if($zuzw_stor>0)
                  {
                  echo '<tr><td colspan="2">STOR:</td><td>' . $zuzw_stor . '</td></tr>';
                  }
                  else {
                    $zuzw_stor=0;
                    echo '<tr><td colspan="2">STOR:</td><td>0</td></tr>';
                  };
                  if($star>0)
                  {
                  echo '<tr><td colspan="2">STAROSTWO (CIEPLA):</td><td>' . $star . '</td></tr>';
                  }
                  else {
                    echo '<tr><td colspan="2">STAROSTWO (CIEPLA):</td><td>0</td></tr>';
                  };
                  if ($suma_zuzycia_woda > 0) {
                      echo '<tr><td colspan="2">Suma:</td><td>' . $suma_zuzycia_woda . '</td></tr>';
                  } else {
                      echo '<tr><td colspan="2">Suma:</td><td>0</td></tr>';
                  }
                }
                else {
                  echo '<tr><td colspan="3">Brak danych dla wybranego miesiąca.</td></tr>';
                }
              }
            ?>
          </table>
          <button type="submit" class="chaged" name="submit_woda" value="save_changes_woda">Zapisz zmiany</button>
        </form>
        <?php
          if (isset($_POST['submit_woda']) && $_POST['submit_woda'] == 'save_changes_woda') {
            if (isset($_POST['licznik_woda']) && isset($_POST['kwota_woda'])) {
              $liczniki_woda = $_POST['licznik_woda'];
              $kwoty_woda = $_POST['kwota_woda'];
              for ($i = 1; $i < count($liczniki_woda)+1; $i++) {
                $licznik_woda = mysqli_real_escape_string($conn, $liczniki_woda[$i-1]);
                $kwota_woda = mysqli_real_escape_string($conn, $kwoty_woda[$i-1]);
                $sql_woda = "UPDATE stanlicznikowwoda SET `$numer_miesiaca_woda` = '$kwota_woda' WHERE id = '$i'";
                mysqli_query($conn, $sql_woda);
              }
              $BUDYNEK_1121_WODA_ZIMNA = $BUDYNEK_1121_WODA_ZIMNA - $BUDYNEK_1171_WODA_ZIMNA_STAROSTWO;
              
              if($BUDYNEK_1121_WODA_ZIMNA<=0)
              {
                $BUDYNEK_1121_WODA_ZIMNA=0;
              }
              $BUDYNEK_1121_WODA_CIEPLA = $BUDYNEK_1121_WODA_CIEPLA - $star;
              if($BUDYNEK_1121_WODA_CIEPLA<=0)
              {
                $BUDYNEK_1121_WODA_CIEPLA=0;
              }
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$zuzw_beset' WHERE Licznik='BESET'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$zuzw_metrob' WHERE Licznik='METROB'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$zuzw_plastomix' WHERE Licznik='PLASTOMIX'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$zuzw_soryks' WHERE Licznik='SORYKS'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$zuzw_stor' WHERE Licznik='STOR'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$UMYWALKA_Budynek_1146_NAWA_VII' WHERE Licznik='UMYWALKA_Budynek_1146_NAWA_VII'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$BUDYNEK_1183_MAGAZYN_FARB' WHERE Licznik='BUDYNEK_1183_MAGAZYN FARB'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$BUDYNEK_1120_NOWY_BIUROWIEC' WHERE Licznik='BUDYNEK_1120_NOWY_BIUROWIEC'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$BUDYNEK_1121_WODA_CIEPLA' WHERE Licznik='BUDYNEK_1121_WODA_CIEPLA'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$BUDYNEK_1121_WODA_ZIMNA' WHERE Licznik='BUDYNEK_1121_WODA_ZIMNA'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$BUDYNEK_1171_WODA_ZIMNA_STAROSTWO' WHERE Licznik='BUDYNEK_1171_WODA_ZIMNA_STAROSTWO'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$WODA_CIEPLA_1171_ZASILANIE_STAROSTWO' WHERE Licznik='WODA_CIEPLA_1171_ZASILANIE_STAROSTWO'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$WODA_CIEPLA_1171_POWROT_STAROSTWO' WHERE Licznik='WODA_CIEPLA_1171_POWROT_STAROSTWO'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$star' WHERE Licznik='BUDYNEK_1171_WODA_CIEPLA_STAROSTWO'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$Karel' WHERE Licznik='Karel'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$PKP' WHERE Licznik='PKP'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$LESTER' WHERE Licznik='LESTER'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$POD_KOLEJARZ' WHERE Licznik='POD KOLEJARZ'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$MAR_PLAST' WHERE Licznik='MAR-PLAST'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$JAWO' WHERE Licznik='JAWO'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$PALSERWIS' WHERE Licznik='PALSERWIS'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$TRANSPROJECT' WHERE Licznik='TRANSPROJECT'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$MARTEX_OLSZYNKA' WHERE Licznik='MARTEX-OLSZYNKA'";
              mysqli_query($conn, $sql_woda);
              $sql_woda = "UPDATE Kontrola SET `$numer_miesiaca_woda` = '$RZEPKA' WHERE Licznik='RZEPKA'";
              mysqli_query($conn, $sql_woda);

              echo"zmieniono";

            }
            else {
              echo "Nie wprowadzono żadnych zmian.";
            }
          }
        ?>
      </div>

      <!-- ------------------------------GAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZGAZ GAZ-->

      <div id="formgaz">
        <form action="odczyt.php" method="post">
          <h1 style="text-align:center;">STAN LICZNIKÓW GAZ</h1>
          <table>
            <tr>
              <th colspan="3">
                <?php include "opcjegaz.php"?>
              </th>
            </tr>
            <tr id="lad">
              <th>LICZNIK</th>
              <th>KWOTA</th>
              <th>ZUŻYCIE(M³)</th>
            </tr>
            <?php
              if (isset($_POST['data_gaz'])) {
                $data_gaz = $_POST['data_gaz'];
                if ($data_gaz == 'Grudzień 2022') {
                  $numer_miesiaca_gaz = '1';
                } else {
                  $numer_miesiaca_gaz = substr($data_gaz, 5);
                }
                $sql_gaz = "SELECT * FROM stanlicznikowgaz";
                $result_gaz = mysqli_query($conn, $sql_gaz);
                if(mysqli_num_rows($result_gaz)>0)
                {
                  $suma_zuzycia_gaz = 0;
                  while ($row_gaz = mysqli_fetch_assoc($result_gaz)) { 
                    echo '<tr>';
                    echo '<td>' . $row_gaz['Licznik'] . '</td>';
                    echo '<td><input type="text" name="kwota_gaz[]" value="' . $row_gaz[$numer_miesiaca_gaz] . '"></td>';
                    $prev_month_gaz = $numer_miesiaca_gaz - 1;
                    if ($prev_month_gaz <= 0) {
                      echo '<td>0</td>';
                    } else {
                      $zuzycie_gaz = $row_gaz[$numer_miesiaca_gaz] - $row_gaz[$prev_month_gaz];
                      echo '<td>' . ($zuzycie_gaz > 0 ? $zuzycie_gaz : 0) . '</td>';
                      $suma_zuzycia_gaz += $zuzycie_gaz;
                    }
                    echo '<input type="hidden" name="licznik_gaz[]" value="' . $row_gaz['Licznik'] . '">';
                    echo '</tr>';
                  }
                  if($suma_zuzycia_gaz>0)
                  {
                  echo '<tr><td colspan="2">Suma:</td><td>' . $suma_zuzycia_gaz . '</td></tr>';
                  }
                  else {
                    echo '<tr><td colspan="2">Suma:</td><td>0</td></tr>';
                  }
                }
                else {
                  echo '<tr><td colspan="3">Brak danych dla wybranego miesiąca.</td></tr>';
                }
              }
            ?>
          </table>
          <button type="submit" class="chaged" name="submit_gaz" value="save_changes_gaz">Zapisz zmiany</button>
        </form>
        <?php
          if (isset($_POST['submit_gaz']) && $_POST['submit_gaz'] == 'save_changes_gaz') {
            if (isset($_POST['licznik_gaz']) && isset($_POST['kwota_gaz'])) {
              $liczniki_gaz = $_POST['licznik_gaz'];
              $kwoty_gaz = $_POST['kwota_gaz'];
              for ($i = 0; $i < count($liczniki_gaz); $i++) {
                $licznik_gaz = mysqli_real_escape_string($conn, $liczniki_gaz[$i]);
                $kwota_gaz = mysqli_real_escape_string($conn, $kwoty_gaz[$i]);
                $sql_gaz = "UPDATE stanlicznikowgaz SET `$numer_miesiaca_gaz` = '$kwota_gaz' WHERE Licznik = '$licznik_gaz'";
                mysqli_query($conn, $sql_gaz);
              }
              echo"zmieniono";
            }
            else {
              echo "Nie wprowadzono żadnych zmian.";
            }
          }
        ?>
      </div>

      <!-- ------------------------------ CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ  CIEPLOMIERZ -->

      <div id="formcp">
        <form action="odczyt.php" method="post">
          <h1 style="text-align:center;">CIEPŁOMIERZE</h1>
          <table>
            <tr>
              <th colspan="3">
                <?php include "opcjecp.php"?>
              </th>
            </tr>
            <tr id="lad">
              <th>LICZNIK</th>
              <th>KWOTA</th>
              <th>ZUŻYCIE(M³)</th>
            </tr>
            <?php
              if (isset($_POST['data_cp'])) {
                $data_cp = $_POST['data_cp'];
                if ($data_cp == 'Grudzień 2022') {
                  $numer_miesiaca_cp = '1';
                } else {
                  $numer_miesiaca_cp = substr($data_cp, 5);
                }
                $sql_cp = "SELECT * FROM cieplomierze";
                $result_cp = mysqli_query($conn, $sql_cp);
                if(mysqli_num_rows($result_cp)>0)
                {
                  $suma_zuzycia_cp = 0;
                  while ($row_cp = mysqli_fetch_assoc($result_cp)) { 
                    echo '<tr>';
                    echo '<td>' . $row_cp['Licznik'] . '</td>';
                    echo '<td><input type="text" name="kwota_cp[]" value="' . $row_cp[$numer_miesiaca_cp] . '"></td>';
                    $prev_month_cp = $numer_miesiaca_cp - 1;
                    if ($prev_month_cp <= 0) {
                      echo '<td>0</td>';
                    } else {
                      $prev_month_usage_cp = $row_cp[$prev_month_cp];
                      $current_month_usage_cp = $row_cp[$numer_miesiaca_cp];
                      $zuzycie_cp = $current_month_usage_cp - $prev_month_usage_cp;
                      echo '<td>' . ($zuzycie_cp > 0 ? $zuzycie_cp : 0) . '</td>';
                      $suma_zuzycia_cp += $zuzycie_cp;
                    }
                    echo '<input type="hidden" name="licznik_cp[]" value="' . $row_cp['Licznik'] . '">';
                    echo '</tr>';
                  }
                  if($suma_zuzycia_cp>0)
                  {
                    echo '<tr><td colspan="2">Suma:</td><td>' . $suma_zuzycia_cp . '</td></tr>';
                  }
                  else {
                    echo '<tr><td colspan="2">Suma:</td><td>0</td></tr>';
                  }
                }
                else {
                  echo '<tr><td colspan="3">Brak danych dla wybranego miesiąca.</td></tr>';
                }
              }
              
            ?>
          </table>
          <button type="submit" class="chaged" name="submit_cp" value="save_changes_cp">Zapisz zmiany</button>
        </form>
        <?php
          if (isset($_POST['submit_cp']) && $_POST['submit_cp'] == 'save_changes_cp') {
            if (isset($_POST['licznik_cp']) && isset($_POST['kwota_cp'])) {
              $liczniki_cp = $_POST['licznik_cp'];
              $kwoty_cp = $_POST['kwota_cp'];
              for ($i = 0; $i < count($liczniki_cp); $i++) {
                $licznik_cp = mysqli_real_escape_string($conn, $liczniki_cp[$i]);
                $kwota_cp = mysqli_real_escape_string($conn, $kwoty_cp[$i]);
                $sql_cp = "UPDATE cieplomierze SET `$numer_miesiaca_cp` = '$kwota_cp' WHERE Licznik = '$licznik_cp'";
                mysqli_query($conn, $sql_cp);
              }
              echo"zmieniono";
            }
            else {
              echo "Nie wprowadzono żadnych zmian.";
            }
          }
        ?>
      </div>
    </div>
    <script src="../all.js"></script>
    <script type="text/javascript">
      document.getElementById('data_woda').addEventListener('change_woda', function() {
        this.form.submit();
      });
      document.getElementById('data_gaz').addEventListener('change_gaz', function() {
        this.form.submit();
      });
      document.getElementById('data_cp').addEventListener('change_cp', function() {
        this.form.submit();
      });
    </script>
  </body>
</html>
