<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require("../../scripts/php/functions.php");

use \Orhanerday\OpenAi\OpenAi;

$open_ai_key = "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"; // getenv('OPEN_AI_KEY');
$open_ai = new OpenAi($open_ai_key);

$prompt = sanitizeString($_POST['prompt']);

$ai_response = $open_ai->image([
    'prompt' => $prompt,
    'n' => 1,
    'size' => "256x256",
    'response_format' => 'url' /*image*/,
]);

// var_dump($ai_response); // debug

$ai_response = json_decode($ai_response);
$ai_response = $ai_response->data[0]->url;

echo $ai_response;
