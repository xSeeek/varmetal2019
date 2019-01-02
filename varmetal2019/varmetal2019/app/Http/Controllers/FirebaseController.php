<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FirebaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/varmetal-informatica-2019-firebase-adminsdk-97d5m-84b6a59a0e.json');
        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://varmetal-informatica-2019.firebaseio.com')
        ->create();

        $database = $firebase->getDatabase();

        $newPost = $database
        ->getReference('Varmetal/2019')
        ->push([
            'title' => 'Laravel Varmetal Informática' ,
            'category' => 'Laravel'
        ]);
        echo '<pre>';
        print_r($newPost->getvalue());
    }

}
