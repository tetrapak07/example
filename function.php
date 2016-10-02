<?php

header('Content-Type: text/html; charset=utf-8');

$testsStringFromSms1 = "Пароль: 0308
Спишется 395,97р.
Перевод на счет 41001000000000";

$testsStringFromSms2 = "Код: 0308
Сумма 395,97р.
счет 41001000000000";

$testsStringFromSms3 = "
Перевод на счет 41001000000000    
Спишется 395,97р.
Пароль: 0308
";

$testsStringFromSms4 = "
Account: 4100100000000011    
Amount: 3950,97rub.
Pass: 03087
";


/**
 * Get Sms Data
 *
 * @param String $delimeter  New string delimeter
 * @param String $string Main string
 * @param String $patternReplace Regexp pattern for all string replace
 * @param String $patternMoney Regexp pattern for money amount
 * @param String $patternPassword Regexp pattern for password field
 * @param String $patternWallet Regexp pattern for wallet (account) field
 * 
 * @author Denis Lyubinovskiy <tetrapak07@gmail.com>
 * @return Array
 */ 

function getSmsData($delimeter, $string, 
                    $patternReplace = "/[^0-9,]/", 
                    $patternMoney = "/^[0-9]+(\,[0-9][0-9])$/", 
                    $patternPassword = "/^[a-z0-9_-]{4}$/", 
                    $patternWallet = "/^[0-9]{14}$/" ) {
    
    $result = explode($delimeter, $string);
    $res = [];
    
    foreach ($result as  $value) {
        
        /*cut non digit symbols*/
        $value = preg_replace($patternReplace, '', $value);

        if ((preg_match($patternWallet, $value))) {

            $res['wallet'] = $value;
        }

        if ((preg_match($patternPassword, $value))) {

            $res['password'] = $value;
        }

        if ((preg_match($patternMoney, $value))) {
            $res['amount'] = $value;
        }
    }

    return $res;
}

echo '<br>Тестовая строка №1: <b>"' . $testsStringFromSms1 . '"</b><br>';
echo 'Результат №1: '; print_r(getSmsData(PHP_EOL, $testsStringFromSms1));
echo '<br>';
echo '<br>Тестовая строка №2: <b>"' . $testsStringFromSms2 . '"</b><br>';
echo 'Результат №2: '; print_r(getSmsData(PHP_EOL, $testsStringFromSms2));
echo '<br>';
echo '<br>Тестовая строка №3: <b>"' . $testsStringFromSms3 . '"</b><br>';
echo 'Результат №3: '; print_r(getSmsData(PHP_EOL, $testsStringFromSms3));
echo '<br>';
echo '<br>Тестовая строка №4: <b>"' . $testsStringFromSms4 . '"</b><br>';
echo 'Результат №4: '; print_r(getSmsData(PHP_EOL, $testsStringFromSms4, $patternReplace = "/[^0-9,]/", 
        $patternMoney = "/^[0-9]+(\,[0-9][0-9])$/", $patternPassword = "/^[a-z0-9_-]{5}$/", 
        $patternWallet = "/^[0-9]{16}$/"));


