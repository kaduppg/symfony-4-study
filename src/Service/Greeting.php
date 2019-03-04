<?php

/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 11/28/18
 * Time: 9:38 PM
 */

namespace App\Service;

use Psr\Log\LoggerInterface;

class Greeting
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet($name){

        $this->logger->info("Greeted ".$name);

        return "Hello ". $name;

    }

}