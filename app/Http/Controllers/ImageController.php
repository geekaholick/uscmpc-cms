<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController
{
    /**
     * Save the image in the public path and returns the image name
     * @param Request $request
     * @return string $name
     */
    public function saveImageAndGetImageName(Request $request) {
        $name = null;
        if ($request->image && gettype($request->image) != 'string') {
            $extension = $request->image->clientExtension();
            $name = time() . '.' . $extension;
            $destination = public_path('investment_images/'. $request->id);
            $request->image->move($destination, $name);
        }
        return $name;
    }
}
