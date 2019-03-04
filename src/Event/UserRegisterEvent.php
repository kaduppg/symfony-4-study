<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 2/26/19
 * Time: 6:38 PM
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{


    const NAME = 'user.register';

    private $registeredUser;

    function __construct(User $registeredUser)
    {
        $this->registeredUser = $registeredUser;
    }

    /**
     * @return User
     */
    public function getRegisteredUser(): User
    {
        return $this->registeredUser;
    }


}