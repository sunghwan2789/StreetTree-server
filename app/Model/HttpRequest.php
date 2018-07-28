<?php
namespace App\Model;

class HttpRequest
{
    public $method = '';
    public $headers = [];
    public $body = '';
    public $files = [];
}
