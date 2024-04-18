<div class="shop-all__wrapper">
    <form class="search-bar" action="/search" method="post">
    @csrf
        <select class="sort" name="sort">
            <option value="">並び替え：評価高/低</option>
            <option value="random">ランダム</option>
            <option value="ratingDesc">評価が高い順</option>
            <option value="ratingAsc">評価が低い順</option>
        </select>

        <div class="search-form">
            <div class="search-form__area">
                <select class="search__area" name="shop_area">
                    <option value="">All area</option>
                    @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->shop_area }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__genre">
                <select class="search__genre" name="shop_genre">
                    <option value="">All genre</option>
                    @foreach($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->shop_genre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__keyword">
                <input class="search__key" type="text" name="keyword" placeholder="Search..." id="keyword">
            </div>
        </div>
        <div class="search__btn-wrapper">
            <button class="search__btn" type="submit">Search</button>
        </div>
    </form>
</div>