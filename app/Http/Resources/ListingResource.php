<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $gallery = [];
        foreach($this->galleries as $image){
            $gallery[] = env('APP_URL') . $image->path;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'type_id' => $this->type_id,
            'type_name' => $this->type->name,
            'price' => $this->price,
            'area' => $this->area,
            'no_of_room' => $this->no_of_room,
            'no_of_bed' => $this->no_of_bed,
            'no_of_bath' => $this->no_of_bath,
            'image' => env('APP_URL') . $this->image,
            'city' => $this->city,
            'address' => $this->location,
            'description' => $this->description,
            'latitude' => $this->lat,
            'longitude' => $this->lng,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gallery' => $gallery,
            'author' => $this->user
        ];

    }
}
