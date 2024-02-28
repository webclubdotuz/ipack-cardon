<?php

namespace App\Services;

class TelegramService
{
    public static function send($chat_id, $message)
    {
        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));
        $my_chat_id = "-1001917025227";

        try {
            $telegram->sendMessage([
                'chat_id' => $chat_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            $telegram->sendMessage([
                'chat_id' => $my_chat_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $telegram->sendMessage([
                'chat_id' => $my_chat_id,
                'text' => "Error: " . $th->getMessage() . " " . $th->getLine(),
                'parse_mode' => 'HTML',
            ]);
        }

    }

    public static function sendChannel($message)
    {
        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));
        $my_chat_id = env('MY_TG_CHANNEL_ID');

        try {
            $telegram->sendMessage([
                'chat_id' => $my_chat_id,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $telegram->sendMessage([
                'chat_id' => $my_chat_id,
                'text' => "Error: " . $th->getMessage() . " " . $th->getLine(),
                'parse_mode' => 'HTML',
            ]);
        }

    }
}
