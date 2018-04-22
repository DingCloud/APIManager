<?php
/**
 * 背景音乐插件示例
 * @package DingStudio/DynamicBgm
 * @author David Ding
 * @copyright 2012-2018 All Rights Reserved
 */

class DynamicBgm {

    /**
     * 插件入口函数
     * 此处仅仅实现一个音乐ID的随机数返回功能
     * 注意init函数必须返回数据，否则平台将无法通过$response->make获取到数据。
     * @return mixed
     */
    public static function init() {
        $musicList = array('577785','28302231','36897723','465239256','505446396');
        return $musicList[rand(0, 4)];
    }
}