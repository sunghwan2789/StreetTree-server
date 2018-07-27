<?php
namespace App\Http\Actions;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class IndexAction
{
    public function __invoke()
    {
        \phpinfo();
    }
}
