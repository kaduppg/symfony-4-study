<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 3/3/19
 * Time: 7:40 PM
 */

namespace App\tests\Security;


use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{

    public function testTokenGeneration(){

        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getRandomSecureToken(30);
        $this->assertEquals(30, strlen($token));
        $this->assertTrue(ctype_alnum($token),'Token contains incorrect characters');
    }
}