<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;

class BookController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig');
    }

    /**
     * @Route("/book/{book}", name="app_book_detail")
     *
     * @param Book $book
     */
    public function detail(Request $request, Book $book, EntityManagerInterface $manager): Response
    {
        $comment = new Comment($book);

        $commentForm = $this->createForm(CommentFormType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted()){
            $comment->setAuthor('Matthieu');

            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('app_book_detail', ['book' => $book->getId()]);
        }

        return $this->render('book/detail.html.twig', [
            'book' => $book,
            'comment_form' => $commentForm->createView()
        ]);
    }
}
