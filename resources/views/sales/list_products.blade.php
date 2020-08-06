<div class="row py-2 px-1" id="products">
    @foreach ($products as $item)
    <div class="col-md-2">
        <div class="card cursor-pointer" onclick="add({{ $item->id }})" style="height: 200px">
            <div class="card-content h-100">
                <div style="background-image: url('{{ asset($item->first_image->src) }}'); background-size: 
                    cover; height: 60%; background-position: center; background-repeat: no-repeat;">
                </div>
                <div class="card-body" style="height: 40%">
                    <h6 class="card-text">{{ $item->name }}</h6>
                    <h6 class="card-text">${{ number_format($item->first_price->price, 2) }}</h6>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="px-1">{{ $products->links() }}</div>
