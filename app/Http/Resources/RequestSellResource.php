<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestSellResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $request->id,
            "user_id" => $request->user_id,
            "staff_id" => $request->staff_id,
            "est_weight" => $request->est_weight,
            "est_price" => $request->est_price,
            "est_margin" => $request->est_margin,
            "address" => $request->address,
            "lat" => $request->lat,
            "long" => $request->long,
            "contact" => $request->contact,
            "status" => $request->status,
            "file_name" => $request->file_name,
            "updated_by" => $request->updated_by,
            "created_at" => $request->created_at,
            "updated_at" => $request->updated_at
        ];
    }
}
