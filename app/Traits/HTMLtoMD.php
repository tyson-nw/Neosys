<?php
namespace App\Traits;

use League\HTMLToMarkdown\HtmlConverter;

trait HTMLtoMD{
    static function convertHTMLtoMD($content){
        //needs to trim out the toc if exists.
        dd($content);
        $converter = new HtmlConverter();
        return $converter->convert($content);
    }
}