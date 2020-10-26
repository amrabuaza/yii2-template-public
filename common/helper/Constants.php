<?php

namespace common\helper;

abstract class Constants
{
    // language
    const LANGUAGES = 'languages';
    const LANGUAGE = 'language';
    const USER_LANGUAGE_KEY = 'user-language';
    const DEFAULT_LANGUAGE = 'en';
    const ARABIC_LANGUAGE = 'ar';
    // ids
    const ID = "id";
    const USER_ID = 'user_id';
    // others
    const APP = 'app';
    const MODEL = 'model';

    const USER_DEFAULT = '/images/user-profile-default.png';
    const ACTIVE = 'active';

    const NO = "no";

    //validation
    const VALIDATION_REQUIRED = "validation.required";
    const VALIDATION_ATTRIBUTE = ["attribute"=>"{attribute}"];
}