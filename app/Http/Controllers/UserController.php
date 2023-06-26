<?php
namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Objectt;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->get();

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function show($id)
    {
        $user = $this->user->with('objects')->findOrFail($id);

        return response()->json([
            'user' => $user,
            'objects' => Objectt::get(),
        ], 200);
    }

    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);

        if ($user->role == 3){
            return response()->json([
                'msg' => "Невозможно удалить, т.к. данный пользоватлеь является Администратором"
            ], 422);
        } else {
            $user->objects()->detach();
            $user->delete();
        }

        return response()->json([
            'users' => $this->user->get(),
            'msg' => "Пользователь был успешно удален!"
        ], 200);
    }

    public function update(UserRequest $request, $id)
    {
        if(Auth::user()->role == 3){
            $user = $this->user->findOrFail($id);


            if ($request->has('objects')){
                $user->objects()->detach();
                foreach ($request->objects as $obj){
                    $user->objects()->attach($obj);
                }
            }

            if(Auth::user()->role == 3 && Auth::user()->id == $request->id){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = 3;
            }
            else{
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = $request->role;
            }

            if ($request->password !== null){
//                dd($request->password);
                $user->password = bcrypt($request->password);
            }

            $user->save();

            return response()->json([
                'msg' => 'Пользовательские данные были обновлены'
            ], 200);
        }
        else {
            return response()->json([
                'error' => 'Что то пошло не так =('
            ], 422);
        }
    }
}
