<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Tripscon\Interfaces\iHostService;
use App\Models\UserMeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Meal implements iHostService
{

    /**
     * @inheritDoc
     */
    public function createOrUpdate(Request $request)
    {
        $status = 422;
        $message = 'Unprocessable Entity';
        $request->validate([
            'menus' => 'required',
            'description' => 'required',
        ]);
        $userMeal = '';
        foreach ($request->menus as $menu) {

            $mealId = (int)$menu['meal_type']['id'];
            $id = (int)$menu['id'];

            if ($id) {
                UserMeal::find($id)->update([
                    'title' => $menu['title'],
                    'persons' => $menu['persons'],
                    'meal_id' => $mealId,
                    'price' => (int)$menu['price'],
                    'active' => true
                ]);
                // All Meals update
                UserMeal::whereUser_id(Auth::id())->update([
                    'description' => $request->description,
                    'rules' => $request->rules ? json_encode($request->rules) : '',
                    'video_url' => $request->video_url ? json_encode($request->video_url): null,
                ]);
                $userMeal = UserMeal::find($id);
                $status = 200;
                $message = 'Meal Updated Successfully';
            } else {
                $userMeal = UserMeal::create([
                    'user_id' => Auth::id(),
                    'title' => $menu['title'],
                    'persons' => $menu['persons'],
                    'meal_id' => $mealId,
                    'price' => (int)$menu['price'],
                    'active' => true
                ]);
                // All Meals update
                UserMeal::whereUser_id(Auth::id())->update([
                    'description' => $request->description,
                    'rules' => $request->rules ? json_encode($request->rules) : '',
                    'video_url' => $request->video_url ?? null,
                ]);
                $status = 200;
                $message = 'Meal Created Successfully.';
            }

            // Images Upload
            $allImages = [];
            $files = $menu['files'];

            if ($userMeal) {
                if ($userMeal->images) {
                    $images = json_decode($userMeal->images);
                    if ($images) {
                        foreach ($images as $image) {
                            array_push($allImages, $image);
                        }
                    }
                }
            }

            if ($files) {
                $dirPath = 'basic/images/meals/';
                foreach ($files as $file) {
                    if (!is_array($file)) {
                        $filename = Str::random(40) . '.png';
                        $imageInfo = explode(";base64,", $file);
                        $image = str_replace(' ', '+', $imageInfo[1]);
                        file_put_contents(public_path($dirPath . $filename), base64_decode($image));
                        array_push($allImages, [
                            'primary' => $allImages ? 0 : 1,
                            'fileName' => $filename,
                            'path' => $dirPath,
                            'url' => getDomainName() . '/' . $dirPath . $filename,
                            'mimeType' => 'png'
                        ]);
                    }
                }
            }
            if ($allImages) {
                $userMeal->update([
                    'images' => json_encode($allImages)
                ]);
            }
        }

        return response(['message' => $message, 'meal' => $userMeal], $status);
    }

    /**
     * @inheritDoc
     */
    public function uploadImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $file = $request['file'];
        $meal = UserMeal::find($id);
        if ($meal) {
            if ($meal->images) {
                $images = json_decode($meal->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }

        if ($file) {
            $dirPath = 'basic/images/meals/';
            $filename = Str::random(40) . '.png';
            Image::make($file)->save(public_path($dirPath . $filename));
            array_push($allImages, [
                'primary' => $allImages ? 0 : 1,
                'fileName' => $filename,
                'path' => $dirPath,
                'url' => getDomainName() . '/' . $dirPath . $filename,
                'mimeType' => 'png'
            ]);
        }
        if ($allImages) {
            $meal->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response()->json(['message' => 'Image Uploaded.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        $mealsName = [];
        $userMeals = UserMeal::getByUserId(Auth::id());
        foreach ($userMeals as $userMeal) {
            if (!in_array($userMeal['meal_name'], $mealsName)) {
                array_push($mealsName, $userMeal['meal_name']);
            }
        }
        return response(['allMeal' => $userMeals, 'meals_name' => $mealsName], 200);
    }

    /**
     * @inheritDoc
     */
    public function getAllImages($id)
    {
        $allImages = [];
        $meal = UserMeal::find($id);
        if ($meal) {
            if ($meal->images) {
                $images = json_decode($meal->images);
                if ($images) {
                    foreach ($images as $image) {
                        array_push($allImages, $image);
                    }
                }
            }
        }
        return response(['images' => $allImages], 200);
    }

    /**
     * @inheritDoc
     */
    public function makePrimaryImage(Request $request)
    {
        $allImages = [];
        $primary = null;
        $id = $request->id;
        $fileName = $request->fileName;
        $meal = UserMeal::find($id);
        if ($meal) {
            if ($meal->images) {
                $images = json_decode($meal->images);
                if ($images) {
                    foreach ($images as $image) {
                        if ($image->fileName == $fileName) {
                            $primary = 1;
                        } else {
                            $primary = 0;
                        }
                        array_push($allImages, [
                            'primary' => $primary,
                            'fileName' => $image->fileName,
                            'path' => $image->path,
                            'url' => $image->url,
                            'mimeType' => $image->mimeType
                        ]);
                    }
                }
            }
        }
        if ($allImages) {
            $meal->update([
                'images' => json_encode($allImages)
            ]);
        }
        return response()->json(['message' => 'Primary Image Selected.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function deleteImage(Request $request)
    {
        $allImages = [];
        $id = $request->id;
        $fileName = $request->fileName;
        $meal = UserMeal::find($id);
        if ($meal) {
            if ($meal->images) {
                $images = json_decode($meal->images);
                if ($images) {
                    foreach ($images as $image) {
                        if ($image->fileName == $fileName) {
                            deleteFile(json_encode($image));
                        } elseif ($image->fileName != $fileName) {
                            array_push($allImages, [
                                'primary' => isset($image->primary) ? $image->primary : 0,
                                'fileName' => $image->fileName,
                                'path' => $image->path,
                                'url' => $image->url,
                                'mimeType' => $image->mimeType
                            ]);
                        }
                    }
                }
            }
        }
        $meal->update([
            'images' => json_encode($allImages)
        ]);
        return response()->json(['message' => 'Image Delete Successfully.'], 200);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        UserMeal::find($id)->delete();
        return response()->json(['message' => 'Meal Deleted Successfully.'], 200);
    }
}
