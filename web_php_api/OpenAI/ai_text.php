<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require("../../scripts/php/functions.php");

use \Orhanerday\OpenAi\OpenAi;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../.."); // Update the path to include the correct directory
$dotenv->load();

// Having an issue loading in env variables, so I'm hardcoding the key for now
$open_ai_key = getenv('OPEN_AI_KEY');
empty($open_ai_key) ? $open_ai_key = "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" : $open_ai_key;

$open_ai = new OpenAi($open_ai_key);

$postData = json_decode(file_get_contents('php://input'), true);

// die(var_dump($postData)); // debug

if (!isset($postData['prompt'])) {
    if (!isset($_GET['prompt'])) die("Prompt not received");

    $prompt = sanitizeString($_GET['prompt']); // die("Prompt not received");
} else {
    $prompt = sanitizeString($postData['prompt']); // sanitizeString($_POST['prompt']);
}

$ai_response = $open_ai->completion([
    'model' => 'gpt-3.5-turbo-instruct'/* text-davinci-003 */,
    'prompt' => $prompt,
    'max_tokens' => 1000,
    'temperature' => 0.9,
    'top_p' => 1,
    'frequency_penalty' => 0.0,
    'presence_penalty' => 0.6,
    'stop' => ['\n', "Human:", "AI:"]
]);

// var_dump($ai_response); // debug

$ai_response = json_decode($ai_response);
$ai_response = $ai_response->choices[0]->text;

echo $ai_response;
