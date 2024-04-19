<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SplFileObject;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Validation\Rule;

class CsvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $areas = Area::all();
        $area_ids = $areas->pluck('id')->toArray();
        $genres = Genre::all();
        $genre_ids = $genres->pluck('id')->toArray();

        return [
            "csv_file" => ['required', 'file', 'mimes:csv,txt'],
            'csv_array' => ['required', 'array'],
            'csv_array.*.area_id' => ['required', 'integer', Rule::in($area_ids)],
            'csv_array.*.genre_id' => ['required', 'integer', Rule::in($genre_ids)],
            'csv_array.*.shop_name' => ['required', 'string', 'max:50'],
            'csv_array.*.shop_photo' => ['required'],
            'csv_array.*.shop_comment' => ['required', 'string', 'max:400'],
        ];
    }

    protected function prepareForValidation()
    {
        if($this->file('csv_file') !== null){
            $file_path = $this->file('csv_file')->path();
            // CSV取得
            $file = new SplFileObject($file_path);
            $file->setFlags(
                SplFileObject::READ_CSV |         // CSVとして行を読み込み
                SplFileObject::READ_AHEAD |       // 先読み／巻き戻しで読み込み
                SplFileObject::SKIP_EMPTY |       // 空行を読み飛ばす
                SplFileObject::DROP_NEW_LINE      // 行末の改行を読み飛ばす
            );
            foreach ($file as $index => $line) {
                // ヘッダーを取得
                if (empty($header)) {
                    $header = $line;
                    continue;
                }
                $csv_array[$index]['area_id'] = (int)$line[0];
                $csv_array[$index]['genre_id'] = (int)$line[1];
                $csv_array[$index]['shop_name'] = $line[2];
                $csv_array[$index]['shop_photo'] = $line[3];
                $csv_array[$index]['shop_comment'] = $line[4];
            }
            $this->merge([
                'csv_array' => $csv_array,     //requestに項目追加
            ]);
        }
    }
    public function messages()
    {
        return [
            'csv_file.required' => 'ファイルを選択してください',
            'csv_file.file' => 'ファイルを選択してください',
            'csv_File.mimes' => 'csvファイルを選択してください',
            'csv_array.required' =>'CSVファイルは正しい形式で入力してください',
            'csv_array.array' =>'CSVファイルは正しい形式で入力してください',

            'csv_array.*.shop_comment.required' => '店舗概要が記入されていません',
            'csv_array.*.shop_photo.mimes' => 'JPEGまたはPNG形式の画像を入力してください'
        ];
    }
}
