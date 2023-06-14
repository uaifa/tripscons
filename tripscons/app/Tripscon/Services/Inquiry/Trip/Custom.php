<?php
namespace App\Tripscon\Services\Inquiry\Trip;

use App\Tripscon\Interfaces\iInquiry;
use App\Tripscon\Interfaces\Request;

class Custom implements iInquiry{


    /**
     * @Description Save Request
     * @param \Illuminate\Http\Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function save(\Illuminate\Http\Request $request)
    {
        // TODO: Implement save() method.
    }

    /**
     * @Description Update Record
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function update(\Illuminate\Http\Request $request)
    {
        // TODO: Implement update() method.
    }

    /**
     * @Description Delete Record
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @Description Get All
     *
     * @return mixed
     * @Author Khuram Qadeer.
     */
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @Description Get Record By Primary Id
     *
     * @param $id
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function getById($id)
    {
        // TODO: Implement getById() method.
    }
}
