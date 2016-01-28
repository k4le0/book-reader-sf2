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

    public function doPaymentAction()
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
            'id' => '725630',
            'amount' => '156',
            'description' => 'Zapłata za uslugę',
            'control' => 'Z-15-01-2016',
            'firstname' => 'Jakub',
            'lastname' => 'Kanclerz',
            'email' => 'jakub.kanclerz@gmail.com',
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
        $pin = 'un9Cqip3gQXSmcjVbdGm2ycqSrKsGTE2';
        $params = [
            $pin,
            $request->request->get('id'),
            $request->request->get('operation_number'),
            $request->request->get('operation_type'),
            $request->request->get('operation_status'),
            $request->request->get('operation_amount'),
            $request->request->get('operation_currency'),
            $request->request->get('operation_withdrawal_amount'),
            $request->request->get('operation_commission_amount'),
            $request->request->get('operation_original_amount'),
            $request->request->get('operation_original_currency'),
            $request->request->get('operation_datetime'),
            $request->request->get('operation_related_number'),
            $request->request->get('control'),
            $request->request->get('description'),
            $request->request->get('email'),
            $request->request->get('p_info'),
            $request->request->get('p_email'),
            $request->request->get('channel'),
            $request->request->get('channel_country'),
            $request->request->get('geoip_country'),
        ];
        
        $concated = implode('', $params);

        $signature = hash('sha256', $concated);

        $logger = $this->get('logger');

        $logger->notice('URLC------------------------------------------'.
            var_export($request->request, true)
        );

        $hash = $request->get('md5');
        if ($signature === $hash) {
            //confirm order
            //do sth
            //book dates etc.
            //change state of system
            return new Response('OK');
        }

        return new Response('FAIL');
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
