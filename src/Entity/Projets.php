<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjetsRepository::class)
 */
class Projets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Votre nom doit avoir au moins {{ limit }} lettres",
     *      maxMessage = "Votre nom peut au maximum faire {{ limit }} lettres",
     *      allowEmptyString = false
     * )

     */
    private $structure_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Votre présentation courte doit avoir au moins {{ limit }} lettres",
     *      maxMessage = "Votre présentation courte peut au maximum faire {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $header_structure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Votre phrase d'accroche doit avoir au moins {{ limit }} lettres",
     *      maxMessage = "Votre phrase d'accroche peut au maximum faire {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $catchy_sentence;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre paragraphe de présentation doit avoir au moins {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $presentation_paragraph;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $presentation_pict;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre contextualisation du projet doit avoir au moins {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $context_paragraph;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $context_pict;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre paragraphe d'explication doit avoir au moins {{ limit }} lettres",
            allowEmptyString = false
     * )
     */
    private $explain_paragraph;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $result_picture;

    /**
     * @ORM\Column(type="text",nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Votre paragraph de résultat doit avoir au moins {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $result_paragraph;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="project", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStructureName(): ?string
    {
        return $this->structure_name;
    }

    public function setStructureName(?string $structure_name): self
    {
        $this->structure_name = $structure_name;

        return $this;
    }

    public function getHeaderStructure(): ?string
    {
        return $this->header_structure;
    }

    public function setHeaderStructure(?string $header_structure): self
    {
        $this->header_structure = $header_structure;

        return $this;
    }

    public function getCatchySentence(): ?string
    {
        return $this->catchy_sentence;
    }

    public function setCatchySentence(?string $catchy_sentence): self
    {
        $this->catchy_sentence = $catchy_sentence;

        return $this;
    }

    public function getPresentationParagraph(): ?string
    {
        return $this->presentation_paragraph;
    }

    public function setPresentationParagraph(string $presentation_paragraph): self
    {
        $this->presentation_paragraph = $presentation_paragraph;

        return $this;
    }

    public function getPresentationPict(): ?string
    {
        return $this->presentation_pict;
    }

    public function setPresentationPict(string $presentation_pict): self
    {
        $this->presentation_pict = $presentation_pict;

        return $this;
    }

    public function getContextParagraph(): ?string
    {
        return $this->context_paragraph;
    }

    public function setContextParagraph(string $context_paragraph): self
    {
        $this->context_paragraph = $context_paragraph;

        return $this;
    }

    public function getContextPict(): ?string
    {
        return $this->context_pict;
    }

    public function setContextPict(string $context_pict): self
    {
        $this->context_pict = $context_pict;

        return $this;
    }

    public function getExplainParagraph(): ?string
    {
        return $this->explain_paragraph;
    }

    public function setExplainParagraph(string $explain_paragraph): self
    {
        $this->explain_paragraph = $explain_paragraph;

        return $this;
    }

    public function getFrameworkName(): ?string
    {
        return $this->framework_name;
    }

    public function setFrameworkName(string $framework_name): self
    {
        $this->framework_name = $framework_name;

        return $this;
    }

    public function getFrameworkPict(): ?string
    {
        return $this->framework_pict;
    }

    public function setFrameworkPict(string $framework_pict): self
    {
        $this->framework_pict = $framework_pict;

        return $this;
    }

    public function getResultPicture(): ?string
    {
        return $this->result_picture;
    }

    public function setResultPicture(string $result_picture): self
    {
        $this->result_picture = $result_picture;

        return $this;
    }

    public function getResultParagraph(): ?string
    {
        return $this->result_paragraph;
    }

    public function setResultParagraph(string $result_paragraph): self
    {
        $this->result_paragraph = $result_paragraph;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProject($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProject() === $this) {
                $image->setProject(null);
            }
        }

        return $this;
    }
}
