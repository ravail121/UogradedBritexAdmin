{{-- {{ dd($bizVerification) }} --}}

{{-- {{ $bizVerification->links() }} --}}

@foreach($details as $key => $order)
{{ $order->id }}
{{ $order->created_at_formatted }}
@endforeach
{{ $details->links() }}
