<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Handler;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * This file is an adapted version of FOS User Bundle ProfileFormHandler class.
 *
 *    (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 */
class ProfileFormHandler extends \Sonata\UserBundle\Form\Handler\ProfileFormHandler {

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function process(UserInterface $user) {
        $this->form->setData($user);

        if ('POST' == $this->request->getMethod()) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($user);

                return true;
            }

            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
            $this->userManager->reloadUser($user);
        }

        return false;
    }

    /**
     * @param UserInterface $user
     */
    protected function onSuccess(UserInterface $user) {
        $this->userManager->updateUser($user);
    }

}
