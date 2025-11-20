@component('mail::message')
# Deposit completed

Hi {{ optional($deposit->user)->name ?? 'there' }},

We’ve received your crypto deposit and it has been **completed**.

@php
    $amount   = number_format(($deposit->amount_cents ?? 0) / 100, 2);
    $asset    = $deposit->asset ?? 'USDT';
    $balance  = number_format((optional($deposit->user)->wallet_balance ?? 0) / 100, 2);
@endphp

**Amount:** ${{ $amount }}  
**Asset:** {{ $asset }}  
**Status:** {{ ucfirst($deposit->status) }}

Your new wallet balance is **${{ $balance }}**.

@component('mail::button', ['url' => route('dashboard')])
View dashboard
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
