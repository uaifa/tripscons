<?php

namespace App\Tripscon\Interfaces;

use Illuminate\Http\Request;

interface iInquiry
{

    /**
     * @Description Save Request
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function save(Request $request);

    /**
     * @Description Update Record
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function update(Request $request);

    /**
     * @Description Delete Record
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function delete($id);

    /**
     * @Description Get All
     *
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function getAll();

    /**
     * @Description Get Record By Primary Id
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getById($id);

}
