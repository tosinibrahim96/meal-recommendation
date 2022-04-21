<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'allergies' => AllergyResource::collection($this->allergies),
            'main_item' => count(MealItemResource::collection($this->mainItem)) > 0 ?
                MealItemResource::collection($this->mainItem)[0]:null,
            'side_items' => MealItemResource::collection($this->sideItems)
        ];
    }

}
