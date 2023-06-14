<?php

namespace App\Tripscon\Interfaces;

use Illuminate\Http\Request;

interface iHostService
{
    /**
     * @Description Create or Update
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function createOrUpdate(Request $request);

    /**
     * @Description Upload Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function uploadImage(Request $request);

    /**
     * @Description Get All Record
     *
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getAll();

    /**
     * @Description Get All Images of single record
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getAllImages($id);

    /**
     * @Description Make Primary Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function makePrimaryImage(Request $request);

    /**
     * @Description Delete Image
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function deleteImage(Request $request);

    /**
     * @Description delete record
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function delete($id);
}
