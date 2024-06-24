<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FiftyDeg\SyliusScriptsPlugin\Form\Attribute\FormType;
use FiftyDeg\SyliusScriptsPlugin\Form\Type\TemplateEventChoiceType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @ORM\Entity()
 *
 * @ORM\Table(name="fiftydeg_scripts_script")
 */
class Script implements ScriptInterface
{
    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    protected ?int $id;

    /**
     * @var Collection<int, ChannelInterface>
     *
     * @ORM\ManyToMany(targetEntity="Sylius\Component\Core\Model\Channel")
     *
     * @ORM\JoinTable(name="fiftydeg_scripts_script_channel",
     *      joinColumns={@ORM\JoinColumn(name="channel_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="script_id", referencedColumnName="id")}
     * )
     */
    #[FormType(ChannelChoiceType::class, [
        'multiple' => true,
        'expanded' => true,
        'required' => false,
    ])]
    protected Collection $channels;

    /** @ORM\Column(type="string", name="name", nullable=false) */
    #[FormType(TextType::class, ['required' => true])]
    #[NotBlank]
    #[NotNull]
    protected ?string $name;

    /** @ORM\Column(type="string", name="template_event", nullable=false) */
    #[FormType(TemplateEventChoiceType::class, ['required' => true])]
    #[NotBlank]
    #[NotNull]
    protected ?string $templateEvent;

    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->channels = new ArrayCollection();

        $this->initializeTranslationsCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ChannelInterface>
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * @param Collection<int, ChannelInterface> $channels
     */
    public function setChannels(Collection $channels): self
    {
        $this->channels = $channels;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTemplateEvent(): ?string
    {
        return $this->templateEvent;
    }

    public function setTemplateEvent(?string $templateEvent): self
    {
        $this->templateEvent = $templateEvent;

        return $this;
    }

    public function getContent(): ?string
    {
        /** @var ScriptTranslationInterface $translation */
        $translation = $this->getTranslation();

        return $translation->getContent();
    }

    public function setContent(?string $content): self
    {
        /** @var ScriptTranslationInterface $translation */
        $translation = $this->getTranslation();

        $translation->setContent($content);

        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function createTranslation(): ScriptTranslationInterface
    {
        return new ScriptTranslation();
    }
}
