<?php

namespace App\Controller;

use App\{
    Entity\User, Service\UserService
};
use Symfony\{
    Bundle\FrameworkBundle\Controller\Controller,
    Component\Form\Extension\Core\Type\PasswordType,
    Component\Form\Extension\Core\Type\SubmitType,
    Component\Form\Extension\Core\Type\TextType,
    Component\HttpFoundation\Request,
    Component\HttpFoundation\Session\SessionInterface
};

/**
 * Class UserController
 *
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @param SessionInterface $session
     * @param UserService $userService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session, UserService $userService)
    {
        if (!$session->get('auth')) {
            return $this->redirectToRoute('auth');
        } else {
            return $this->render('user/userinfo.html.twig', [
                'username' => $userService->getUser()->getUsername()
            ]);
        }
    }

    /**
     * @param SessionInterface $session
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout(SessionInterface $session)
    {
        $session->clear();
        return $this->redirectToRoute('auth');
    }

    /**
     * @param Request $request
     * @param SessionInterface $session
     * @param UserService $userService
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function auth(Request $request, SessionInterface $session, UserService $userService)
    {
        $user = new User($this->container);

        $form = $this->createFormBuilder($user)
                ->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('auth', SubmitType::class, ['label' => 'Sign In'])
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userService->isLoad()) {
                $session->set('auth', $userService->getUserHash());

                return $this->redirectToRoute('index');
            }
        }

        return $this->render('user/auth.html.twig', [
            'auth_form' => $form->createView()
        ]);
    }

}
