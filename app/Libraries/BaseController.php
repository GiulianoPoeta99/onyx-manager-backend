<?php

namespace Libraries;

use CodeIgniter\RESTful\ResourceController;

use Helpers\RequestTrait;

class BaseController extends ResourceController
{
    use RequestTrait;

    protected $format = 'json';
}
