<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function add(Request $req)
    {
        $merchantId = auth()->user()->merchant_id;

        $this->validate($req,[
            "name" => "required",
            "phone" => 'required|unique:users,phone',
            "password" => "required|min:8",
            "role" => 'required|in:staff,super',
        ]);

        if(auth()->user()->role == "super")
        {
            $user = new User();
            $user->name = $req->name;
            $user->phone = $req->phone;
            $user->password = bcrypt($req->password);
            $user->role = $req->role;
            $user->merchant_id = $merchantId;
            $user->save();
            return [
                "status" => "ok",
                "msg" => "User has been created successfully"
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "You are not permitted to do this. Access denied"
            ];
        }
    }

    public function getList()
    {
        $merchantId = auth()->user()->merchant_id;
        if(auth()->user()->role == "super")
        {
            $users = User::where('merchant_id', $merchantId)->orderBy("id","desc")->withCount("orders")->get();
            return [
                "status" => "ok",
                "users" => $users
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "You are not permitted to do this. Access denied"
            ];
        }
    }

    public function getUserDetails(Request $req)
    {
         $merchantId = auth()->user()->merchant_id;
        if(auth()->user()->role == "super" && $req->userId != "" && $user = User::where('merchant_id', $merchantId)->find($req->userId))
        {
            return [
                "status" => "ok",
                "user" => $user,
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "You are not permitted to do this. Access denied"
            ];
        }
    }

    public function update(Request $req)
    {

        $merchantId = auth()->user()->merchant_id;
        $this->validate($req,[
            "userid" => "required|numeric|exists:users,id",
            "name" => "required",
            "phone" => "required|unique:users,phone,$req->userid,id",
            "password" => "nullable|min:8",
            "role" => 'required|in:staff,super',
        ]);

        if(auth()->user()->role == "super")
        {
            $user = User::where('merchant_id', $merchantId)->find($req->userid);
            $user->name = $req->name;
            $user->phone = $req->phone;
            if($req->password != "")
            {
                $user->password = bcrypt($req->password);
            }
            
            if($req->role != "")
            {
                $user->role = $req->role;
            }

            $user->save();
            return [
                "status" => "ok",
                "msg" => "User has been updated successfully"
            ];
        }
        else
        {
            return [
                "status" => "fail",
                "msg" => "You are not permitted to do this. Access denied"
            ];
        }
    }

    public function getProfile()
    {
          $merchantId = auth()->user()->merchant_id;
        $user = User::where('merchant_id', $merchantId)->find(auth()->user()->id);
        return [
            "status" => "ok",
            "user" => $user,
        ];
    }

    public function delete(Request $req)
    {
          $merchantId = auth()->user()->merchant_id;
        $this->validate($req,[
            "userId" => "required|numeric|exists:users,id"
        ]);

        $user = User::where('merchant_id', $merchantId)->find($req->userId);
        $user->delete();
        return [
            "status" => "ok",
            "msg" => "User deleted"
        ];
    }
}
