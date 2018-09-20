<?php
namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Gregwar\CaptchaBundle\Type\CaptchaType;

class MailContactController extends Controller
{

    public function mailContactAction(Request $request)
    {
        
        $defaultData = array();
        $form = $this->createFormBuilder($defaultData)
            ->add('name', TextType::class, array(
                'required' => false,
                'label' => 'Nom :'
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'E-mail :'
            ))
            ->add('object', TextType::class, array(
                'required' => false,
                'label' => 'Objet :'
            ))
            ->add('message', TextareaType::class, array(
                'required' => true,
                'label' => 'Message :',
                'attr' => ['rows' => 10]
            ))
            ->add('captcha', CaptchaType::class, array(
                'label' => 'Recopiez le code figurant dans l\'image :',
                'attr' => ['class' => 'captcha'],
                'label_attr' => ['class' => 'label_captcha'],
            ))
            ->add('Nous contacter', SubmitType::class, array(
                'attr' => ['class' => 'btn btn-success btn-lg btn-block mt-5']
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $data = $form->getData();
            if($form->isValid()) {
                
                if ($this->sendEmail($data)) {
                    dump($data);
                    // Everything OK, redirect to wherever you want ! :
        
                    return $this->render('SiteBundle:Contact:contact-mail-success.html.twig');
                }
            }
        }

        // $pageparams = array(
        //     'form' => $form->createView()
        // );

        // $pageparams = array_merge($pageparams, $builderparams);


        // send email
        return $this->render('SiteBundle:Contact:contact-mail-form.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function sendEmail($data)
    {
        // Create the message
        $message = (new \Swift_Message())

        // Give the message a subject
        ->setSubject($data['object'])

        // Set the From address with an associative array
        ->setFrom([$data['email'] => $data['name']])

        // Set the To addresses with an associative array (setTo/setCc/setBcc)
        ->setTo(['louis.watrin@gmail.com'])

        // Give it a body
        ->setBody($data['message'])
        // ->setBody(
        //     $this->renderView(
        //         // app/Resources/views/Emails/registration.html.twig
        //         'Emails/registration.html.twig',
        //         array('name' => $name)
        //     ),
        //     'text/html'
        // )
        ;

        return  $this->get('mailer')->send($message);

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

        //return $this->render('SiteBundle::map-info.html.twig');
    }
}