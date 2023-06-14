<?php


namespace App\Tripscon\Services\Inquiry\HostServices;


use App\Inquiry;
use App\Tripscon\Interfaces\iInquiry;
use App\User;
use App\UserMeal;
use Illuminate\Http\Request;

class Meal implements iInquiry
{

    /**
     * @Description Save Request
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function save(Request $request)
    {
        $msg = 'Unprocessable Entity.';
        $status = 422;
        $meal = UserMeal::find($request->ref_id);
        if ($meal) {
            $user = User::find($meal->user_id);
            if ($user) {
                $inquiry = Inquiry::create($request->all());
                if ($inquiry) {
                    $msg = 'Inquiry Created Successfully';
                    $status = 200;
                    $inquiry->update([
                        'service_provider_id' => $user->id,
                        'service_provider_name' => $user->name,
                        'active' => 1
                    ]);
                }
            }
        }
        return response()->json(['message' => $msg], $status);
    }

    /**
     * @Description Update Record
     *
     * @param Request $request
     * @return mixed
     *
     * @Author Khuram Qadeer.
     */
    public function update(Request $request)
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
