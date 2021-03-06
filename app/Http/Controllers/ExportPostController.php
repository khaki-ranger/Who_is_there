<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ExportPostController extends Controller
{
    // IFTTTに来訪者通知をPOSTする
    // $push_users = array( "id" => $user->id, "name" => $user->name)
    public function push_ifttt($push_users, $category)
    {
        // 訪問者の名前と滞在中のおおよその人数を抽出、文字列を作成する
        $res = $this->stay_users_about_count($push_users);
        // $res['users_count_str'] => "〇~〇（人）",
        // $res['users_name_str'] => "Aさん Bさん ...",

        // 通知の種別設定
        switch ($category) {
            case 'arraival':
                $event_name = env("IFTTT_WEB_HOOKS_EVENT_ARRAIVAL");
                break;
            case 'departure':
                $event_name = env("IFTTT_WEB_HOOKS_EVENT_DEPARTURE");
                break;
            default:
                $event_name = "";
                break;
        }
        // urlの生成とIFTTTへPOST(GuzzleHttpを使用)
        $url1 = 'https://maker.ifttt.com/trigger/';
        $url2 = '/with/key/';
        $url = $url1 . $event_name . $url2;
        $key = env("IFTTT_WEB_HOOKS_KEY");
        $client = new \GuzzleHttp\Client([
            'base_uri' => $url,
        ]);
        $responce = $client->request('POST', $key, [
            'json' => [
                'value1' => $res['users_name_str'],
                'value2' => $res['users_count_str'],
                'value3' => "",
            ],
            ["timeout" => 10],
            ["delay" => 2000.0]
        ]);
    }


    // 訪問者の名前と滞在中のおおよその人数を抽出、文字列を作成する
    // $push_users = array( "id" => $user->id, "name" => $user->name)
    public function stay_users_about_count($push_users)
    {
        // "Aさん Bさん ..."の文字列作成
        $users_name_str = "";
        foreach ((array)$push_users as $user) {
            $users_name_str .= "(ID:". $user['id'] . ")『" . $user['name'] . "』さん ";
        }

        // 管理user以外の既存user滞在者数
        $existing_count = DB::table('mac_addresses')
            ->distinct()->select('user_id')
            ->where([
                ['user_id','<>', 1],
                ['current_stay', 1],
                ['hide', 0],
            ])->get();
        $existing_count = $existing_count->count();

        // 管理user id=1 に紐づいた滞在中のデバイス数
        $unknown_count = DB::table('mac_addresses')
            ->where([
                ['current_stay', 1],
                ['hide', 0],
                ['user_id', 1],
            ])
            ->count();
        // 想定される最大滞在者数
        $about_max = $existing_count + $unknown_count;
        // "〇～〇" 名の文字列作成
        if ($unknown_count > 0) {
            $users_count_str = $existing_count . "～" . $about_max;
        } else {
            $users_count_str = $existing_count;
        }
        return array(
            'users_count_str' => $users_count_str,
            'users_name_str' => $users_name_str,
        );
    }

    // ***ToDo*** vendorが未登録なら MACアドレスから スクレイピングでメーカー名を自動登録させる処理を書く

}
