<?php

namespace Xing\ApiResourceBundle\Application\Services;

interface HtmlPurifier
{
    public function purify(?string $htmlContent, array $settings = []): string;
}