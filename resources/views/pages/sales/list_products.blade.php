<div class="row py-2 px-1">
    @foreach ($products as $item)
    <div class="col-xl-2 col-lg-3 col-md-4">
        <div class="card cursor-pointer" v-on:click="add({{ $item->id }})" style="height: 200px">
            <div class="card-content h-100">
                <div style="background-image: url('{{ asset($item->first_image->src) }}'); background-size: 
                    cover; height: 60%; background-position: center; background-repeat: no-repeat;">
                    <div class="heading-elements">
                        <div class="float-right badge badge-primary">Stock: {{ $item->stock }}</div>
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



