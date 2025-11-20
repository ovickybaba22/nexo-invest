<x-mail::message>
# Withdrawal status updated

Hi {{ $withdrawal->user->name ?? 'there' }},

Your withdrawal request has been **{{ ucfirst($withdrawal->status) }}**.

**Amount:** ${{ number_format($withdrawal->amount_cents / 100, 2) }}  
**Method:** {{ $withdrawal->method ?? '—' }}  
**Requested on:** {{ $withdrawal->created_at->format('Y-m-d H:i') }}

@if($withdrawal->status === 'approved')
Your payout is now queued for processing. Funds will be sent to your selected payout method.
@elseif($withdrawal->status === 'rejected')
Unfortunately this request was rejected. If you have any questions, please contact our support team.
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
