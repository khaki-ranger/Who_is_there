<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTable extends Model
{
    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'users';

    // 日時表記変更の ->format('Y-m-d') を使いたいカラム名を指定する
    protected $dates = [
        'last_access',
        'created_at',
        'updated_at',
    ];

    public function mac_addresses()
    {
        return $this->hasMany('App\MacAddress', 'user_id')->orderBy('arraival_at', 'desc');
    }
}
