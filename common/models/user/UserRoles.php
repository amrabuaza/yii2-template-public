<?php

namespace common\models\user;

abstract class UserRoles
{
    // root rules
    const ROOT_RULES = [

    ];

    const ADMIN_ROLES = [
        [
            'allow' => true,
            'actions' => ['index'],
            'roles' => ['viewEntities'],
        ],
        [
            'allow' => true,
            'actions' => ['view'],
            'roles' => ['viewEntities'],
        ],
        [
            'allow' => true,
            'actions' => ['update'],
            'roles' => ['updateEntities'],
        ],
        [
            'allow' => true,
            'actions' => ['delete'],
            'roles' => ['deleteEntities'],
        ],
        [
            'allow' => true,
            'actions' => ['create'],
            'roles' => ['createEntities'],
        ],
        [
            'allow' => true,
            'actions' => ['update-translations'],
            'roles' => ['updateEntities'],
        ],
    ];

}