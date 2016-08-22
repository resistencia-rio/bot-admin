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
            $json = '{"update_id":2058587,"message":{"message_id":3785,"from":{"id":147949488,"first_name":"Jos\u00e9","last_name":"das Couves","username":"vitorphp"},"chat":{"id":147949488,"first_name":"Jos\u00e9","last_name":"das Couves","username":"vitorphp","type":"private"},"date":1463402259,"reply_to_message":{"message_id":3784,"from":{"id":180956067,"first_name":"feedbackbot","username":"Feedbackcoolbot"},"chat":{"id":147949488,"first_name":"Jos\u00e9","last_name":"das Couves","username":"vitorphp","type":"private"},"date":1463402235,"text":"\u2764\ufe0f Fa\u00e7a um coment\u00e1rio e reconhe\u00e7a o esfor\u00e7o do seu colega: \/profile_37900977","entities":[{"type":"bot_command","offset":59,"length":17}]},"text":"Identificado"}}';
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
