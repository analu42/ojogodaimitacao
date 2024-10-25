<?php
require 'vendor/autoload.php';
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

$client = new Client('AIzaSyBjz0aEEBoHjOdk0w64Z8o0FldRUpoerQA');
$response = $client->geminiPro()->generateContent(
    new TextPart('PHP in less than 100 chars'),
);

print $response->text();
// PHP: A server-side scripting language used to create dynamic web applications.
// Easy to learn, widely used, and open-source.


?>
