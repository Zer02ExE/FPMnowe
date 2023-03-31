<?php
    $miesiace_gaz = array(
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

    $wybrana_data_gaz = isset($_POST['data_gaz']) ? $_POST['data_gaz'] : '';
    echo '<label for="data_gaz">Wybierz rok i miesiąc:</label>';
    echo '<form method="POST" action="">';
    echo '<select name="data_gaz" id="data_gaz" required onchange="submitForm()">';

    foreach ($miesiace_gaz as $nazwa_miesiaca_gaz => $numer_miesiaca_gaz) {
        if ($numer_miesiaca_gaz >= 2 && $numer_miesiaca_gaz <= 13) {
            $rok_gaz = ($numer_miesiaca_gaz == 13) ? 2024 : 2023;
            $value_gaz = $rok_gaz . '-' . $numer_miesiaca_gaz;
            $selected_gaz = ($wybrana_data_gaz == $value_gaz) ? 'selected' : '';
            echo '<option value="' . $value_gaz . '" ' . $selected_gaz . ' id="' . $numer_miesiaca_gaz . '">' . $nazwa_miesiaca_gaz . '</option>';
        } else {
            $rok_gaz = ($numer_miesiaca_gaz == 1 || $numer_miesiaca_gaz == 13) ? ($numer_miesiaca_gaz == 13 ? 2024 : 2022) : 2023;
            if ($nazwa_miesiaca_gaz == 'Grudzień 2022') {
                $numer_miesiaca_gaz = '1';
            } else {
                $numer_miesiaca_gaz = str_pad($numer_miesiaca_gaz, 2, "0", STR_PAD_LEFT);
            }
            $value_gaz = $rok_gaz . '-' . $numer_miesiaca_gaz;
            $selected_gaz = ($wybrana_data_gaz == $value_gaz) ? 'selected' : '';
            echo '<option value="' . $value_gaz . '" ' . $selected_gaz . ' id="' . $numer_miesiaca_gaz . '">' . $nazwa_miesiaca_gaz . '</option>';
        }
    }
    
    echo '</select>';
    echo '<br><br><button class="serch" type="submit">Wyszukaj</button>';
    echo '</form>'; 
?>


<script type="text/javascript">
    function submitForm() {
        document.querySelector('#form_gaz').submit();
    }

    document.querySelector('#data_gaz').addEventListener('change_gaz', function() {
        submitForm();
    });
</script>