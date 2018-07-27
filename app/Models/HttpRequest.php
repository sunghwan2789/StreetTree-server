<?php
namespace App\Models;

class HttpRequest
{
    public $method = '';
    public $headers = [];
    public $body = '';
    public $files = [];
}
