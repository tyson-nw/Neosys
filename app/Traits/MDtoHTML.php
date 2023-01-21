<?php
namespace App\Traits;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

use Elazar\LeagueCommonMarkObsidian\LeagueCommonMarkObsidianExtension;

use App\Tools\AbsoluteUrlResolver;
use App\Tools\AnchorTagParser;

trait MDtoHTML{
    static function convertMDtoHTML($content, $tableofcontents = FALSE){

        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => "",
            ],
            'table_of_contents' => [
                'html_class' => 'table-of-contents',
                'position' => 'top',
                'style' => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'normalize' => 'relative',
                'placeholder' => null,
            ],
        ];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new AutolinkExtension);
        $environment->addExtension(new HeadingPermalinkExtension());

        if($tableofcontents){
            $environment->addExtension(new TableOfContentsExtension());
        }
        $resolver = new AbsoluteUrlResolver(url(' '));
        $extension = new LeagueCommonMarkObsidianExtension(
            attachmentLinkResolver: $resolver,
            internalLinkResolver: $resolver,
        );
        $environment->addExtension($extension);

        $atp = new AnchorTagParser();

        $converter = new \League\CommonMark\MarkdownConverter($environment);

        return $atp($converter->convert($content));
    }
}