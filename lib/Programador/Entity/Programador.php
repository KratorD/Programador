<?php

/**
 * Programador
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * Programador entity class
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity(repositoryClass="Programador_Entity_Repository_ProgramadorRepository")
 * @ORM\Table(name="programador")
 */
class Programador_Entity_Programador extends Zikula_EntityAccess
{

    /**
     * id field (record id)
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * item name
     * @ORM\Column(length=100)
     */
    private $name;
	
	/**
     * item version
     * @ORM\Column(length=10)
     */
    private $version;

	/**
     * item nVersion (orden)
     * @ORM\Column(type="smallint")
     */
    private $nVersion;

    /**
     * item image of program
     * 
     * @ORM\Column
     */
    private $image;
	
	/**
     * item description
     * 
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * item requirements for Windows
     * 
     * @ORM\Column(type="text")
     */
    private $reqWin;

	/**
     * item requirements for Macintosh
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $reqMac;

	/**
     * item requirements for Linux
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $reqLin;

    /**
     * item web
     * 
     * @ORM\Column(length=255)
     */
    private $web;

    /**
     * item company
     * 
     * @ORM\Column(length=60)
     */
    private $company;

    /**
     * item category
     * 
     * @ORM\Column(length=30)
     */
    private $category;
	
    /**
     * Constructor 
     */
    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
	
	public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
	
	public function getnVersion()
    {
        return $this->nVersion;
    }

    public function setnVersion($nVersion)
    {
        $this->nVersion = $nVersion;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getReqWin()
    {
        return $this->reqWin;
    }

    public function setReqWin($reqWin)
    {
        $this->reqWin = $reqWin;
    }

	public function getReqMac()
    {
        return $this->reqMac;
    }

    public function setReqMac($reqMac)
    {
        $this->reqMac = $reqMac;
    }

	public function getReqLin()
    {
        return $this->reqLin;
    }

    public function setReqLin($reqLin)
    {
        $this->reqLin = $reqLin;
    }

	public function getWeb()
    {
        return $this->web;
    }

    public function setWeb($web)
    {
        $this->web = $web;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }
	
	public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

}
