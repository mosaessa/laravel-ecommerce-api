<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->id,
            'quantity' => (string) $transaction->quantity,
            'buyer' => (string) $transaction->buyer_id,
            'product' => $transaction->product_id,
            'creationDate' => $transaction->created_at,
            'lastUpdatenDate' => $transaction->updated_at,
            'deleteDate' => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null
        ];
    }
}
