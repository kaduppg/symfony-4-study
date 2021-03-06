<?php
/**
 * Created by PhpStorm.
 * User: kaduppg
 * Date: 2/17/19
 * Time: 7:24 PM
 */

namespace App\Controller;


use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class LikesController
 * @Route("/likes")
 */
class LikesController extends Controller
{


    /**
     * @Route("/likes/{id}", name="likes_like")
     */
    public function like(MicroPost $microPost){

        $currentUser = $this->getUser();

        if(! $currentUser instanceof User){
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->like($currentUser);

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['count'=> $microPost->getLikedBy()->count()]);
    }


    /**
     * @Route("/unlike/{id}", name="likes_unlike")
     */
    public function unlike(MicroPost $microPost){
        $currentUser = $this->getUser();

        if(!$currentUser instanceof User){
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->getLikedBy()->removeElement($currentUser);

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['count'=> $microPost->getLikedBy()->count()]);
    }

}