<div class="row py-2 px-1" id="products">
    @foreach ($products as $item)
    <div class="col-xl-2 col-lg-3 col-md-4">
        <div class="card cursor-pointer" v-on:click="add({{ $item->id }})" style="height: 220px">
            <div class="card-content h-100">
                <div style="background-image: url('{{ asset($item->first_image->src) }}'); background-size: 
                    cover; height: 60%; background-position: center; background-repeat: no-repeat;">
                    <div class="heading-elements">
                        <span class="float-right badge badge-primary">Disponible: {{ $item->stock }}</span>
                    </div>
                </div>
                <div class="p-1" style="height: 40%">
                    <h6 class="card-title mb-0">{{ $item->name }}</h6>
                    <h6 class="text-primary">${{ number_format($item->first_price->price, 2) }}</h6>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="px-1">{{ $products->links() }}</div>
