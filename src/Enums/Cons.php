<?php

namespace Mzm\PhpSso\Enums;

enum Cons: string
{
    case SSO_TOKEN = 'sso_token';
    case SSO_ORIGIN = 'sso_origin';    
    case SSO_BASE_URL = 'sso_base_url';
    case SSO_HOME = 'sso_home';
    case SSO_USER_FINDER = '';
    case CONN_HOST = 'host';
    case CONN_DB = 'db';
    case CONN_USER = 'username';
    case CONN_PASS = 'password';
    case SESSION_USER = 'user';
    case SESSION_SSO_USER = 'sso_user';
    case COOKIES_TOKEN = 'access_token';
    case LOG_DIR =  '/../../../logs';
}
