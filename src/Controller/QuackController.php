<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\CommentType;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/quack')]
class QuackController extends AbstractController
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    #[Route('/landing', name: 'app_quack_landing', methods: ['GET'])]
    public function landing(QuackRepository $quackRepository): Response
    {
        return $this->render('quack/landing.html.twig', [
        ]);
    }

    #[Route('/index', name: 'app_quack_index', methods: ['GET'])]
    public function index(QuackRepository $quackRepository): Response
    {
        $quacks = $quackRepository->findOriginalQuacks();

        return $this->render('quack/index.html.twig', [
            'quacks' => $quacks,
        ]);
    }

    #[Route('/personalIndex', name: 'app_quack_personalIndex', methods: ['GET'])]
    public function personalIndex(QuackRepository $quackRepository): Response
    {
        $user = $this->getUser();
        return $this->render('quack/personalIndex.html.twig', [
            'quacks' => $quackRepository->findByUser($user),
        ]);
    }

    #[Route('/new', name: 'app_quack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $quack = new Quack();
        $user = $this->getUser();
        $quack->setUser($user);
        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('quack_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $quack->setImageName($newFilename);
            }

            $tags = $form->get('tag')->getData();
            $quack->setTag($tags);

            $entityManager->persist($quack);
            $entityManager->flush();

            return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quack/new.html.twig', [
            'quack' => $quack,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quack_show', methods: ['GET'])]
    public function show(Quack $quack): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('quack/show.html.twig', [
            'quack' => $quack,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quack_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quack $quack, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $id = $quack->getId();
        if ($this->getUser() === $quack->getUser()) {
            $form = $this->createForm(QuackType::class, $quack);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $imageFile */
                $imageFile = $form->get('imageFile')->getData();

                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $this->slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                    try {
                        $imageFile->move(
                            $this->getParameter('quack_images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $quack->setImageName($newFilename);
                }

                $tags = $form->get('tag')->getData();
                $quack->setTag($tags);

                $entityManager->flush();

//                return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);

                return $this->redirectToRoute('app_quack_show', ['id' => $id], Response::HTTP_SEE_OTHER);

            }

            return $this->render('quack/edit.html.twig', [
                'quack' => $quack,
                'form' => $form,
            ]);
        }
        return $this->redirectToRoute('app_quack_index');

    }

    #[Route('/{id}', name: 'app_quack_delete', methods: ['POST'])]
    public function delete(Request $request, Quack $quack, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($this->isCsrfTokenValid('delete' . $quack->getId(), $request->request->get('_token'))) {
            $entityManager->remove($quack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/new_comment/{id}', name: 'app_quack_newCommentModal', methods: ['GET', 'POST'])]
    public function addComment(Request $request, EntityManagerInterface $entityManager, Quack $originalQuack): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $comment = new Quack();
//        $comment->setContent("Nice");
        $comment->setUser($this->getUser());

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('quack_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    $this->addFlash('danger', 'File upload error: ' . $e->getMessage());
                    return $this->redirectToRoute('app_quack_newCommentModal', ['id' => $originalQuack->getId()]);
                }

                $comment->setImageName($newFilename);
            }

            $tags = $form->get('tag')->getData();
            $comment->setTag($tags);

        $comment->setQuackComment($originalQuack);

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_quack_index', [], Response::HTTP_SEE_OTHER);
    }
        return $this->render('quack/newCommentModal.html.twig', [
            'quack' => $comment,
            'form' => $form,
        ]);

}
}

