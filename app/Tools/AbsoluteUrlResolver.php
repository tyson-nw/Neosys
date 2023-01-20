<?php

namespace App\Tools;

use Elazar\LeagueCommonMarkObsidian\Resolver\LinkResolverInterface;

class AbsoluteUrlResolver implements LinkResolverInterface
{
    public function __construct(private string $baseUrl) { }

    public function resolve(string $name, string $fromPath): string
    {
        // Resolve $name to the relative path of the built HTML file or attachment
        // $path = ...
		//var_dump($fromPath);
        return $this->baseUrl. "/".$name. $fromPath;
    }
}