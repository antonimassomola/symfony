<?php
/**
 * Created by PhpStorm.
 * User: antonimassomola
 * Date: 29/10/2018
 * Time: 18:26
 */

namespace App\Controller;


use App\Entity\User;
use App\Event\UserRegisterEvent;
use App\Form\UserType;

use App\Security\TokenGenerator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(
        UserPasswordEncoderInterface $passwordEncoder,
        Request $request,
        EventDispatcherInterface $eventDispatcher,
        TokenGenerator $tokenGenerator
    )
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);
            $user->setConfirmationToken($tokenGenerator->getRandomSecureToken(30));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $userRegistrationEvent = new UserRegisterEvent($user);
            $eventDispatcher->dispatch(UserRegisterEvent::NAME, $userRegistrationEvent);

            $this->redirectToRoute('micro_post_index');
        }

        return $this->render('register/register.html.twig', [
           'form' => $form->createView()
        ]);
    }
}