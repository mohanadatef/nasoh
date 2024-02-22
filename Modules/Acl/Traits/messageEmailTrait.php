<?php

namespace Modules\Acl\Traits;


use function getCustomTranslation;

trait messageEmailTrait
{
    public function verify($data)
    {
        return ['title' => getCustomTranslation('verify_title'), 'body' => getCustomTranslation('verify_body'),'link'=>'asdsadsd?'.$data->id];
    }

    public function approveMessage($key,$data=null)
    {
        if ($key == 'accept') {
            $mail = ['title' => getCustomTranslation('accept_approve_title'), 'body' => getCustomTranslation('accept_approve_body'),
                'link' => 'sdfsdf', 'key' => $key, 'link_title' => getCustomTranslation('login_here')];
        } elseif ($key == 'reject') {
            $mail = ['title' => getCustomTranslation('reject_approve_title'), 'body' => getCustomTranslation('reject_approve_body') . $data,
                'link' => 'sdfsdf', 'key' => $key, 'link_title' => getCustomTranslation('register_here')];
        } elseif ($key == 'wait') {
            $mail = ['title' => getCustomTranslation('wait_approve_title'), 'body' => getCustomTranslation('wait_approve_body'), 'key' => $key];
        }
        return $mail;
    }
}
