<p>Dear {{ $billing->user->name }},</p>
<p>Your payment of ${{ $billing->total_amount }} has been processed.</p>
<p>Payment Method: {{ $billing->payment_method }}</p>
<p>Details:</p>
<ul>
    <li>Restaurant: ${{ $billing->restaurant_charges }}</li>
    <li>Room Service: ${{ $billing->room_service_charges }}</li>
    <li>Laundry: ${{ $billing->laundry_charges }}</li>
    <li>Telephone: ${{ $billing->telephone_charges }}</li>
    <li>Club Facility: ${{ $billing->club_facility_charges }}</li>
</ul>
<p>Thank you for staying with us!</p>