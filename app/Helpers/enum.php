<?php
/**
 * @Target  this file to make enum for all system
 * @note can call it in all system if give it key we return only we send
 */
/**
 * @Target this all type media in system
 */
function mediaType()
{
    return ['am' => 'avatar', 'fm' => 'file', 'dm' => 'document', 'lm' => 'logo', 'im' => 'image', 'dcm' => 'done'];
}

function activeType()
{
    return ['as' => 1, 'us' => 0];
}

/**
 * @Target this path type we can save in it
 */
function pathType()
{
    return ['ip' => 'images', 'up' => 'uploads'];
}

function modelPermission()
{
    return [
        'user',
        'role',
        'permission',
        'language',
        'category',
        'country',
        'city',
        'client',
        'adviser',
        'page',
        'social',
        'nationality',
        'home-slider',
        'status',
        'page',
        'payment',
        'label',
        'advice',
        'comment',
    ];
}

function statusNotificationText()
{
    return [
        'adviser' =>
            [
                'ar' =>
                    [
                        2 => 'يوجد نصيحه جديدة',
                        5 => 'تم قبول النصيحة من المنصوح',
                        7 => 'تم رفض النصيحة من المنصوح'
                    ]
            ],
        'client' =>
            [
                'ar' =>
                    [
                        3 => 'قام الناصح بقبول النصيحة',
                        4 => 'قام الناصح بتسليم النصيحة',
                        6 => 'قام الناصح برفض النصيحة',
                    ]
            ]
    ];
}