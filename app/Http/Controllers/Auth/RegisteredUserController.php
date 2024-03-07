<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Yajra\DataTables\Facades\DataTables;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function index()
    {
        return Inertia::render('Setup/User');
    }

    public function fetch()
    {
        $data = User::all();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btnClasses = 'flex items-center justify-center p-1 bg-gray-800 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-md transition duration-150 ease-in-out';
                return '
                <div class="flex items-center gap-4">
                <button type="button" data-id="' . $row->id . '" class="edit ' . $btnClasses . '">
                <span class="material-symbols-outlined">
                edit
                </span>
                </button>
                
                <button type="button" data-id="' . $row->id . '" class="reset ' . $btnClasses . '">
                <span class="material-symbols-outlined">
                lock_reset
                </span>
                </button>
               
                <button type="button" data-id="' . $row->id . '" class="delete flex items-center justify-center p-1 w-10 h-10 bg-red-600 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-md transition duration-150 ease-in-out">
                <span class="material-symbols-outlined">
                delete
                </span>
                </button>
                </div>';
            })
            ->addColumn('role', function ($row) {
                if ($row->is_admin) {
                    return 'Admin';
                }
                return 'User';
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'username' => 'required|string|lowercase|max:255|unique:' . User::class,
            'is_admin' => 'nullable',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($request->password);
        $input['email_verified_at'] = Carbon::now();

        User::create($input);

        // event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
    }

    public function editProfile(Request $request)
    {
        $data = User::find($request->id);

        if ($data['is_admin']) {
            $data['is_admin'] = true;
        } else {
            $data['is_admin'] = false;
        }

        return response()->json([
            'row'   => $data
        ]);
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user)],
            'is_admin'  => 'nullable'
        ]);

        $input = $request->all();

        $user->fill($input)->save();
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user->fill($input)->save();
    }

    public function destroy(Request $request){
        $data = User::find($request->id);

        $data->delete();
    }
}
