<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function store(Request $request, MembershipTransaction $transaction): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
            'method' => ['required', Rule::in(['Cash', 'Bank Transfer', 'GCash', 'Card'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if (round((float) $data['amount'], 2) !== round((float) $transaction->amount, 2)) {
            return back()
                ->withErrors(['amount' => 'Payment amount must match the transaction amount.'])
                ->withInput();
        }

        DB::transaction(function () use ($data, $transaction): void {
            $lockedTransaction = MembershipTransaction::query()
                ->lockForUpdate()
                ->findOrFail($transaction->id);

            abort_unless(
                $lockedTransaction->status === 'Pending',
                422,
                'Only pending transactions can receive a payment.'
            );

            do {
                $paymentReference = 'PAY-' . Str::upper(Str::random(10));
            } while (Payment::where('payment_reference', $paymentReference)->exists());

            $lockedTransaction->payments()->create([
                'payment_reference' => $paymentReference,
                'amount' => $data['amount'],
                'method' => $data['method'],
                'paid_at' => now(),
                'notes' => $data['notes'] ?? null,
            ]);

            $lockedTransaction->update(['status' => 'Paid']);
        });

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Payment recorded. The transaction can now be approved.');
    }
}

