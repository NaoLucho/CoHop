<?php

namespace SiteBundle\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Application\Sonata\UserBundle\Entity\User;


use Builder\FormBundle\Manager\Form\FormBuilder;
//use AdminBundle\Form\Type\LocalisationType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Form\Type\DateRangeType;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\IsTrueValidator;
use Sonata\CoreBundle\Form\Type\CollectionType;

// use Doctrine\ORM\Event\LifecycleEventArgs;
// use Doctrine\ORM\Event\PostUpdateEventArgs;

class ProductAdmin extends AbstractAdmin
{

    //to add template for fields
    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                //var_dump( parent::getTemplate($name));
                return 'AdminBundle::Field\Admin\Form\admin_fields_form_template.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {

        //$programId = $this->getSubject()->getId();

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');

        $f_form = $em
            ->getRepository('BuilderFormBundle:F_Form')
            ->findOneBy(array('name' => 'beer'));
        
        //$user =  $this->get('security.context')->getToken()->getUser();
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        //$formMapper->with($f_form->getTitle());
        $formMapper = FormBuilder::createForm($f_form, $formMapper, $user, $em);

        // dump($formMapper);
        //$formMapper->end();
        //$entity = $formMapper->getAdmin()->getSubject();

        
        // $formMapper->add('rights', 'sonata_type_model', array(
        //     'class' => 'Application\Sonata\UserBundle\Entity\Group',
        //     'property' => 'name',
        //     'multiple' => false,
        //     'btn_add' => false,
        //     'required' => true,
        //     'label' => 'Accessibilité'
        // ))

        // ->add('publishedAt', DatePickerType::class, array(
        //     'label' => 'Date de publication'
        // ))

        // ->add('isActive',null,array(
        //     'label' => 'Visible'
        // ))

        // ->add('toReview',null,array(
        //     'label' => 'A relire'
        // ));

        
        
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('updatedAt', DateRangeFilter::class, array(
                'field_type' => DateRangeType::class,
                'label' => 'Date de publication'
            ));
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                'label' => "Nom"
            ));
            // ->add('slug')
            // ->add('publishedAt', 'date', array(
            //     'label' => 'Date de publication',
            //     'format' => 'd/m/Y',
            //     'locale' => 'fr'
            // ))
            // ->add('author.firstname', null, array(
            //     'label' => "auteur"
            // ))
            // ->add('typeArticle', null, array(
            //     'associated_property' => 'name',
            //     'label' => "Categorie"
            // ))
            // ->add('isActive',null,array(
            //     'label' => 'Visible',
            //     'editable' => true
            // ))
            // ->add('toReview',null,array(
            //     'label' => 'A relire',
            //     'editable' => true
            // ));
    }
                
    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name');
    }

    //private $tempPrev = null;
    
    // public function preUpdate($article)
    // {
    //     $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
    //     $uow = $em->getUnitOfWork();
    //     dump($uow);
    //     dump($article);
    //     $this->tempPrev = $article->getLinkprev();
    //     if($article->getLinkprev() != null)
    //     {
            
    //         dump($article->getLinkprev());
    //         $em->getRepository('SiteBundle:Article')->deleteLinkprev_forIntegrity($article->getLinkprev());
    //     }
    //     //$article->setLinkprev(null);
    //     dump($uow);
    // }

    // public function postUpdate($object)
    // {
    //     $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
    //     $uow = $em->getUnitOfWork();
    //     dump($uow);

    //     dump($object);
    //     $object->setLinkprev($this->tempPrev);
    //     dump($object);

    //     dump($uow);
    // }
    // public function postPersist($article)
    // {
    //     dump($article);
    //     dump($this->tempPrev);
    //     $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
    //     $idArticle = $article->getId();
    //     $article = $em->getRepository('SiteBundle:Article')->findOneBy(array('id' => $idArticle));
    //     $article->setLinkprev($this->tempPrev);
        
    //     dump($em->getUnitOfWork());
    //     $em->flush();
    // }
}