<?php
require_once 'Shorter.php';

$db = new SQLite3('data.db');

$db->exec('
CREATE TABLE IF NOT EXISTS arrow(
hash VARCHAR(20) NOT NULL PRIMARY KEY,
url VARCHAR(255) NOT NULL,
user_click INT(10) NOT NULL DEFAULT 0,
finished_at TIMESTAMP NOT NULL    
);
');

function add(String $link): mixed
{
    cleaner();
    $db = new SQLite3('data.db');
    $hash = Shorter::encode($link);
    $url = $link;
    try {
        $db->exec('INSERT INTO arrow (hash, url, finished_at) VALUES ("' . $hash . '", "' . $url . '", "' . (time() + (3600 * 24 * 7)) . '")');
        return $hash;
    } catch (Exception $e) {
        echo $e;
        return false;
    }
}


function cleaner()
{
    $db = new SQLite3('data.db');
    $db->query('DELETE FROM `arrow` WHERE finished_at < ' . time());
}