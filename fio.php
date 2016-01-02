<?php

/*
 * FIO invoices - API
 * Automatizace zaplacenych faktur 
 * Author <smetka.net>
*/

$ip        = "IP ADRESS SERVER";
$fio_token = "FIO TOKEN API";


if ($_SERVER["REMOTE_ADDR"] === $ip) {
    
    $xml   = simplexml_load_file("https://www.fio.cz/ib_api/rest/periods/{$fio_token}/" . date("Y-m-d", strtotime("-2 month")) . "/" . date("Y-m-d") . "/transactions.xml");
    $items = $xml->TransactionList->Transaction;
    
    foreach ($items as $key => $value) {
        
        $final_price = $value->column_1;
        $vs          = $value->column_5;
        
        $update = DB::query_row("SELECT vs, final_price, confirm FROM table WHERE confirm='0' AND vs='{$vs}' AND final_price='{$final_price}'");
        
        if ($update) {
            // E.g. sending a notification email     	
        }
    }
}
