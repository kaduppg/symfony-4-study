<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 1/21/19
 * Time: 1:30 PM
 */

namespace App\Controller;


use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FollowingController
 * @Security("is_granted('ROLE_USER')")
 * @Route("/following")
 */
class FollowingController extends Controller
{

    /**
     * @Route("/follow/{id}", name="following_follow")
     */
    public function follow(User $userToFollow){
        /**@var User $currentUser*/
        $currentUser = $this->getUser();

        if($currentUser->getId() != $userToFollow->getId()){

            $currentUser->getFollowing()->add($userToFollow);

            //this is just because symfony sort out everything behind the scene using the persist tho, so u dont need to persist
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute(
            'micro_post_user',
            ['username'=>$userToFollow->getUsername()]
        );


    }

    /**
     * @Route("/unfollow/{id}", name="following_unfollow")
     */
    public function unfollow( User $userToUnfollow){
        /**@var User $currentUser*/
        $currentUser = $this->getUser();

        $currentUser->getFollowing()->removeElement($userToUnfollow);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute(
            'micro_post_user',
            ['username'=>$userToUnfollow->getUsername()]
        );

    }

}