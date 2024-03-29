<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
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
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'type' => $this->type,
            'active' => $this->active,
            'photo' => $this->photo,
            'nif' => $this->nif,
            'balance'=> $this->wallet ?  ($this->wallet->balance != 0 ? 'Has Money' : 'Empty') : '',
        ];
    }
}
