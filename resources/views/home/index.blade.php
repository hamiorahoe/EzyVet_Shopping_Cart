@extends("_shared.layout")
@section("content")
    @if($message = \Illuminate\Support\Facades\Session::pull('msg'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <strong>{{$message}}</strong>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-12 py-2 px-4 bg-light">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 px-0">
                            <div class="card rounded-0 my-0 mx-0 text-center p-2">
                                <img class="card-img-top rounded" src="{{url($product["image"])}}" alt="">
                                <div class="card-content">
                                        <h5 class="card-title">{{$product["name"]}}</h5>
                                        <p class="card-text">${{number_format($product["price"], 2, ".","")}}</p>
                                        <form method="POST" action="{{route('cart.addItem')}}" >
                                            @csrf
                                            <input type="hidden" name="id" value="{{$product["id"]}}">
                                            <input type="hidden" name="name" value="{{$product["name"]}}">
                                            <input type="hidden" name="price" value="{{$product["price"]}}">
                                            <input type="hidden" name="image" value="{{url($product["image"])}}">
                                            <input type="submit" class="btn btn-success" value="Add To Cart">
                                        </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="sidebar col-lg-4 col-md-12 bg-info">
                <div class="row pt-3">
                    <div  class="col text-center text-white">
                        <h2>Shopping Cart <span class="fas fa-shopping-cart"></span></h2>
                    </div>
                </div>
                @isset($cartItems)
                <div class="row">
                    <div class="col jumbotron bg-white m-3 py-2">
                            <div class="row border-bottom">
                                <div class="col-2">
                                </div>
                                <div class="col-4">
                                    <h5>Item</h5>
                                </div>
                                <div class="col-2">
                                    <h5>Price</h5>
                                </div>
                                <div class="col-2">
                                    <h5>Qty</h5>
                                </div>
                                <div class="col-2">
                                    <h5>Total</h5>
                                </div>
                            </div>
                        @php($total = 0)
                        @foreach($cartItems as $item)
                                <div class="row border-bottom py-2 my-3 text-dark ">
                                    <div class="col-2">
                                        <img class="cart-img" src="{{url($item["image"])}}" alt="">
                                    </div>
                                    <div class="col-4 font-weight-bold">
                                        {{$item['name']}}
                                    </div>
                                    <div class="col-2">
                                        ${{number_format($item["price"], 2, ".","")}}
                                    </div>
                                    <div class="col-2">
                                        {{$item["qty"]}}
                                        <a href="{{route('cart.minusQty', ['id' => $item['id']])}}"><i class="fa fa-minus"></i></a>
                                        <a href="{{route('cart.addQty', ['id' => $item['id']])}}"><i class="fa fa-plus"></i></a>
                                    </div>
                                    <div class="col-2">
                                        ${{number_format(((double)$item["price"]*(int)$item['qty']), 2, ".","")}}
                                        <a href="{{route('cart.removeItem', ['id' => $item['id']])}}"><i class="float-right fa fa-times"></i></a>
                                    </div>
                                </div>

                        @endforeach
                            <div class="row py-2 font-weight-bold">
                                <div class="col-10">
                                    <h5>Total</h5>
                                </div>
                                <div class="col-2">
                                    ${{number_format($cartTotal, 2, ".","")}}
                                </div>
                            </div>
                            <div class="row">
                                <a href="#" class="btn btn-info w-100"> Proceed To Checkout</a>
                            </div>
                        </div>
                    </div>
                    @endisset

            </div>
        </div>
    </div>
@endsection
