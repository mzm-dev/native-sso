<?php

namespace Mzm\PhpSso\Enums;

enum Config: string
{    
    case SSO_TOKEN = '684462e2-c8c1-4dc2-a82b-a6c233ea8ba6';
    case SSO_ORIGIN = 'https://egerak.ns.test';
    case SSO_BASE_URL = 'https://sso.ns.test';
    case SSO_HOME = '/sso/home';
    case SSO_USER_FINDER = '';
    case CONN_HOST = 'localhost';
    case CONN_DB = 'gerakan_sukns_db';
    case CONN_USER = 'root';
    case CONN_PASS = 'password';
}
