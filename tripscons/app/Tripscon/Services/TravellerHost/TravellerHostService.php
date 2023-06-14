<?php


namespace App\Tripscon\Services\TravellerHost;


use App\Tripscon\Interfaces\iHostService;
use Illuminate\Http\Request;

class TravellerHostService
{
    /**
     * @Description Create Or Update Record
     *
     * @param iHostService $iHostService
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function createOrUpdate(iHostService $iHostService, Request $request)
    {
        return $iHostService->createOrUpdate($request);
    }

    /**
     * @Description Upload Image
     *
     * @param iHostService $iHostService
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function uploadImage(iHostService $iHostService, Request $request)
    {
        return $iHostService->uploadImage($request);
    }

    /**
     * @Description Get All Record.
     *
     * @param iHostService $iHostService
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAll(iHostService $iHostService)
    {
        return $iHostService->getAll();
    }

    /**
     * @Description Get All images of signal record.
     *
     * @param iHostService $iHostService
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function getAllImages(iHostService $iHostService, $id)
    {
        return $iHostService->getAllImages($id);
    }

    /**
     * @Description Make One Image primary.
     *
     * @param iHostService $iHostService
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function makePrimaryImage(iHostService $iHostService, Request $request)
    {
        return $iHostService->makePrimaryImage($request);
    }

    /**
     * @Description Delete One Image
     *
     * @param iHostService $iHostService
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function deleteImage(iHostService $iHostService, Request $request)
    {
        return $iHostService->deleteImage($request);
    }

    /**
     * @Description Delete Record
     *
     * @param iHostService $iHostService
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public static function delete(iHostService $iHostService, $id)
    {
        return $iHostService->delete($id);
    }


}
