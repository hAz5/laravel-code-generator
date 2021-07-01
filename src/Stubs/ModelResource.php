<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class {{studlyModelName}}Resource extends JsonResource
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
              {{fields}}

//            'country' => $this->whenLoaded(
//                'country',
//                function () {
//                    return new CountryResource($this->country);
//                }
//            ),
        ];
    }
}
