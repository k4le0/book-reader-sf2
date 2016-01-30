<?php

namespace AppBundle\Controller;

use Jkan\BookStore\Domain\Exception\StoreException;
use Jkan\BookStore\Infrastructure\Payment\DotpayCompletePayment;
use Jkan\BookStore\Infrastructure\Payment\DotpayPaymentFactory;
use AppBundle\Entity\Product;
use Jkan\BookCanonicalModel\OrderIdentifier;
use Jkan\BookStore\Application\BookBuying;
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
        $product = new Product('Biały Miś');
        $product->increaseSupply();
        $product->increaseSupply();

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);

        $product = new Product('Czarny Kot');
        $product->increaseSupply();
        $product->increaseSupply();
        $product->increaseSupply();
        $product->increaseSupply();

        $em->persist($product);


        $em->flush();

        // $product = new Product('Mój Produkt 4');
        // $em->persist($product);


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    public function displayProductAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle\Entity\Product');

        $product = $repository->find($request->get('id'));

        return new Response('Product: '. $product->name());
    }

    public function doPaymentAction(Request $request)
    {
        /*
            https://ssl.dotpay.pl/test_payment/?
            id=725630
            &amount=144
            &description=Zapłata za wypożyczenie
            &control=15-01-2016
            &firstname=Jakub
            &lastname=Kanclerz
            &email=jakub.kanclerz@gmail.com
        */
        $params = array(
            'id' => $this->getParameter('dotpay_id'),
            'amount' => '156',
            'description' => 'Zapłata za uslugę',
            'control' => 'Z-15-01-2016',
            'firstname' => 'Jakub',
            'lastname' => 'Kanclerz',
            'email' => 'jakub.kanclerz@gmail.com',
            'type' => 1,
            'api_version' => 'dev',
        );

        $url = sprintf(
            '%s?%s',
            'https://ssl.dotpay.pl/test_payment/',
            http_build_query($params)
        );

        return new RedirectResponse($url);
    }

    public function confirmPaymentAction(Request $request)  
    {
        $dotpayPaymentFactory = new DotpayPaymentFactory();
        $bookBuying = new BookBuying();

        try {
            $bookBuying->completePurchase(
                new OrderIdentifier($request->get('control')),
                $dotpayPaymentFactory->createPayment(
                    new DotpayCompletePayment(
                        $request->request->all(),
                        $this->getParameter('dotpay_pin')
                    )
                )
            );

            return new Response('OK');
        } catch (StoreException $e) {
            return new Response('FAIL');
        }
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
