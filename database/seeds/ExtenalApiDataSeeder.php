<?php

use Illuminate\Database\Seeder;
use App\Package;
use App\Bundle;
use App\Plan;

class ExtenalApiDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://extendsclass.com/mock/rest/16d445eb6c452b57e82cb5bd9eac68f7/core', []);
        $data = json_decode($response, true);
        

        //Get the ids of availble plan
        $plans = App\Plan::All();
        $plansIds = array();
        foreach($plans as $plan){
            $plansIds[$plan["name"]]=$plan["id"];
        } 

        foreach ($data as $_package) {
            $package = new Package;
            $package->id = $_package["id"];
            $package->environment = $_package["environment"];
            $package->name = $_package["name"];
            $package->type = $_package["type"];
            $package->alias = $_package["alias"];
            $package->shortDescriptionEn = $_package["shortDescriptionEn"];
            $package->price = $_package["price"];
            
            $package->save();
            $id= $package->id;
            
            foreach ($_package["bundles"] as $_bundle) {
                $bundle = new Bundle;
                
                $bundle->id = $_bundle["id"];
                $bundle->text = $_bundle["text"];
                $bundle->value = $_bundle["value"];
                $bundle->alias = $_bundle["alias"];
                $bundle->package_id = $id;
                $bundle->plan_id = $plansIds[$_bundle["planOrBundleName"]]; // getting the proper id for the plan
                $bundle->price = $_bundle["price"];
                $bundle->pending = $_bundle["pending"];
                $bundle->status = $_bundle["status"];

                $bundle->save();
            }
            
        }
    }
}
