<?php
namespace RocketsLab\WALaravel\Concerns;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

trait HasMessage
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

    /**
     * @throws \RocketsLab\WALaravel\Exceptions\SessionNotDefined
     */
    protected function sendWAMessage($receiver, $message, $session = null): Response
    {
        $currentSession = $session ?? $this->session;

        $this->checkForSession($currentSession);

        //TODO: try catch and check response
        return Http::post("{$this->host}:{$this->port}/message/send?id={$currentSession}", [
            'receiver' => $receiver,
            'message' => $message
        ]);
    }
}
