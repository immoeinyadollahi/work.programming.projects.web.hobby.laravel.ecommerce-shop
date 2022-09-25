@foreach ($products as $product)
    <div class="col-md-3 col-sm-6">
        <a href="/product/{{ $product->id }}/{{ $product->slug }}">
            <img src="{{ $product->profileImage->url }}" class="w-100" alt="{{ $product->name }}">
        </a>
        <p>{{ $product->name }}</p>
        <button class="btn btn-danger btn-block mt-3 js-compare-add-btn" data-id="{{ $product->id }}">
            <span class="fas fa-plus" style="font-size: 18px; color: white;"></span>
        </button>
    </div>
@endforeach
