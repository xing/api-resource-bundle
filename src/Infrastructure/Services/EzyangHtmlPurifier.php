<?php

namespace Xing\ApiResourceBundle\Infrastructure\Services;

use HTMLPurifier;
use Xing\ApiResourceBundle\Application\Services\HtmlPurifier as HtmlPurifierInterface;

class EzyangHtmlPurifier implements HtmlPurifierInterface
{
    public function purify(?string $htmlContent, array $settings = []): string
    {
        $purifier = new HTMLPurifier($settings);

        return $purifier->purify($htmlContent);
    }
}