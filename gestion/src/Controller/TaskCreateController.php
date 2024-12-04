<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class TaskCreateController extends AbstractController
{
    /**
     * @Route("/task/create", name="task_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();

        // Formulaire pour la tâche
        $form = $this->createFormBuilder($task)
            ->add('title')
            ->add('description')
            ->add('status')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
