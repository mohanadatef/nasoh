<?php

namespace Modules\Setting\Service;

use Illuminate\Http\Request;
use Modules\Basic\Service\BasicService;
use Modules\Setting\Repositories\NotificationRepository;

class NotificationService extends BasicService
{
    protected $repo;

    /**
     * Create a new Repository instance.
     *
     * @return void
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repo = $repository;
    }

    public function findBy(Request $request, $pagination = false, $perPage = 10, $limit = null, $get = '',
        $moreConditionForFirstLevel = [])
    {
        return $this->repo->findBy($request, $pagination, $perPage, $limit, $get, $moreConditionForFirstLevel);
    }

    public function store(Request $request)
    {
        return $this->repo->save($request);
    }

    public function readNotification($id)
    {
        return $this->repo->readNotification($id);
    }

    public function sendNotificationChat($receiver = null, $message = null, $id)
    {
        if($receiver->is_notification)
        {
            $data = [
                "registration_ids" => $receiver->devices->pluck('device'),
                "notification" => [
                    'body' => $message,
                        ],
                'data' => [
                    "is_chat" => 1,
                    "advice_id" => $id,
                    ]
            ];
            return $this->sendNotification($data);
        }
        return true;
    }

    public function sendNotificationStatus($receiver = null, $message = null,$id)
    {
        if($receiver->is_notification)
        {
            $data = [
                "registration_ids" => $receiver->devices->pluck('device'),
                "notification" => [
                    'body' => $message,
                ],
                'data' => [
                    "is_chat" => 0,
                    "advice_id" => $id,
                ]
            ];
            return $this->sendNotification($data);
        }
        return true;
    }

    public function sendNotification($data)
    {
        $dataString = json_encode($data);
        $SERVER_API_KEY = getSetting('fcm_secret_key')->value ?? null;
        if(!$SERVER_API_KEY)
        {
            return false;
        }
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        curl_exec($ch);
        return true;
    }

    public function list(Request $request, $pagination, $perPage)
    {
        return $this->repo->list($request, $pagination, $perPage, ['column' => 'id', 'order' => 'desc']);
    }
}
