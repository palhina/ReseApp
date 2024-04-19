<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CsvRequest;
use App\Models\Shop;

class CsvController extends Controller
{

    // CSVインポート画面表示
    public function csvUpload()
    {
        return view('csv_upload');
    }

    // CSVインポート処理
    public function importCsv(CsvRequest $request)
    {
        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $fp = fopen($path, 'r');
        fgetcsv($fp);
        while (($csvData = fgetcsv($fp)) !== FALSE) {
            $this->InsertCsvData($csvData);
        }
        fclose($fp);
        return redirect('/csv_upload')->with('result', '店舗情報を追加しました');
    }

    public function InsertCsvData($csvData)
    {
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
        }
        $name = 'shop.csv';
        $pathToFile = storage_path('csv/' . $name);

        return response()->download($pathToFile, $name)->deleteFileAfterSend(true);
    }
}
