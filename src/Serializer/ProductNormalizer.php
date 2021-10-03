<?php

namespace App\Serializer;

use App\Entity\Product;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class ProductNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'PRODUCT_NORMALIZER_ALREADY_CALLED';

    public function __construct(private Packages $assetPackages)
    {
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return false;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        if (!$data instanceof Product) {
            return false;
        }

        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return true;
    }

    /**
     * @param Product $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $context[self::ALREADY_CALLED] = true;
        $data = $this->normalizer->normalize($object, $format, $context);

        // add a fake image field
        $data['image'] = $this->assetPackages
            ->getUrl('upload/products/' . $object->getImageFilename());

        return $data;
    }
}