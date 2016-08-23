<?php
use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Core\FeedBack;
use Core\FeedBackUser;
use Telegram\Bot\Helpers\Emojify;
use FeedbackPagerfanta\Adapter\FeedbackAdapter;
use Pagerfanta\Pagerfanta;
require_once 'vendor/autoload.php';
require_once 'config.php';

if(getenv('MODE_ENV') == 'develop') {
    class mockApi extends Api{
        public function getWebhookUpdates($emitUpdateWasReceivedEvent = true) {
            $json = '{}';
            return new Update(json_decode($json, true));
        }
    }
    $telegram = new mockApi($config['token']);
} else {
    error_log(file_get_contents('php://input'));
    $telegram = new Api($config['token']);
}

$update = $telegram->getWebhookUpdates();

// Inline Keyboard
if($update->has('message')) {
    $message = $update->getMessage();
    if($message->has('text')) {
        switch($text = $message->getText()) {
            case '/manual':
            case '/manuel':
                $telegram->sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' =>
                        "Manual em texto:  http://bit.ly/rspmnlv2\n\nManual em video: https://youtu.be/hSxBkKeO7-Y",
                    'parse_mode' => 'HTML'
                ]);
        }
    }
}

