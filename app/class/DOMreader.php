<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 11.04.2017
 * Time: 22:39
 */

namespace ferhengo\regex;
require_once '../../vendor/autoload.php';
require_once 'CurlClient.php';
use ferhengo\curl\CurlClient;
use FluentDOM;

class DOMreader
{

    private $links = [];
    private $texts = [];

    static protected function getPageSource($link)
    {
        return CurlClient::callLink($link);
    }

    protected function getDOM($pageSource)
    {
        return FluentDOM::load(
            $pageSource,
            'text/html',
            [FluentDOM\Loader\Options::ALLOW_FILE => TRUE]
        );
    }

    protected function findLinks($DOM)
    {
        foreach ($DOM('//a[@href]') as $a) {
            $this->links[] = [
                'caption' => (string)$a,
                'href' => $a['href']
            ];
        }
    }

    protected function findTexts($DOM)
    {
        foreach ($DOM('//body]') as $body) {
            $this->texts[] = $body->nodeValue;
        }
    }

    public function getTexts()
    {
        return $this->texts;
    }

    public function getLinks()
    {
        return $this->links;
    }
}


