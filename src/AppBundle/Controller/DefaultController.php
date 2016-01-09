<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Jkan\BookReader\Application\BookService;
use Jkan\BookReader\Infrastructure\InMemoryBookShelf;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    public function myNameAction(Request $request)
    {

        return new Response('it Works');
    }

    public function readBookAction(Request $request)
    {
        
        $bookShelf = new InMemoryBookShelf();
        $bookService = new BookService($bookShelf);

        return $this->render(
            'default/book_content.html.twig',
            [
                'content' => $bookService->readBook(
                    $request->get('title'),
                    $request->get('page')
                )
            ]
        );
    }
}
