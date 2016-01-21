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

    public function doPaymentAction()
    {
        $paymentParams = array(
            'id' => '725630',
            'amount' => 123,
            'description' => 'Zapłata za usługę',
            'firstname' => 'Jakub',
            'lastname' => 'Kanclerz',
            'email' => 'jakub.kanclerz@gmail.com',
            'control' => '123-abc',
        );

        $url = sprintf(
            '%s/?%s',
            'https://ssl.dotpay.pl/test_payment/',
            http_build_query($paymentParams)
        );

        return new RedirectResponse($url);
    }

    public function confirmAction(Request $request)
    {
        $logger = $this->get('logger');

        $logger->notice('URLC DOTPAY -----------------------------------------------'.var_export($request->request, true));

        //// here calculate signature
        $params = array(
            'un9Cqip3gQXSmcjVbdGm2ycqSrKsGTE2',
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
        );
        
        $sign = implode('', $params);

        $signature = hash('sha256', $sign);

        if ($signature === $request->request->get('md5')) {
            //zatwierdzamy zamówienei
            //etc
            // potwierdzenia wszustko
            return new Response('OK');
        }

        return new Response('FAIL', 400);
    }


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
