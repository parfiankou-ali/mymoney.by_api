<?php

namespace App\Http\Resources\v1_0;

use App\Http\Enums\ImageSize;
use App\Storage\File;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'id' => $this->id,
            'original_width' => $this->original_width,
            'original_height' => $this->original_height,
            'links' => [
                'square' => $this->getSquareImageLinks(),
                'replicas' => $this->getReplicasLinks(),
                'original' => $this->getOriginalImageLink()
            ],
        ];
    }

    protected function getSquareImageLinks()
    {
        return (object) [
            ImageSize::MAX_128 => $this->getImageLink(ImageSize::SQUARE_128),
        ];
    }

    protected function getReplicasLinks()
    {
        $replicaSizes = File::getAvailableImageReplicaSizesByDimensions($this->original_width, $this->original_height);
        $replicas = [];

        foreach ($replicaSizes as $replicaSize) {
            $replicas[$replicaSize] = $this->getImageLink($replicaSize);
        }

        return (object) $replicas;
    }

    protected function getOriginalImageLink()
    {
        return $this->getImageLink(ImageSize::ORIGINAL);
    }

    protected function getImageLink(string $size): string
    {
        return route('image.get', [
            'id' => $this->id,
            'size' => $size,
        ]);
    }
}
