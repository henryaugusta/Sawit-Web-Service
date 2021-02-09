<?php

namespace App\Http\Resources;

use App\Models\SellRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    protected $status_text = "";
    protected $sellRequest = null;
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $status = $this->status;
        switch ($status) {
            case 1:
                $this->status_text = "Active";
                break;
            case 0:
                $this->status_text = "Suspended";
                break;
            default:
                $this->status_text = "Blocked";
        }

        $sr = SellRequest::all();
        $sellRequest = RequestSellResource::collection($sr);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sell_request' => $this->sellRequest,
        ];
    }
}
