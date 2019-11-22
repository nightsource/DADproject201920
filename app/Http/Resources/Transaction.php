<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Transaction extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wallet_id' => $this->wallet_id,
            'type' => $this->type,
            'transfer_movement_id' => $this->transfer_movement_id,
            'transfer_wallet_id' => $this->transfer_wallet_id,
            'type_payment' => $this->type_payment,
            'category_id' => $this->category_id,
            'iban' => $this->iban,
            'mb_entity_code' => $this->mb_entity_code,
            'mb_payment_reference' => $this->mb_payment_reference,
            'description' => $this->description,
            'source_description' => $this->source_description,
            'date' => $this->date,
            'start_balance' => $this->start_balance,
            'end_balance' => $this->end_balance,
            'value' => $this->value,
        ];
    }
}
