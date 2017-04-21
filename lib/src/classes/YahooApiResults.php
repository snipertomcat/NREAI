<?php


class YahooApiResults
{

    public function __construct($data=[])
    {
        foreach ($data as $key=>$val) {
            $key = lcfirst($key);
            $this->$key = $val;
        }
    }

    public function serialize()
    {
        return json_encode([
            'lastTradeDate' => $this->lastTradeDate,
            'lastTradeTime' => $this->lastTradeTime,
            'lastTradePriceOnly' => $this->lastTradePriceOnly
        ]);
    }

    public function unserialize()
    {
        return json_decode([
            'lastTradeDate' => $this->lastTradeDate,
            'lastTradeTime' => $this->lastTradeTime,
            'lastTradePriceOnly' => $this->lastTradePriceOnly
        ]);
    }

    public function __set($name, $value)
    {
        $name = lcfirst($name);
        $this->$name = $value;
        return $this;
    }

    public function __get($name)
    {
        $name = lcfirst($name);
        if (isset($this->$name)) {
            return $this->$name;
        }
    }
}