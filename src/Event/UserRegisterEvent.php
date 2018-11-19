<?php
/**
 * Created by PhpStorm.
 * User: antonimassomola
 * Date: 08/11/2018
 * Time: 15:17
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\Event;
use App\Entity\User;

class UserRegisterEvent extends  Event
{

    const NAME = 'user.register';

    /**
     * @var User
     */
    private $registeredUser;

    public function __construct(User $registeredUser)
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