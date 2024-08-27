<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "ruc" => $this->resource->ruc,
            "business_name" => $this->resource->business_name,
            "address" => $this->resource->address,
            "manager" => $this->resource->manager,
            "phone" => $this->resource->phone,
            "email" => $this->resource->email,
            "user_register" => $this->resource->user_register,
            "user_update" => $this->resource->user_update,
            "avatar" => env("APP_URL")."storage/".$this->resource->avatar,
            "estate" => $this->resource->estate,
            "created_at" => $this->resource->created_at->format("Y/m/d"),
        ];
    }
}
