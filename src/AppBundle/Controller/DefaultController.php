<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    public function greetAction()
    {
        $session = $this->get('session');
        $name = $session->get('my_name');

        return new Response(sprintf('Hello my master %s', $name));
    }

    public function changeNameAction(Request $request)
    {
        $session = $this->get('session');
        $session->set('my_name', $request->get('name'));

        return new RedirectResponse(
            $this->get('router')->generate('my_name')
        );
    }

    public function readBookAction(Request $request)
    {
        $bookService = $this->get('book_reader');

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
