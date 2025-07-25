<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'users';
    protected $table = 'users';
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function getAllUser()
    {
        return User::all();
    }

    public function insertUser($input)
    {
        // dd($input);
        $admin = User::firstOrNew(['id' => 0]);
        $admin->name = trim($input['name']);
        $admin->email = strtolower(trim($input['email']));
        $admin->password = Hash::make($input['password_text']);
        $admin->password_text = trim($input['password_text']);
        // default admin is STAFF
        $admin->role_id = trim($input['role_id']);
        // $admin->role_menu = json_encode($input['role_menu']);
        $admin->save();
    }
    public function updateUser($input,$id)
    {
        // dd($input);
        $admin = User::firstOrNew(['id' => $id]);
        $admin->name = trim($input['name']);
        $admin->email = strtolower(trim($input['email']));
        $admin->password = Hash::make($input['password_text']);
        $admin->password_text = trim($input['password_text']);
        // default admin is STAFF
        $admin->role_id = trim($input['role_id']);
        // $admin->role_menu = json_encode($input['role_menu']);
        $admin->save();
    }
}
