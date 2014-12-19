<?php

namespace Bolt\Extension\xijia37\ShareTo;

class Extension extends \Bolt\BaseExtension
{

    function info() {

        $data = array(
            'name' =>"Share to",
            'description' => "add a twig function to display a shareto button",
            'author' => "Hugo Teoh",
            'link' => "http://bolt.cm",
            'version' => "1.1",
            'required_bolt_version' => "2.0",
            'highest_bolt_version' => "3.0",
            'type' => "Twig function",
            'first_releasedate' => "2012-10-10",
            'latest_releasedate' => "2013-01-27",
        );

        return $data;

    }

    function initialize() {

        $snippet = <<<SHARE
               <!-- bshare -->
               <script src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh" charset="utf-8" type="text/javascript"></script>
               <script src="http://static.bshare.cn/b/bshareC0.js" charset="utf-8" type="text/javascript"></script>
               <!-- bshare -->
SHARE;

        $this->addSnippet(\Bolt\Extensions\Snippets\Location::END_OF_BODY, $snippet);

        $this->addTwigFunction('shareto', 'shareto');
        $this->addTwigFunction('bshare', 'bshare');

    }

    function bshare(){

        $html = <<<SHARE
           <!-- bshare -->
           <div class="bshare-custom">
               <a title="分享到QQ空间" class="bshare-qzone"></a>
               <a title="分享到新浪微博" class="bshare-sinaminiblog"></a>
               <a title="分享到腾讯微博" class="bshare-qqmb"></a>
               <a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a>
           </div>
           <!-- bshare -->
SHARE;

        return new \Twig_Markup($html, 'UTF-8');
    }

    function shareto($link = null, $title = null,$image = null) {

        $link = $this->app['paths']['hosturl'] . $link;
        if(!is_null($image)) $image = $this->app['paths']['hosturl'] . $image;
        $link_encoded = urlencode($link);
        $title_encoded = urlencode($title);
        $image_encoded = urlencode($image);

        $html = <<<SHARE
                <div>
                    <iframe allowTransparency="true" frameborder="0" scrolling="no" src="http://hits.sinajs.cn/A1/weiboshare.html?url={$link_encoded}&type=3&appkey=&title={$title_encoded}&pic={$image_encoded}&ralateUid=3180146291&language=zh_cn&rnd=1408611937" width="16" height="16">
                    </iframe>
                </div>
                <div>
                    <a href="javascript:;" title="转播到腾讯微博" onclick="javascript:window.open( 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+encodeURIComponent('{$link}')+'&appkey=&pic='+encodeURI('{$image}')+'&assname='+encodeURI('hisuorg')+'&title='+encodeURI('{$title}'),'', 'width=700, height=680, top=0, left=0, toolbar=no, me  nubar=no, scrollbars=no, location=yes, resizable=no, status=no' );"><img src="http://v.t.qq.com/share/images/s/weiboicon16.png">
                    </a>
                </div>
SHARE;

        return new \Twig_Markup($html, 'UTF-8');

    }

    public function getName(){
        return 'shareto';
    }


}

