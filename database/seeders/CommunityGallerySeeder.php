<?php

namespace Database\Seeders;

use App\Models\CommunityGallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CommunityGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folder = '/community_gallery';

        $image_arr = [];
        $images = File::allFiles(public_path($folder));

        foreach ($images as $path) {
            $files = pathinfo($path);
            $image_arr[] = $files['basename'];
        }

        foreach ($image_arr as $image) {

            $data = getimagesize(public_path($folder . '/'.$image));
            $width = $data[0];
            $height = $data[1];
            CommunityGallery::create([
                'ward_id' => 5872,
                'leader_id' => 11,
                'path' => $folder . '/' .$image,
                'width' => $width,
                'height' => $height,
            ]);
        }
    }
}
