<?php


/**
 * geo
 * 计算两点距离
 *
 *  all geo api
 * "geoadd","geodist","geohash","geopos",
 * "georadius","georadius_ro","georadiusbymember",
 * "georadiusbymember_ro"
 */


abstract class Base
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    public function __destruct()
    {
        $this->redis->close();
    }
}


class Geo extends Base
{
    const GEO_AREA_KEY = 'geo_area_map_key';

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * 添加地点
     * @param $longitude
     * @param $latitude
     * @param $name
     * @return mixed
     */
    public function addElement($longitude, $latitude, $name)
    {
        return $this->redis->geoAdd(self::GEO_AREA_KEY, $longitude, $latitude, $name);
    }

    /**
     * 获取两点间距离
     * @param $name1
     * @param $name2
     * @return mixed
     */
    public function geoDist($name1, $name2)
    {
        return $this->redis->geoDist(self::GEO_AREA_KEY, $name1, $name2);
    }

    /**
     * 获取某点经纬度
     * @param $name
     * @return mixed
     */
    public function geoPos($name)
    {
        return $this->redis->geoPos(self::GEO_AREA_KEY, $name);
    }


    /**
     * 通过地点获取周边元素
     * @param $longitude
     * @param $latitude
     * @param int $radius
     * @param string $unit
     * @return mixed
     */
    public function geoRadius($longitude, $latitude, $radius = 100, $unit = 'km')
    {
        $options = [
            'withcoord',
            'withdist',
        ];
        return $this->redis->geoRadius(self::GEO_AREA_KEY, $longitude, $latitude, $radius, $unit, $options);
    }

    /**
     * 通过名称获取周边元素
     */
    public function geoRadiusByMember($name, $radius = 100, $unit = 'km')
    {
        $options = [
            'withcoord',
            'withdist',
        ];
        return $this->redis->geoRadiusByMember(self::GEO_AREA_KEY, $name, $radius, $unit, $options);
    }
}


class Client
{
    public static function main()
    {
        $geo = new Geo();

        $geo->addElement('116.28', '39.55', 'beijing');
        $geo->addElement('117.12', '39.08', 'tianjin');
        $geo->addElement('114.29', '38.02', 'shijiazhuang');
        $geo->addElement('118.01', '39.38', 'tangshan');
        $geo->addElement('115.29', '38.51', 'baoding');

        $position = $geo->geoPos('beijing');

        $distance = $geo->geoDist('beijing', 'tianjin');

        $members1 = $geo->geoRadius('116.28', '39.55', 100, 'km');

        $members2 = $geo->geoRadiusByMember('beijing', 100, 'km');

        var_dump(compact('position', 'distance', 'members1', 'members2'));
    }
}

Client::main();







































