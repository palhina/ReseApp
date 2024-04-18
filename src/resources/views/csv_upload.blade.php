@if (session('result'))
    <div class="flash_message">
        {{ session('result') }}
    </div>
@endif

<form method="post" action="/csv_upload" enctype="multipart/form-data">
    @csrf
    <label name="csvFile">csvファイル</label>
    <input type="file" name="csvFile" class="" id="csvFile"/>
    <input type="submit"></input>
</form>
<form method="post" action="/csv_export">
    @csrf
    <input type="submit" value="テンプレートのダウンロード"></input>
</form>