<?php
/**
 * Created by PhpStorm.
 * User: antonimassomola
 * Date: 05/11/2018
 * Time: 18:42
 */

namespace App\Controller;

use App\Entity\MicroPost;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/likes")
 */
class LikesController extends Controller
{

    /**
     * @Route("/like/{id}", name="likes_like")
     */
    public function like(MicroPost $microPost)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if($currentUser instanceof User) {
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->like($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $microPost->getLikedBy()->count()
        ], Response::HTTP_OK);
    }

    /**
     * @Route("/unlike/{id}", name="likes_unlike")
     */
    public function unlike(MicroPost $microPost)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if($currentUser instanceof User) {
            return new JsonResponse([], Response::HTTP_UNAUTHORIZED);
        }

        $microPost->getLikedBy()->removeElement($currentUser);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'count' => $microPost->getLikedBy()->count()
        ], Response::HTTP_OK);
    }

}