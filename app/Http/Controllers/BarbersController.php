<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use App\Models\Barber;
use App\Models\BarberPhotos;
use App\Models\BarberServices;
use App\Models\BarberTestimonial;
use App\Models\BarberAvailabillity;






class BarbersController extends Controller
{
    private $loggedUser;
  public function __contruct(){
      $this->middleware('auth:api');
      $this->loggedUser = auth()->user();

  }
  private function searcGeo($address){
      $key = env('MAPS_KEY',null);

      $address = urlencode($andress);

      $url = 'https://maps.googleapis.com/maps/api/geocode/json?andress='.$address.'&key='.$key;
       
      $ch = curl_init();
      curl_setopt($ch , CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      $res = curl_exec($ch);
      return json_decode($res , true);
  }

  public function list(Request $request){
      $array = ['error' => ''];
      $lat   = $request->input('lat');
      $lng   = $request->input('lng');
      $city  = $request->input('city');
      $offset  = $request->input('offset');
      if(!$offset){
          $offset =0;
      }
      
      if(!empty($city)){
          $res = $this->searchGeo($city);
          if(count($res['results']) > 0){
              $lat = $res['results'][0]['geometry']['location']['lat'];
              $lng = $res['results'][0]['geometry']['location']['lng'];

          }

      }elseif(!empty($lat) && !empty($lng)){
    
         $res = $this->searcGeo($lat.','.$lng);
        
         if(count($res['results']) > 0){
             $city = $res['results'][0]['formatted_address'];
         }
      }else{
          $lat ='-23.5630907';
          $lng = '-46.6682795';
          $city = 'São Paulo';

      }


      $barbers = Barber::select(Barber::raw('*, SQRT(
        POW(69.1 * (latitude - '.$lat.'), 2)+
        POW(69.1 * ('.$lng.' - longitude) * COS(latitude / 57.3), 2)) AS distance'))
         ->havingRaw('distance < ?',[10])
         ->orderBy('distance','ASC')
         ->offset($offset)
         ->limit(5)
         ->get();
   foreach($barbers as $bkey => $bvalue ){
       $barbers[$bkey]['avatar'] = url('media/avatars/'.$barbers[$bkey]['avatar']);


   }
      $array['data'] = $barbers;
       $array['loc'] = 'São Paulo';

       return $array;

  }
  
 public function one($id){
     $array = ['error'=> ''];

     $barber = Barber::find($id);

     if($barber){
      $barber['avatar'] = url('media/avatars/'.$barber['avatar']);
      $barber['favorited'] = false ;
      $barber['photos']= [];
      $barber['services']= [];
      $barber['testimonials']= [];
      $barber['available']= [];

//pegando os favoritos
$cFavorite = UserFavorite::where('id_user',$this->loggedUser->id)
->where('id_barber', $barber->id)
->count();
if($cFavorite > 0){
    $barber['favorited'] = true;
}


      //pegando as fotos  
       $barber['photos'] = BarberPhotos::select(['id','url'])
       ->where('id_barber', $barber->id)
       ->get();
      foreach($barber['photos'] as $bpkey => $bpvalue){
          $barber['photos'][$bpkey]['url'] = url('media/upload/s'.$barber['photos'][$bpkey]['url']);

      }

      //pegando os serviços do Babeiro
      $barber['services'] = BarberServices::select(['id','name','price'])
      ->where('id_barber',$barber->id)
      ->get();
            
//pegando os depoimentos do Babeiro
$barber['testimonials'] =BarberTestimonial::select(['id','name','rate','body'])
->where('id_barber',$barber->id)
->get();


// pegando a disponibilidade
$availability = [];

// - pegando a disponibilidade crua
$avails = BarberAvailabillity::where('id_barber',$barber->id)->get();
foreach($avails as $item){
    $availWeekDays[$item['weekday']] 
    = explode(',',$item['hours']);
}

//pegar os agendamentos do  proximos20 dias
$appointments = [];

$appQuery = UserAppointment::where('id_barber',$barber->id)
->whereBetween('ap_datetime',[
    date('Y-m-d').'00:00:00',
    date('Y-m-d',strtotime('+20 days')).'23:59:59'
])
->get();

foreach($appQuery as $appItem){
    $appointments[] = $appItem['ap_datetime'];

}

// - Gera disponibilidade real

for($q=0; $q<20; $q++){
    $timeItem = strtotime('+'.$q.'days');
    $weekDay = date('w', $timeItem);

    if(in_array($weekDay, array_keys($availWeekDays))){
        $hours = [];

        $dayItem = date('y-m-d',$timeItem);

        foreach($availWeekDays[$weekDay] as $hourItem){
            $dayFormated = $dayItem.' '.$hourItem.':00';
            if(!in_array($dayFormated, $appointments)){
                $hours[] = $hourItem;
            }
     }

     if(count($hours) > 0){
         $availability[] = [
             'date'=> $dayItem,
             'hours'=> $hours
         ];
     }
    }

}


$barber['available'] = $availability;

 $array['data'] = $barber;

     }else{
         $array['error'] = 'barbeiro nao existe';
      return $array;
        }

     return $array;
 }

}
