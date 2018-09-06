<?php

namespace AppBundle\Controller\Login;

use AppBundle\Exception\AccountDisabledException;
use AppBundle\Exception\NotExistsException;
use AppBundle\Form\Login\LoginType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;

class EmailLoginController extends BaseLoginController
{
    public function loginAction(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectAfterLogin($this->getUser());
        }

        $form = $this->createForm(LoginType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->renderForm($form);
        }

        try {
            $user = $this->findUser($form->get('email')->getData(), $form->get('password')->getData());
        } catch (NotExistsException $e) {
            $message = $this->get('translator')->trans('login.error.invalidCredentials');
            return $this->renderForm($form, $message);
        } catch (AccountDisabledException $e) {
            $message = $this->get('translator')->trans('login.error.accountDisabled');
            return $this->renderForm($form, $message);
        }

        $this->doLogin($user);

        return $this->redirectAfterLogin($user);
    }

    private function renderForm(Form $form, $message = null)
    {
        if (null !== $message) {
            $form->addError(new FormError($message));
        }

        return $this->render('@App/login/login.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function findUser($email, $password)
    {
        $repository = $this->get('jiranizer.repository.user');
        $user       = $repository->findOneByEmail($email);

        $factory    = $this->get('security.encoder_factory');
        $encoder    = $factory->getEncoder($user);

        if (!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            throw new NotExistsException('Invalid username/password.');
        }

        if (!$user->isEnabled()) {
            throw new AccountDisabledException('Your account is disabled.');
        }

        return $user;
    }
}
