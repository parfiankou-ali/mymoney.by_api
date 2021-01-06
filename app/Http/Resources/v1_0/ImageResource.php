<?php

namespace App\Http\Resources\v1_0;

use App\Http\Enums\ImageSize;
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
        return [
            //
        ];
    }

    protected function getReplicasLinks()
    {
        return [
            //
        ];
    }

    protected function getOriginalImageLink()
    {
        return "";
    }







    private function makeImageUrl(int $id, string $size, string $extension): string
    {
        return selfUrl("images/users/${id}/${size}.${extension}");
    }

    private function getImageSizes()
    {
        $sizes = computeImageMaxSizes($this->origin_width, $this->origin_height);
        $buffer = [];

        foreach ($sizes as $size) {
            $buffer['minified'][$size] = $this->makeImageUrl($this->id, $size, $this->extension);
        }

        $buffer['square'] = [
            64 => $this->makeImageUrl($this->id, ImageSize::SQUARE_64, $this->extension),
            128 => $this->makeImageUrl($this->id, ImageSize::SQUARE_128, $this->extension),
        ];

        $buffer['origin'] = $this->makeImageUrl($this->id, ImageSize::ORIGIN, $this->extension);

        return $buffer;
    }
}
