<?php

namespace App\Entity;

use App\Repository\MailsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MailsRepository::class)
 */
class Mails
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
    private $part;

    /**
     * @ORM\Column(type="string", length=255, )
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Votre nom doit avoir au moins {{ limit }} lettres",
     *      maxMessage = "Votre nom peut au maximum faire {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Votre email doit avoir au moins {{ limit }} lettres",
     *      maxMessage = "Votre email peut au maximum faire {{ limit }} lettres",
     *      allowEmptyString = false
     * )
     * @Assert\Email(
     *      normalizer = "trim",
     *      message = "{{ value }} n'est pas un email valide"
     * )
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 15,
     *      maxMessage = "Votre numéro peut au maximum faire {{ limit }} chiffres"     
     * )
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "L\'objet peut au maximum faire {{ limit }} lettres"     
     * )
     */
    private $object;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Votre message doit avoir au moins {{ limit }} lettres"     
     * )
     * @Assert\NotBlank
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPart(): ?string
    {
        return $this->part;
    }

    public function setPart(string $part): self
    {
        $this->part = $part;

        return $this;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
