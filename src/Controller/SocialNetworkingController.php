<?php

namespace App\Controller;

use App\Entity\SocialNetworking;
use App\Repository\SocialNetworkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Socialnetworking controller.
 *
 * @Route("admin/socialnetworking")
 */
class SocialNetworkingController extends AbstractController
{
    /**
     * Lists all socialNetworking entities.
     *
     * @Route("/", name="admin_socialnetworking_index", methods={"GET"})
     */
    public function indexAction(SocialNetworkingRepository $socialNetworkingRepository)
    {
        $socialNetworkings = $socialNetworkingRepository->findAll();

        return $this->render('socialnetworking/index.html.twig', array(
            'socialNetworkings' => $socialNetworkings,
        ));
    }

    /**
     * Creates a new socialNetworking entity.
     *
     * @Route("/new", name="admin_socialnetworking_new", methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $socialNetworking = new Socialnetworking();
        $form = $this->createForm('App\Form\SocialNetworkingType', $socialNetworking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($socialNetworking);
            $em->flush();

            return $this->redirectToRoute('admin_socialnetworking_show', array('id' => $socialNetworking->getId()));
        }

        return $this->render('socialnetworking/new.html.twig', array(
            'socialNetworking' => $socialNetworking,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a socialNetworking entity.
     *
     * @Route("/{id}", name="admin_socialnetworking_show", methods={"GET"})
     */
    public function showAction(SocialNetworking $socialNetworking)
    {
        $deleteForm = $this->createDeleteForm($socialNetworking);

        return $this->render('socialnetworking/show.html.twig', array(
            'socialNetworking' => $socialNetworking,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing socialNetworking entity.
     *
     * @Route("/{id}/edit", name="admin_socialnetworking_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request, SocialNetworking $socialNetworking)
    {
        $deleteForm = $this->createDeleteForm($socialNetworking);
        $editForm = $this->createForm('App\Form\SocialNetworkingType', $socialNetworking);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_socialnetworking_edit', array('id' => $socialNetworking->getId()));
        }

        return $this->render('socialnetworking/edit.html.twig', array(
            'socialNetworking' => $socialNetworking,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a socialNetworking entity.
     *
     * @Route("/{id}", name="admin_socialnetworking_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, SocialNetworking $socialNetworking)
    {
        $form = $this->createDeleteForm($socialNetworking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($socialNetworking);
            $em->flush();
        }

        return $this->redirectToRoute('admin_socialnetworking_index');
    }

    /**
     * Creates a form to delete a socialNetworking entity.
     *
     * @param SocialNetworking $socialNetworking The socialNetworking entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SocialNetworking $socialNetworking)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_socialnetworking_delete', array('id' => $socialNetworking->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
