<?php
/**
 * 九酷音乐抓取
 */
namespace Dtool\Singer\Nineku;

use Dtool\Singer\SingerSearchInterface;

class SingerSearchNineku implements SingerSearchInterface
{
    /**
     * @var array 地区歌手
     */
    public $areas = [
        '内地男' => 'http://www.9ku.com/geshou/dalunan-all-all.htm',
        '内地女' => 'http://www.9ku.com/geshou/dalunv-all-all.htm',
        '内地组合' => 'http://www.9ku.com/geshou/daluzuhe-all-all.htm',
        '港台男' => 'http://www.9ku.com/geshou/gangtainan-all-all.htm',
        '港台女' => 'http://www.9ku.com/geshou/gangtainv-all-all.htm',
        '港台组合' => 'http://www.9ku.com/geshou/gangtaizuhe-all-all.htm',
        '欧美男' => 'http://www.9ku.com/geshou/oumeinan-all-all.htm',
        '欧美女' => 'http://www.9ku.com/geshou/oumeinv-all-all.htm',
        '欧美组合' => 'http://www.9ku.com/geshou/oumeizuhe-all-all.htm',
        '日韩男' => 'http://www.9ku.com/geshou/rhnan-all-all.htm',
        '日韩女' => 'http://www.9ku.com/geshou/rhnv-all-all.htm',
        '日韩组合' => 'http://www.9ku.com/geshou/rhzuhe-all-all.htm',
    ];

    /**
     * @var array 歌手类型
     */
    public $types = [
        "流行" => "/geshou/all-all-liuxing.htm",
        "摇滚" => "/geshou/all-all-yaogun.htm",
        "舞曲" => "/geshou/all-all-wuqu.htm",
        "发烧音乐" => "/geshou/all-all-fashaoyinle.htm",
        "民歌" => "/geshou/all-all-minge.htm",
        "军旅" => "/geshou/all-all-junlv.htm",
        "70后喜欢" => "/geshou/all-all-70houxihuan.htm",
        "80后喜欢" => "/geshou/all-all-80houxihuan.htm",
        "90后喜欢" => "/geshou/all-all-90houxihuan.htm",
        "网络" => "/geshou/all-all-wangluo.htm",
        "铃声" => "/geshou/all-all-lingsheng.htm",
        "非主流" => "/geshou/all-all-feizhuliu.htm",
        "儿童" => "/geshou/all-all-ertong.htm",
        "基督教" => "/geshou/all-all-jidujiao.htm",
        "佛教" => "/geshou/all-all-fojiao.htm",
        "纯音乐" => "/geshou/all-all-chunyinle.htm",
        "电影" => "/geshou/all-all-dianying.htm",
        "电视" => "/geshou/all-all-dianshi.htm",
        "动漫" => "/geshou/all-all-dongman.htm",
        "游戏" => "/geshou/all-all-youxi.htm",
        "戏曲" => "/geshou/all-all-xiqu.htm",
        "相声" => "/geshou/all-all-xiangsheng.htm",
        "小品" => "/geshou/all-all-xiaopin.htm",
        "其它" => "/geshou/all-all-qita.htm",
        "DJ" => "/geshou/all-all-dj.htm",
        "华语" => "/geshou/all-all-huayu.htm",
        "日韩" => "/geshou/all-all-rihan.htm",
        "欧美" => "/geshou/all-all-oumei.htm",
        "喊麦" => "/geshou/all-all-hanmai.htm",
    ];

    public function getList()
    {
        // TODO: Implement getList() method.
    }
}