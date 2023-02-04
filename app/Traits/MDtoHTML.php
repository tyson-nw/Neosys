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
    function convertMDtoHTML($content){

        if(isset($this->tableofcontentslevel)){
            $tableofcontentslevel = $this->tableofcontentslevel;
        }else{
            $tableofcontentslevel = 6;
        }
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
                'max_heading_level' => $tableofcontentslevel,
                'normalize' => 'relative',
                'placeholder' => null,
            ],
            'table' => [
                'wrap' => [
                    'enabled' => true,
                    'tag' => 'div',
                    'attributes' => ['class' => 'table-responsive float-left'],
                ],
            ],
        ];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new AutolinkExtension); 
        $environment->addExtension(new TableExtension);
        

        if(isset($this->tableofcontents)){
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

    public function setContentAttribute($content){
        $this->attributes['content']  = $content;
        $this->attributes['html']  = $this->convertMDtoHTML($content); 
    }
}