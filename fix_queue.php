<?php

$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);

// Forzar QUEUE_CONNECTION a sync
if (preg_match("/^QUEUE_CONNECTION=.*/m", $content)) {
    $content = preg_replace("/^QUEUE_CONNECTION=.*/m", "QUEUE_CONNECTION=sync", $content);
} else {
    $content .= "\nQUEUE_CONNECTION=sync";
}

file_put_contents($envFile, $content);
echo "QUEUE_CONNECTION actualizado a sync.\n";
