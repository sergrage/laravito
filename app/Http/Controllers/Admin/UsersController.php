<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UpdateRequest;
use App\UseCases\Auth\RegisterService;


class UsersController extends Controller
{

    private $register;

    public function __construct(RegisterService $register)
    {
        $this->middleware('can:admin-panel');
        // тут передается экземпляр класса сервиса в данный контроллер через конструктор
        // также и в RegisterController
        $this->register = $register;

    }

    public function index(Request $request)
    {
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $statuses = [
            User::STATUS_WAIT => 'Waiting',
            User::STATUS_ACTIVE => 'Active',
        ];

        $roles = User::rolesList();

        return view('admin.users.index', compact('users', 'statuses', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
// здесь метод СТОРе создание юзера из админки
    public function store(CreateRequest $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'status' => User::STATUS_ACTIVE,
            'password' => bcrypt(Str::random()),
        ]);

        return redirect()->route('admin.users.show', $user);
    }

    public function show(User $user)
    {
        // ищет или кидает исключение 404/ т.к User $user, то искать не надо. Laravel сам найдет.
        // $user = User::findOrFail($id);
        return view('admin.users.show', compact('user')); // передает user в вид. равносильно  ['user' = $user ]
    }

    public function edit(User $user)
    {
       $roles = [
            User::ROLE_USER => 'User',
            User::ROLE_ADMIN => 'Admin',
       ];
       return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'status', 'role']));

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }


// этот action обрабатывает кнопку варификации в виде 'admin.users.show'
    public function verify(User $user)
    {
        $this->register->verify($user->id);
        return redirect()->route('admin.users.show', $user);
    }
}
