<?php
namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FooterController extends Controller
{

    public function showAction(){
        return $this->render('SiteBundle::footer.html.twig');
    }

}