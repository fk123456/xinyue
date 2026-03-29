<?php

namespace app\model;

use app\model\QfShop;
use think\facade\Db;

class Stat extends QfShop
{
    protected $pk = 'id';

    protected $autoWriteTimestamp = true;

    /**
     * 自增搜索计数
     */
    public static function incSearch()
    {
        self::incField('search_count');
    }

    /**
     * 自增转存计数
     */
    public static function incTransfer()
    {
        self::incField('transfer_count');
    }

    /**
     * 自增指定字段
     */
    private static function incField(string $field)
    {
        $today = date('Y-m-d');
        $now = time();

        $exists = Db::name('stat')->where('date', $today)->find();
        if ($exists) {
            Db::name('stat')->where('date', $today)->inc($field)->update(['update_time' => $now]);
        } else {
            Db::name('stat')->insert([
                'date' => $today,
                $field => 1,
                'create_time' => $now,
                'update_time' => $now,
            ]);
        }
    }

    /**
     * 获取统计数据
     */
    public static function getStats(): array
    {
        $today = date('Y-m-d');

        $todayRow = Db::name('stat')->where('date', $today)->find();

        $totals = Db::name('stat')->field('SUM(search_count) as total_search, SUM(transfer_count) as total_transfer')->find();

        return [
            'today_search'   => $todayRow ? (int)$todayRow['search_count'] : 0,
            'total_search'   => (int)($totals['total_search'] ?? 0),
            'today_transfer' => $todayRow ? (int)$todayRow['transfer_count'] : 0,
            'total_transfer' => (int)($totals['total_transfer'] ?? 0),
        ];
    }
}
