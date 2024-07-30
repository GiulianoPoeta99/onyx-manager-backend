<?php

namespace Libraries;

use CodeIgniter\RESTful\ResourceController;

use Libraries\RequestTrait;

class BaseController extends ResourceController
{
    use RequestTrait;

    protected $format = 'json';
}
