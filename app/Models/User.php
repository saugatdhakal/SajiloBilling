<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function checkUserExites($responseEmail)
    {
        $user = DB::table('users')->where('email', '=', $responseEmail)->first();
        return ($user != null) ? true : false;
    }

    public function checkPassword($passwords)
    {
        return !Hash::check($this->password, $passwords);
    }

    public function updatePasssword($passwords)
    {
        $this->password = bcrypt($passwords);
        $this->save();
    }

    public function updateUser($request)
    {
        $this->name = $request->name;
        $this->email = $request->email;
        $this->role = $request->role;
        $this->save();
    }

    public static function createUpdateUser(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'role' => 'required|boolean'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->save();

        return $user;
    }
}
