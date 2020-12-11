<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'uuid' => $this->uuid,
            'url' => $this->url,
            'email' => $this->email,
            'logo' => $this->logo ? config('application.app_url') . "/storage/{$this->logo}" : '',
            'date_created' => Carbon::parse($this->created_at)->format('d/m/Y')
        ];
    }
}
