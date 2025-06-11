<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Traits;

trait CaseConverter
{
    protected function toCamelCase(string $input): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', str_replace('_', ' ', $input))));
    }

    protected function toSnakeCase(string $input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }
}
