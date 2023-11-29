<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        $gallery = [];
//        foreach($this->images as $image){
//            $gallery[] = env('APP_URL') . $image->path;
//        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'picture' => ($this->picture == null) ? 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png' : env('APP_URL') . $this->picture,
            'address' => $this->address,
            'blocked' => $this->blocked,
            'role_id' => $this->role_id,
            'role_name' => optional($this->role)->name ?? 'N/A',
            'api_token' => $this->api_token,
            'credits' => $this->listing_credits,
            'favorite' => $this->favorite
        ];

    }
}
