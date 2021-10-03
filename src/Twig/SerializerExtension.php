<?php

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SerializerExtension extends AbstractExtension
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('jsonld', [$this, 'serializeToJsonLd'], ['is_safe' => ['html']]),
        ];
    }

    public function serializeToJsonLd($data): string
    {
        return $this->serializer->serialize($data, 'jsonld');
    }
}