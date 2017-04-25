<?php
/**
 * Created by PhpStorm.
 * User: Ark
 * Date: 11.04.2017
 * Time: 22:39
 */

namespace ferhengo\regex;
require_once '../vendor/autoload.php';
require_once 'CurlClient.php';
use ferhengo\curl\CurlClient;
use FluentDOM;

class DOMreader
{
    private $mainDomain;
    protected $pageSource;
    private $sameDomainLinks = [];
    private $links = [];
    private $texts = [];

    function __construct( $link)
    {
        $this->mainDomain = $link;
        $this->pageSource =  self::getPageSource($link);
    }

    static protected function getPageSource(  $link)
    {
        return CurlClient::callLink($link);
    }

    public function getDOM()
    {
        return FluentDOM::load(
            $this->pageSource,
            'text/html',
            [FluentDOM\Loader\Options::ALLOW_FILE => TRUE]
        );
    }

    public function findLinks(  $DOM)
    {
        foreach ($DOM('//a[@href]') as $a) {
            if ($a['href']){
                $this->links[] = [
                    'caption' => (string)$a,
                    'href' => urldecode($a['href'])
                ];
            }
        }
    }

    public function findTexts(  $DOM)
    {
        foreach ($DOM('//body]') as $body) {
            $this->texts[] = $body->nodeValue;
        }
    }

    public function belongToDomain($link, $criteria)
    {
        if (!$link) return false;
        return substr($link['href'], 1,4 ) == $criteria;
    }

    public function addToSameDomainLinks($link)
    {
        array_push($this->sameDomainLinks, $this->mainDomain.$link['href']);
    }

    public function getTexts()
    {
        return $this->texts;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function getSameLinks()
    {
        return $this->sameDomainLinks;
    }
}


