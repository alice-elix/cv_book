<?php

namespace App\Entity;

use App\Repository\ProjetsRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $structure_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $header_structure;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $catchy_sentence;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation_paragraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $presentation_pict;

    /**
     * @ORM\Column(type="text")
     */
    private $context_paragraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $context_pict;

    /**
     * @ORM\Column(type="text")
     */
    private $explain_paragraph;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $framework_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $framework_pict;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $result_picture;

    /**
     * @ORM\Column(type="text")
     */
    private $result_paragraph;

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
}
