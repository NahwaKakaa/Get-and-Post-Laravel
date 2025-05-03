<?php

// app/Models/User.php 
namespace App\Models; 
 
class User 
{ 
    public static function all() 
    { 
        return session('users', []); 
    } 
 
    public static function create($data) 
    { 
        $users = session('users', []); 
        
        // Cek duplikasi email
        foreach ($users as $existingUser) {
            if ($existingUser['email'] === $data['email']) {
                return ['error' => 'Email telah tersedia.'];
            }
        }
        
        $data['id'] = count($users) + 1; 
        $users[] = $data; 
        session(['users' => $users]); 
        
        return $data; 
    } 

    // Menemukan berdasarkan id dan email untuk nomor 3
    public static function findById($id)
    {
        $users = session('users', []);
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public static function findByEmail($email)
    {
        $users = session('users', []);
        foreach ($users as $user) {
            if ($user['email'] == $email) {
                return $user;
            }
        }
        return null;
    }
}