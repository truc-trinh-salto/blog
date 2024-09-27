@php
    $total = 0;
    $cartSession = session('cart');
    $qtySession = session('qty_array');
@endphp 

@extends('layout.app')


@section('content')
    <form method="POST" action="/cart/updateCart">
        @csrf
		<table class="table table-bordered table-striped">
			<thead>
				<th></th>
				<th>{{ __('message._NAMEBOOK') }}</th>
				<th>{{ __('message._PRICE') }}</th>
				<th>{{ __('message._QUANTITY') }}</th>
				<th>{{ __('message._SUBTOTAL') }}</th>
			</thead>
			<tbody>
				
                @if(count($cartSession) > 0)
                    @foreach($carts as $row)
                        @php 
                            $index = array_search($row['book_id'],$cartSession)
                        @endphp
                        <tr>
							<td>
								<a href="/cart/removeFromCart?book_id={{ $row['book_id'] }}&index={{$index}}" class="btn btn-danger btn-sm">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
							</td>

							<td>{{$row['title']}}</td>
								<td>
									@if($row['sale'] && $row['sale'] != null && $row['sale'] != 0)
                                        <div class="row">
                                            <del class="col-md-12">{{ number_format($row['price'],2)}}</del>
                                            <span class="col-md-12 text-danger">-{{ $row['sale'] }}%</span>
                                            <span class="col-md-12 text-success">{{ number_format($row['price'] - $row['sale']*$row['price'] / 100,2) }}</span>
                                        </div>
                                    @else
                                        <span>{{ number_format($row['price'],2) }}</span>
                                    @endif
								</td>

								<input type="hidden" name="indexes[]" value="{{ $index }}">

								<td>
                                    <input type="text" class="form-control" value="{{ $qtySession[$index] }}" name="qty_{{ $index }}">
                                </td>

								<td>
									@if($row['sale'] && $row['sale'] != null && $row['sale'] != 0)
										{{ number_format($qtySession [$index]*($row['price'] - $row['sale']*$row['price'] / 100), 2)}}
                                    @else
                                        {{number_format($qtySession[$index]*$row['price'], 2)}}
                                    @endif
								</td>
								@php if($row['sale'] && $row['sale'] != null && $row['sale'] != 0){
											$total += $qtySession[$index]*($row['price'] - $row['sale']*$row['price'] / 100);
										} else {
											$total += $qtySession[$index]*$row['price'];
										} 
								@endphp
						</tr>

                    @endforeach
                @else 
                    <tr>
						<td colspan="4" class="text-center">{{ __('message._EMPTYCART') }}</td>
                    </tr>
                @endif
                
				<tr>
					<td colspan="4" align="right"><b>{{ __('message._TOTAL') }}</b></td>
					<td>
                        <b>{{ number_format($total, 2) }}</b>
                    </td>
				</tr>
			</tbody>
		</table>
		<a href="/home" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> {{ __('message._BACK') }}</a>
		<button type="submit" class="btn btn-success" name="save">{{ __('message._SAVE') }}</button>
		<a href="/cart/clearCart" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>{{ __('message._CLEARCART') }}</a>
		<a href="{{ session('user_id') ? 'check_out' : 'login' }}" class="btn btn-success"><span class="glyphicon glyphicon-check"></span>{{ __('message._CHECKOUT') }}</a>
    </form>
@endsection