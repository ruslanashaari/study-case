<?php

namespace App\Http\Resources;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'created_at'    => (is_null($this->created_at)) ? '' : $this->created_at->format('d-m-Y H:i'),
            'deleted_at'    => $this->deleted_at,
            'address'       => $this->address ? new AddressResource($this->address) : ''
        ];
    }
}
