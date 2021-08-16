<?php

namespace SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use SiteBundle\Entity\Category;
// use App\Entity\EcommerceConfig;
use JMS\Serializer\Annotation as Serializer;
// use JMS\Serializer\Annotation as Serializer;     Serializer\Groups("default")

/**
 * @ORM\Entity(repositoryClass="SiteBundle\Repository\ProductRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"typedata", "base"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"typedata", "base"})
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Serializer\Groups({"typedata", "base"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups({"typedata", "base"})
     */
    private $hasNoStock;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"typedata", "base"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     * @Serializer\Groups({"typedata", "base"})
     */
    private $unit;

    /**
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"typedata", "base"})
     */
    private $step;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priority;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"typedata", "base"})
     */
    private $imageName;

    /**
    * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
    * @Assert\File(maxSize="2M", mimeTypes={"image/png","image/jpeg"}, mimeTypesMessage = "Entrez une image valide")
    *
    * @var File
    */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("typedata")
     */
    private $imageName2;

    /**
    * @Vich\UploadableField(mapping="products", fileNameProperty="imageName2")
    * @Assert\File(maxSize="2M", mimeTypes={"image/png","image/jpeg"}, mimeTypesMessage = "Entrez une image valide")
    *
    * @var File
    */
    protected $imageFile2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("typedata")
     */
    private $imageName3;

    /**
    * @Vich\UploadableField(mapping="products", fileNameProperty="imageName3")
    * @Assert\File(maxSize="2M", mimeTypes={"image/png","image/jpeg"}, mimeTypesMessage = "Entrez une image valide")
    *
    * @var File
    */
    protected $imageFile3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("typedata")
     */
    private $imageName4;

    /**
    * @Vich\UploadableField(mapping="products", fileNameProperty="imageName4")
    * @Assert\File(maxSize="2M", mimeTypes={"image/png","image/jpeg"}, mimeTypesMessage = "Entrez une image valide")
    *
    * @var File
    */
    protected $imageFile4;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    // /**
    // * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="products", cascade={"persist"})
    // */
    // private $categories;

    /** Type de l'article
     * @ORM\ManyToMany(targetEntity="Builder\ListBundle\Entity\G_ListItem")
     * @ORM\JoinColumn(name="li_category_product", referencedColumnName="id", nullable=false )
     */ //G_List:  category_product
     private $categories; //Optionnel

    // /**
    //  * var EcommerceConfig
    //  *
    //  * ORM\ManyToOne(targetEntity="EcommerceConfig", inversedBy="products")
    //  * ORM\JoinColumn(referencedColumnName="id", nullable=false)
    //  * Serializer\Groups({"typedata", "base"})
    //  */
    // private $tva;


    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Groups("typedata")
     */
    private $promote = false;

    public function __toString() {
        return $this->name;
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->unit = 'bouteille';
        $this->step = 1;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHasNoStock(): ?bool
    {
        return $this->hasNoStock;
    }

    public function setHasNoStock(?bool $hasNoStock = false): self
    {
        $this->hasNoStock = $hasNoStock;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }


    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
    

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image2
     *
     * @return Product
     */
    public function setImageFile2(File $image2 = null)
    {
        $this->imageFile2 = $image2;

        if ($image2) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile2()
    {
        return $this->imageFile2;
    }


    public function getImageName2(): ?string
    {
        return $this->imageName2;
    }

    public function setImageName2(?string $imageName2): self
    {
        $this->imageName2 = $imageName2;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image3
     *
     * @return Product
     */
    public function setImageFile3(File $image3 = null)
    {
        $this->imageFile3 = $image3;

        if ($image3) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile3()
    {
        return $this->imageFile3;
    }


    public function getImageName3(): ?string
    {
        return $this->imageName3;
    }

    public function setImageName3(?string $imageName3): self
    {
        $this->imageName3 = $imageName3;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|UploadedFile $image4
     *
     * @return Product
     */
    public function setImageFile4(File $image4 = null)
    {
        $this->imageFile4 = $image4;

        if ($image4) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile4()
    {
        return $this->imageFile4;
    }


    public function getImageName4(): ?string
    {
        return $this->imageName4;
    }

    public function setImageName4(?string $imageName4): self
    {
        $this->imageName4 = $imageName4;

        return $this;
    }


    public function getImageMapper()
    {
        $array = [
            'imageFile' => 'imageName',
            'imageFile2' => 'imageName2',
            'imageFile3' => 'imageName3',
            'imageFile4' => 'imageName4'
        ];

        return $array;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }


    /**
     * CATEGORY
     * @param \Builder\ListBundle\Entity\G_ListItem $category [description]
     */
    public function addCategory(\Builder\ListBundle\Entity\G_ListItem $categories)
    {
        $this->categories[] = $categories;
        // $categories->addProduct($this);
        return $this;
    }

    public function removeCategory(\Builder\ListBundle\Entity\G_ListItem $category)
    {
        $this->categories->removeElement($category);
        // $category->removeProduct($this);
    }

    public function getCategories()
    {
        return $this->categories;
    }


    // /**
    //  * Set tva
    //  *
    //  * param EcommerceConfig $tva
    //  *
    //  * return Product
    //  */
    // public function setTva($tva)
    // {
    //     $this->tva = $tva;

    //     return $this;
    // }

    // /**
    //  * Get tva
    //  *
    //  * return EcommerceConfig
    //  */
    // public function getTva()
    // {
    //     return $this->tva;
    // }

    public function getPromote(): bool
    {
        return $this->promote;
    }

    public function setPromote(bool $promote = false): self
    {
        $this->promote = $promote;

        return $this;
    }


}
