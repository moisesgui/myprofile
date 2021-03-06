<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\CurriculumService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * User controller.
 *
 * @Route("admin/user")
 */
class UserController extends AbstractController
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_user_index", methods={"GET"})
     */
    public function indexAction(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_user_show", methods={"GET"})
     */
    public function showAction(User $user)
    {

        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/{username}/make_pdf", name="admin_user_make_pdf")
     */
    public function makePdfAction(User $user, CurriculumService $curriculumService)
    {
        $curriculumService->makePdfOnTransloadit($user);

        $this->addFlash('success', 'pdf generated with success!');
        return $this->redirectToRoute('admin_user_index');
    }
}
