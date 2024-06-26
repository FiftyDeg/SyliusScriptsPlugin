<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use DOMDocument;
use DOMNode;
use Exception;
use FiftyDeg\SyliusScriptsPlugin\Form\Attribute\FormType;
use Sylius\Component\Resource\Model\AbstractTranslation;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/**
 * @ORM\Entity()
 *
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
    protected ?int $id;

    /** @ORM\Column(type="text", name="content", nullable=true) */
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

        return null === $content
            ? $content
            : $this->formatContent($content);
    }

    public function setContent(?string $content): self
    {
        $this->content = null === $content
            ? $content
            : $this->sanitizeContent($content);

        return $this;
    }

    private function sanitizeContent(?string $content): string
    {
        try {
            if (null === $content || '' === $content) {
                return '';
            }

            $domIn = new DOMDocument();
            $domOut = new DOMDocument();

            $domIn->loadHTML($content);

            /** @var array<int,DOMNode> $scriptElements */
            $scriptElements = $domIn->getElementsByTagName('script');

            foreach ($scriptElements as $scriptElement) {
                $scriptNode = $domOut->importNode($scriptElement, true);

                $domOut->append($scriptNode);
            }

            $html = $domOut->saveHTML();

            return false !== $html ? $html : '';
        } catch (Exception $e) {
            return '';
        }
    }

    private function formatContent(string $content): string
    {
        return str_replace('</script><script', "</script>\n\n<script", $content);
    }
}
