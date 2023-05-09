<?php

namespace App\Controller;

use App\Entity\Payment;

use App\Entity\Game;

use Doctrine\ORM\EntityManagerInterface;
use Omnipay\Omnipay;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends AbstractController
{
    
     private $passerelle;

     private $manager;
     
     public function __construct(EntityManagerInterface $manager)
     {
        $this->passerelle=Omnipay::create('PayPal_Rest');

        $this->passerelle->setClientId($_ENV['PAYPAL_CLIENT_ID']);
        $this->passerelle->setSecret($_ENV['PAYPAL_SECRET_KEY']);
        $this->passerelle->setTestMode(true);

        $this->manager=$manager;

     }




    //Page d'accueil
    #[Route('/cart', name: 'app_cart')]
    public function cart(): Response
    {
        return $this->render('game/details.html.twig');
    }


    //Game Payment
    #[Route('/payment', name: 'app_payment', methods: ['GET', 'POST'])]
    
public function payment(Request $request): Response
{
   $token = $request->request->get('token');

   if(!$this->isCsrfTokenValid('myform', $token))
   {
        return new Response('Operation non autorisée', Response::HTTP_BAD_REQUEST,
        ['content-type' => 'text/plain']);
   }

   $response = $this->passerelle->purchase(array(
    'amount' => $request->request->get('amount'),
    'currency' => $_ENV['PAYPAL_CURRENCY'],
    'returnUrl' => 'http://127.0.0.1:8000/success',
    'cancelUrl' => 'http://127.0.0.1:8000/error'
  
    ))->send();

    try {
        if($response->isRedirect())
        {
            $response->redirect();
        }

        else
        {
            return new Response($response->getMessage());
        }
    } catch (\Throwable $th) {
        
        return new Response($th->getMessage());
    }
  
   
    return $this->render('operation/index.html.twig');
}


    //Page de succès de la transaction
    #[Route('/success', name: 'app_success', methods: ['GET', 'POST'])]
    public function success(Request $request): Response
    {

       if($request->query->get('paymentId') && $request->query->get('PayerID'))
       {
         $operation=$this->passerelle->completePurchase(array(
            'payer_id'=>$request->query->get('PayerID'),
            'transactionReference'=>$request->query->get('paymentId')
         ));

         $response=$operation->send();

         if($response->isSuccessful())
         {
             $data=$response->getData();

              
             $payment = new Payment();

             $payment->setPaymentId($data['id'])
                     ->setPayerId($data['payer']['payer_info']['payer_id'])
                     ->setPayerEmail($data['payer']['payer_info']['email'])
                     ->setAmount($data['transactions'][0]['amount']['total'])
                     ->setCurrency($_ENV['PAYPAL_CURRENCY'])
                     ->setPurchasedAt(new \DateTime())
                     ->setPaymentStatus($data['state']);


            $this->manager->persist($payment);

            $this->manager->flush();
            
            return $this->render('Operation/success.html.twig',
              [
                'message'=>'Votre paiement a été un succès, voici l\'id de votre transaction:' .$data['id']
              ]
              );
         }

         else
         {
            return $this->render('Operation/success.html.twig',
              [
                'message'=>'Le paiement a échoué !'
              ]
              );
         }
         
       } 

       else
       {
        return $this->render('Operation/success.html.twig',
              [

                'message'=>'l\'utilisateur a annulé son paiement'

              ]
              );
       }
       
    }



    //Page d'error de la transaction
    #[Route('/error', name: 'app_error')]
    public function error(): Response
    {
        return $this->render('Operation/success.html.twig',
              [
                'message'=>'le paiement a échoué'
              ]
              );
    }



    //Booster Payment
    #[Route('/payment2', name: 'app_payment2', methods: ['GET', 'POST'])]
    
public function payment2(Request $request): Response
{
   $token = $request->request->get('token');

   if(!$this->isCsrfTokenValid('myform', $token))
   {
        return new Response('Operation non autorisée', Response::HTTP_BAD_REQUEST,
        ['content-type' => 'text/plain']);
   }

   $response = $this->passerelle->purchase(array(
    'amount' => $request->request->get('amount'),
    'currency' => $_ENV['PAYPAL_CURRENCY'],
    'returnUrl' => 'http://127.0.0.1:8000/success2',
    'cancelUrl' => 'http://127.0.0.1:8000/error'
  
    ))->send();

    try {
        if($response->isRedirect())
        {
            $response->redirect();
        }

        else
        {
            return new Response($response->getMessage());
        }
    } catch (\Throwable $th) {
        
        return new Response($th->getMessage());
    }
  
   
    return $this->render('operation/index.html.twig');
}


    //Page de succès de la transaction
    #[Route('/success2', name: 'app_success2', methods: ['GET', 'POST'])]
    public function success2(Request $request): Response
    {

       if($request->query->get('paymentId') && $request->query->get('PayerID'))
       {
         $operation=$this->passerelle->completePurchase(array(
            'payer_id'=>$request->query->get('PayerID'),
            'transactionReference'=>$request->query->get('paymentId')
         ));

         $response=$operation->send();

         if($response->isSuccessful())
         {
             $data=$response->getData();

              
             $payment = new Payment();

             $payment->setPaymentId($data['id'])
                     ->setPayerId($data['payer']['payer_info']['payer_id'])
                     ->setPayerEmail($data['payer']['payer_info']['email'])
                     ->setAmount($data['transactions'][0]['amount']['total'])
                     ->setCurrency($_ENV['PAYPAL_CURRENCY'])
                     ->setPurchasedAt(new \DateTime())
                     ->setPaymentStatus($data['state']);


            $this->manager->persist($payment);

            $this->manager->flush();
            
            return $this->render('Operation/success2.html.twig',
              [
                'message'=>'Votre paiement a été un succès, voici l\'id de votre transaction:' .$data['id']
              ]
              );
         }

         else
         {
            return $this->render('Operation/success2.html.twig',
              [
                'message'=>'Le paiement a échoué !'
              ]
              );
         }
         
       } 

       else
       {
        return $this->render('Operation/success2.html.twig',
              [

                'message'=>'l\'utilisateur a annulé son paiement'

              ]
              );
       }
       
    }


    //Coach Payment
    #[Route('/payment3', name: 'app_payment3', methods: ['GET', 'POST'])]
    
public function payment3(Request $request): Response
{
   $token = $request->request->get('token');

   if(!$this->isCsrfTokenValid('myform', $token))
   {
        return new Response('Operation non autorisée', Response::HTTP_BAD_REQUEST,
        ['content-type' => 'text/plain']);
   }

   $response = $this->passerelle->purchase(array(
    'amount' => $request->request->get('amount'),
    'currency' => $_ENV['PAYPAL_CURRENCY'],
    'returnUrl' => 'http://127.0.0.1:8000/success3',
    'cancelUrl' => 'http://127.0.0.1:8000/error'
  
    ))->send();

    try {
        if($response->isRedirect())
        {
            $response->redirect();
        }

        else
        {
            return new Response($response->getMessage());
        }
    } catch (\Throwable $th) {
        
        return new Response($th->getMessage());
    }
  
   
    return $this->render('operation/index.html.twig');
}


    //Page de succès de la transaction
    #[Route('/success3', name: 'app_success3', methods: ['GET', 'POST'])]
    public function success3(Request $request): Response
    {

       if($request->query->get('paymentId') && $request->query->get('PayerID'))
       {
         $operation=$this->passerelle->completePurchase(array(
            'payer_id'=>$request->query->get('PayerID'),
            'transactionReference'=>$request->query->get('paymentId')
         ));

         $response=$operation->send();

         if($response->isSuccessful())
         {
             $data=$response->getData();

              
             $payment = new Payment();

             $payment->setPaymentId($data['id'])
                     ->setPayerId($data['payer']['payer_info']['payer_id'])
                     ->setPayerEmail($data['payer']['payer_info']['email'])
                     ->setAmount($data['transactions'][0]['amount']['total'])
                     ->setCurrency($_ENV['PAYPAL_CURRENCY'])
                     ->setPurchasedAt(new \DateTime())
                     ->setPaymentStatus($data['state']);


            $this->manager->persist($payment);

            $this->manager->flush();
            
            return $this->render('Operation/success.html.twig',
              [
                'message'=>'Votre paiement a été un succès, voici l\'id de votre transaction:' .$data['id']
              ]
              );
         }

         else
         {
            return $this->render('Operation/success.html.twig',
              [
                'message'=>'Le paiement a échoué !'
              ]
              );
         }
         
       } 

       else
       {
        return $this->render('Operation/success.html.twig',
              [

                'message'=>'l\'utilisateur a annulé son paiement'

              ]
              );
       }
       
    }


}