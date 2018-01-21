<?php
/**
 * Name: abedi
 * Copyright © 2017
 */

define('BOT_TOKEN', '515797076:AAGsq-edcUClMMnWgZQu5pY9ONMNWdjwGJg');
include("fk-libs/telegram-bot-api/alpha-1.0.0.php");

if (isset($update["message"]))
    onMessage($update["message"]);

function onMessage($message)
{
    try {
        $answer = "";
        if (isset($message["text"])) {
            $text = $message["text"];
            if ($text == "/start") {
                $answer = "-> If you send me any message without forwarding, Will receive your chat ID
\n-> If you forward any message, Will receive forwarded user ID
\n-> If forwarded message is from channel, Will receive channel ID
\n-> If message type is shared contact, Will receive contact user ID
\n-> For get group ID, First add bot to group, then send /get command in group
NOTICE: When a group upgraded to supegroup, chat id will change!!!!!
\nSource code: f.com/source-code-telegram-showchatidbot
http://f.com";
            } else if ($text == "/get" && $message["chat"]["type"] != "private") {
                $answer = "Yeah, Group Chat ID is " . $message["chat"]["id"];
            }
        }
        if ($answer == "" && $message["chat"]["type"] == "private") {
            if (isset($message["contact"]))
                $answer .= "-> Shared Contact ID = " . $message["contact"]["user_id"] . "\n";
            if (isset($message["forward_from"]))
                $answer .= "-> Forwarded User ID = " . $message["forward_from"]["id"] . "\n";
            if (isset($message["forward_from_chat"]))
                $answer .= "-> Forwarded Chat ID = " . $message["forward_from_chat"]["id"] . ", It's " . $message["forward_from_chat"]["type"] . "\n";

            $answer .= "-> Your ID = " . $message["chat"]["id"];
        }
        if ($answer != "") {
            sendMessage(array(
                'chat_id' => $message["chat"]["id"],
                'text' => "<pre>" . $answer . "</pre>",
                'parse_mode' => "HTML"
            ));
        }
    } catch (Exception $e) {
    }
}