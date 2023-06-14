<?php


namespace App\Tripscon\Services\TripOperator;


use App\Tripscon\Interfaces\iTripOperatorService;
use Illuminate\Http\Request;


class TripOperatorServices
{

    /**
     * @Description Create or update
     * @param iTripOperatorService $iTripOperatorService
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function createOrUpdate(iTripOperatorService $iTripOperatorService, Request $request)
    {
        return $iTripOperatorService->createOrUpdate($request);
    }

    /**
     * @Description Get All Trips
     * @param iTripOperatorService $iTripOperatorService
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getAll(iTripOperatorService $iTripOperatorService)
    {
        return $iTripOperatorService->getAll();
    }

    /**
     * @Description Delete image
     * @param iTripOperatorService $iTripOperatorService
     * @param Request $request
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function deleteImage(iTripOperatorService $iTripOperatorService, Request $request)
    {
        return $iTripOperatorService->deleteImage($request);
    }

    /**
     * @Description Get Images
     * @param iTripOperatorService $iTripOperatorService
     * @param $id
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function getImages(iTripOperatorService $iTripOperatorService, $id)
    {
        return $iTripOperatorService->getAllImages($id);
    }

    /**
     * @Description Delete Trip
     * @param iTripOperatorService $iTripOperatorService
     * @param $id
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public static function deleteTrip(iTripOperatorService $iTripOperatorService, $id)
    {
        return $iTripOperatorService->delete($id);
    }

}
