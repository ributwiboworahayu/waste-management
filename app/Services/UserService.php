<?php

namespace App\Services;

use LaravelEasyRepository\Service;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService extends Service {

     /**
     * don't change $this->mainInterface variable name
     * because used in extends service class
     */
     protected $mainInterface;

    public function __construct(UserRepositoryInterface $mainInterface)
    {
      $this->mainInterface = $mainInterface;
    }

    // Define your custom methods :)
}
