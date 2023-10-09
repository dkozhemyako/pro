<?php

namespace App\Services\TelegramBot;

use Illuminate\Support\Carbon;

class InboundDTO
{
    protected string $message;
    protected Carbon $date;
    protected int $senderId;

    public function __construct(array $data)
    {
        $this->message = $data['message']['text'];
        $this->date = Carbon::createFromTimestamp($data['message']['date']);
        $this->senderId = $data['message']['from']['id'];
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->senderId;
    }

}
/*
 * example inbound data json from telegram
{
    "update_id": 20629194,
  "message": {
    "message_id": 11,
    "from": {
        "id": 912016646,
      "is_bot": false,
      "first_name": "Dima",
      "last_name": "Kozhemyako",
      "language_code": "uk"
    },
    "chat": {
        "id": 912016646,
      "first_name": "Dima",
      "last_name": "Kozhemyako",
      "type": "private"
    },
    "date": 1696342523,
    "text": "test"
  }
}
*/
