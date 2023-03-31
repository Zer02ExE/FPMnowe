<?php
    $miesiace_woda = array(
        'Grudzień 2022' => '1',
        'Styczeń 2023' => '2',
        'Luty 2023' => '3',
        'Marzec 2023' => '4',
        'Kwiecień 2023' => '5',
        'Maj 2023' => '6',
        'Czerwiec 2023' => '7',
        'Lipiec 2023' => '8',
        'Sierpień 2023' => '9',
        'Wrzesień 2023' => '10',
        'Październik 2023' => '11',
        'Listopad 2023' => '12',
        'Grudzień 2023' => '13'
    );

    $wybrana_data_woda = isset($_POST['data_woda']) ? $_POST['data_woda'] : '';
    echo '<label for="data_woda">Wybierz rok i miesiąc:</label>';
    echo '<form method="POST" action="">';
    echo '<select name="data_woda" id="data_woda" required onchange="submitForm()">';

    foreach ($miesiace_woda as $nazwa_miesiaca_woda => $numer_miesiaca_woda) {
        if ($numer_miesiaca_woda >= 2 && $numer_miesiaca_woda <= 13) {
            $rok_woda = ($numer_miesiaca_woda == 13) ? 2024 : 2023;
            $value_woda = $rok_woda . '-' . $numer_miesiaca_woda;
            $selected_woda = ($wybrana_data_woda == $value_woda) ? 'selected' : '';
            echo '<option value="' . $value_woda . '" ' . $selected_woda . ' id="' . $numer_miesiaca_woda . '">' . $nazwa_miesiaca_woda . '</option>';
        } else {
            $rok_woda = ($numer_miesiaca_woda == 1 || $numer_miesiaca_woda == 13) ? ($numer_miesiaca_woda == 13 ? 2024 : 2022) : 2023;
            if ($nazwa_miesiaca_woda == 'Grudzień 2022') {
                $numer_miesiaca_woda = '1';
            } else {
                $numer_miesiaca_woda = str_pad($numer_miesiaca_woda, 2, "0", STR_PAD_LEFT);
            }
            $value_woda = $rok_woda . '-' . $numer_miesiaca_woda;
            $selected_woda = ($wybrana_data_woda == $value_woda) ? 'selected' : '';
            echo '<option value="' . $value_woda . '" ' . $selected_woda . ' id="' . $numer_miesiaca_woda . '">' . $nazwa_miesiaca_woda . '</option>';
        }
    }
    
    echo '</select>';
    echo '<br><br><button class="serch" type="submit">Wyszukaj</button>';
    echo '</form>'; 
?>


<script type="text/javascript">
    function submitForm() {
        document.querySelector('#form_woda').submit();
    }

    document.querySelector('#data_woda').addEventListener('change_woda', function() {
        submitForm();
    });
</script>