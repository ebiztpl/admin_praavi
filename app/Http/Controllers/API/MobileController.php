<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\API\MobileLogin;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Actions\Auth\OtpLogin;
use App\Http\Requests\Auth\OtpLoginRequest;


class MobileController extends Controller
{
    public function __construct()
    {
        $this->middleware('feature.available:auth.enable_otp_login')->only(['otpRequest', 'otpConfirm']);
    }

    public function login_app(OtpLoginRequest $request, OtpLogin $otpLogin)
    {

      
        $msg = $otpLogin->request($request);
        print_r($msg); die;


        //return response()->success(['message' => trans('auth.login.otp_sent')]);
        

        return [
            "status" => 1,
            'message' => 'Success',
            "data" => $msg
        ];
    }

    public function home_data(Request $request)
    {

        
        try {
            
            return [
                "status" => 1,
                'message' => 'Success',
                "data" => $data
            ];
        }
        catch (\Exception $exception) {
            return response()->json([
                'status' =>0,
                "data" =>'',
                'message' => $exception instanceof ModelNotFoundException ? trans('default.resource_not_found', ['resource' => trans('default.user')]) : $exception->getMessage()
            ], 400);
        }

    }
    





    public function punch_in(Request $request)
    {
       
        $user_id = $request->get('user_id');

        $shift_id = DB::table('upcoming_user_working_shifts')
            ->where('user_id',$user_id)
            ->value('working_shift_id');

        $start_at = WorkingShiftDetails::where('working_shift_id',$shift_id??1)->where('is_weekend', 0)->limit(1)->value('start_at');  


       $setting = $this->att->getSettingFromKey('attendance')('punch_in_time_tolerance');      

       $setting = (int)$setting;

       if (!$start_at) {
        $behaviour= 'regular';
       }

        $workShiftTime = $this->carbon($this->att->getToday()->toDateString() . ' ' . $start_at, 'UTC')->parse();

        if ($this->att->getNow()->isBefore($workShiftTime)) {
            $behaviour ='early';
        }

        if ($this->att->getNow()->isAfter($workShiftTime->addMinutes($setting))) {
            $behaviour =  'late';
        }


        $validator = Validator::make($request->all(), ['picture' => 'required|image|mimes:png,jpg,jpeg|max:2048']);
    
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'picture should be png,jpg,jpeg'
            ]);
        }


        try {

            $today = date('Y-m-d');
            $check_today = DB::table('attendances')->where('in_date',$today)->value('id'); 
            if($check_today > 0)
            {
                DB::table('attendance_details')->insert([
                    'in_time' => $request->get('in_time'),
                    'attendance_id' => $check_today,
                    'in_ip_data' => $request->get('in_ip_data'),
                    'status_id' => 7,
                    'created_at' => carbon::now(),
                    'updated_at' => carbon::now()
                ]);

                return response()->json([
                    'status' => true,
                    'attendance_id' =>$check_today,
                    'message' => __t('punched_in_successfully')
                ]);
            }

            else
            {
                $imageName = time().'.'.$request->picture->extension();
                $request->picture->move(public_path('attendance'), $imageName);
    
                DB::table('attendances')->insert([
                        'in_date' => $request->get('in_date'),
                        'user_id' => $user_id,
                        'status_id' => 7,
                        'working_shift_id' => 1,
                        'behavior' => $behaviour,
                        'tenant_id' => 1,
                        'picture' =>$imageName,
                        'created_at' => carbon::now(),
                        'updated_at' => carbon::now()
                    ]);
    
                    $id = DB::getPdo()->lastInsertId();
    
                    if($id>0)
                    {
                        DB::table('attendance_details')->insert([
                            'in_time' => $request->get('in_time'),
                            'attendance_id' => $id,
                            'in_ip_data' => $request->get('in_ip_data'),
                            'status_id' => 7,
                            'created_at' => carbon::now(),
                            'updated_at' => carbon::now()
                        ]);
                    }
    
    
                    return response()->json([
                        'status' => true,
                        'attendance_id' =>$id,
                        'message' => __t('punched_in_successfully')
                    ]);
            }
        } catch (\Throwable $th) {
        
                return response()->json([
                    'status' => false,
                    'attendance_id' =>0,
                    'message' => 'something went wrong'
                ]);
        }  
    }



    public function punch_out(Request $request)
    {
       
        $attendance_id = $request->get('attendance_id');

        try {

            DB::table('attendance_details')->where('attendance_id',$attendance_id)->update([
                'out_time' => $request->get('out_time'),
                'out_ip_data' => $request->get('out_ip_data'),
            ]);
            
            return response()->json([
                'status' => true,
                'message' => 'Done'
            ]);

        } catch (\Throwable $th) {
           
                return response()->json([
                    'status' => false,
                    'message' => 'something went wrong'
                ]);
        }

      
       


    }



    



}
