<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        if ($request->hasFile('csvFile')) {
            $file = $request->file('csvFile');
            $path = $file->getRealPath();

            $fp = fopen($path, 'r');
            fgetcsv($fp);
            while (($csvData = fgetcsv($fp)) !== FALSE) {
                $this->InsertCsvData($csvData);
            }
            fclose($fp);
            return redirect('/csv_upload')->with('result', '店舗情報を追加しました');
        } else {
            throw new \Exception('CSVファイルが取得できませんでした。');
        }
    }

    public function InsertCsvData($csvData)
    {
        if (count($csvData) < 5) {
            throw new \Exception('CSVデータの形式が正しくありません。');
        }
        $shop = new Shop;
        $shop->area_id = $csvData[0];
        $shop->genre_id = $csvData[1];
        $shop->shop_name = $csvData[2];
        $shop->shop_photo = $csvData[3];
        $shop->shop_comment = $csvData[4];
        $shop->save();
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
                throw new \Exception("ディレクトリを作成できません。");
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
