<?php

namespace Hejiang\Express;

use yii\base\ArrayAccessTrait;


class Traces extends \yii\base\BaseObject implements \JsonSerializable, \IteratorAggregate, \Countable, \ArrayAccess
{
    use ArrayAccessTrait;
    
    protected const DATETIME = 'time';
    protected const DESCRIPTION = 'desc';
    protected const MEMO = 'memo';

    protected $data = [];

    public function append($dateTime, $description, $memo = '')
    {
        $this->data[] = [static::DATETIME => $dateTime, static::DESCRIPTION => $description, static::MEMO => $memo];
    }

    public function toArray()
    {
        usort($this->data, function ($left, $right) {
            if ($left[static::DATETIME] == $right[static::DATETIME]) {
                return 0;
            }
            return $left[static::DATETIME] < $right[static::DATETIME] ? 1 : 0; // 倒序
        });
        return $this->data;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }
}