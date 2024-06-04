<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use DOMDocument;
use FiftyDeg\SyliusScriptsPlugin\Form\Attribute\FormType;
use Sylius\Component\Resource\Model\AbstractTranslation;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @ORM\Entity()
 * @ORM\Table(name="fiftydeg_scripts_script_translation")
 */
class ScriptTranslation extends AbstractTranslation implements ScriptTranslationInterface
{
    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", name="content", nullable=true) */
    #[FormType(TextareaType::class, ['required' => true])]
    #[NotBlank]
    #[NotNull]
    protected ?string $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        $content = $this->content;

        return is_null($content)
            ? $content
            : $this->formatContent($content);
    }

    public function setContent(?string $content): self
    {
        $this->content = is_null($content)
            ? $content
            : $this->sanitizeContent($content);

        return $this;
    }

    private function sanitizeContent(?string $content): string {
        $domIn = new DOMDocument();
        $domOut = new DOMDocument();

        $domIn->loadHTML($content);

        $scriptElements = $domIn->getElementsByTagName('script');

        foreach ($scriptElements as $scriptElement) {
            $scriptNode = $domOut->importNode($scriptElement, true);

            $domOut->append($scriptNode);
        }

        return $domOut->saveHTML() ?: '';
    }

    private function formatContent(string $content): string {
        return str_replace("</script><script", "</script>\n\n<script", $content);
    }
}
