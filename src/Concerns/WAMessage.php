<?php
namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Support\Facades\Http;

trait WAMessage
{
    public function sendText($receiver, $message, string $session = null) {
        $textMessageTemplate = [
            'text' => $message
        ];

        return $this->sendWAMessage($receiver, $textMessageTemplate, $session);
    }

    public function sendContact($receiver, array $contacts, string $session = null)
    {
        $contactsMessageTemplate = [
            'contacts' => $contacts
        ];

        return $this->sendWAMessage($receiver, $contactsMessageTemplate, $session);
    }

    public function sendImage($receiver, $url, $caption = null, string $session = null) {

        $imageMessageTemplate = [
            'image' => [
                'url' => $url
            ]
        ];

        if($caption) {
            $imageMessageTemplate['caption'] = $caption;
        }

        return $this->sendWAMessage($receiver, $imageMessageTemplate, $session);
    }

    protected function sendWAMessage($receiver, $message, $session = null)
    {
        $currentSession = $session ?? $this->session;

        //TODO: try catch and check response
        return Http::post("{$this->host}:{$this->port}/message/send?id={$currentSession}", [
            'receiver' => $receiver,
            'message' => $message
        ]);
    }
}
