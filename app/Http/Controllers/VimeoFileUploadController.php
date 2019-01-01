<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;
use Validator;

class VimeoFileUploadController extends Controller
{
    //upload video in vimeo
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required',
        ]);

        if ($validator->fails()) {

            $code = '422';
            $responseData = $validator->errors();
            if (is_object($responseData)) {
                $responseData = $responseData->toArray();
            }
            $data = array(
                            'message' => 'Validation Error',
                            'data' => $responseData,
                            'code' => $code
                        );
            return Response::json($data, $code);
        }

        try {
            $video_id = Vimeo::connection('main')->upload($request['video']);
            
            if ($video_id) {
                $video_id = str_replace('/videos/','',$video_id);
                return redirect()->back()->with('success', "Video Uploaded Successfully")->with('id',$video_id);
            }
            return redirect()->back()->with('error', 'Sorry, Something went wrong please try again');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }    
    
    //Get permanent video link 
    public function getLink($video_id)
    {
        $video_id = '/videos/'.$video_id;
        $response = Vimeo::request($video_id, array(), 'GET');
        if($response['body']['status'] == "available")
        {
            $video_link = $response['body']['files'][0]['link'];

            //if you want specific size or quality
            foreach($response['body']['files'] as $resfile){
                if($resfile['quality']=="sd" AND $resfile['width']=="960"){
                    $video_link = $resfile['link'];
                }
            }
        }
        if ($video_link) {
            return response()->json(['message'=>'Success','link'=>$video_link],200);
        }
        return response()->json(['message'=>'Error'],400);
    }
}
