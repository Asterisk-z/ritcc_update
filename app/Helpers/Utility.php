<?php
namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Utility
{
    
    public static function arrayKeysToCamelCase($array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            $key = Str::camel($key);
            if (is_array($value)) {
                $value = self::arrayKeysToCamelCase($value);
            }
            $result[$key] = $value;
        }
        return $result;

    }
    public static function getPagination($query): array
    {
        $page = abs($query['page']) ?: 1;
        $limit = abs($query['count']) ?: 10;
        $skip = ($page - 1) * $limit;

        return [
            'skip' => $skip,
            'limit' => $limit,
        ];
    }
    public static function takeUptoThreeDecimal($number): float
    {
        return (float) number_format((float) $number, 3, '.', '');
    }


    public static function generatePassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@$&()_';
        $password = '';

        // Loop to randomly select characters from the $characters string
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }

    public static function checkPasswordExpiry(User $user) : bool
    {
        $password = $user->passwords()->orderByDesc('id')->first();

        if(! $password)
            return true;

        if(Carbon::parse($password->created_at)->addMonths(config('app.password_expiry')) <= Carbon::now())
            return false;

        return true;
    }

    public static function checkPasswordPolicy($user, $password)
    {
        $passwords = $user->passwords()->latest()->take(config('app.unique_password'))->pluck('password');

        foreach($passwords as $old_password){
            if(Hash::check($password, $old_password))
                return false;
        }

        return true;
    }

    public static function getUsersByCategory($category)
    {
        return User::where('role_id', $category)->get();
    }

    public static function getUsersEmailByCategory($category)
    {
        return User::where('role_id', $category)->pluck('email')->toArray();
    }

    public static function saveFile($path, $file){
        if(! $file || !$path)
            return [];

        $path = $file->storeAs($path, $file->getClientOriginalName(), 'public');
        $filename = $file->getClientOriginalName();

        return [
            "name" => $filename,
            "path" => $path,
            "saved_path" => config('app.url') .'/storage/'.$path
        ];
    }

}
