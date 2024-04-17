<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

class CsvController extends Controller
{

    // CSVインポート画面表示
    public function csvUpload()
    {
        return view('csv_upload');
    }

    // CSVインポート処理
    public function importCsv(Request $request)
    {
        $file = $request->file('file');

        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $lexer = new Lexer($config);

        $config->setToCharset("UTF-8");
        $config->setFromCharset("sjis-win");
        $dataList = [];

        $interpreter->addObserver(function (array $row) use (&$dataList,$areaList, $genreList){

            $areaName = $row[0];
            $genreName = $row[1];
            $areaId = $areaList[$areaName];
            $genreId = $genreList[$genreName];
            Shop::insert([
                'area_id' => $areaId,
                'genre' => $genreId,
                'shop_name' => $row[2],
                'shop_photo' => $row[3],
                'shop_comment' => $row[4]
            ]);
        });
        return redirect('/csv_upload')->with('result', 'CSVデータを読み込みました');
    }

    // CSVテンプレートのダウンロード
    public function downloadCsv(): object
    {
        $csvHeader = ["地域", "ジャンル", "店舗名", "画像URL", "店舗概要"];
        $downloadData = implode(',', $csvHeader);
        $downloadData = mb_convert_encoding($downloadData, "SJIS", "UTF-8");

        if (! file_exists(storage_path('csv'))) {
            $bool = mkdir(storage_path('csv'));
            if (! $bool) {
                throw new \Exception("ディレクトリを作成できませんでした。");
            }
        }
        $name = 'shop.csv';
        $pathToFile = storage_path('csv/' . $name);

        if (! file_put_contents($pathToFile, $downloadData)) {
            throw new \Exception("ファイルの書き込みに失敗しました。"); 
        }

        return response()->download($pathToFile, $name)->deleteFileAfterSend(true);
    }
}
