<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;
use App\Http\Controllers\CRUDManager;


Route::any("user/register", function(){
    //create user
    $faker  = Faker\Factory::create();
    
    $user= new User();
    $user->name = $faker ->name;
    $user->email = $faker->unique()->safeEmail;
    $user->password= Hash::make($faker->password);
    if($user->save()){
       $token =$user->createToken("auth_token")->plainTextToken; // token for auth ansd will store in database
        return response()->json(["success" =>"success", "data"=>$user, 
        "token"=> $token, // use this token to authenticate the user for upcoming request that we create
         "message"=>"User creates successfully"]);
    }else
    return response()->json(["success"=> "failed", "message"=> "Failed to create user"]);
});


//main part
Route:: prefix("product")->middleware("auth:sanctum")->group(function(){
//create new route inside this 
Route::post("create",[CRUDManager::class, 'create']);
Route::post('read',[CRUDManager::class,'read']);
Route::post('update/{id}',[CRUDManager::class,'update']);
Route::post('delete/{id}',[CRUDManager::class,'delete']);
});