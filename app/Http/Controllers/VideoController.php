<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

use App\Events\User\UploadedVideo;

use App\Phase\VideoTranscoder;

use App\Video;


class VideoController extends Controller
{
    /**
     * Create the video model in the database
     *
     * @param Request $request
     * @return Video|\Illuminate\Database\Eloquent\Model
     */
    public function createVideo(Request $request)
    {
        $video = Video::create([
            'user_id' => $request->user()->id,
        ]);
        $video->refresh();
        session()->put('uploading_video_id', $video->id);
        session()->save();
        return $video;
    }

    /**
     * Handles the file upload
     *
     * @param Request $request
     * @param FileReceiver $receiver
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws UploadMissingFileException
     *
     */
    public function uploadFile(Request $request, FileReceiver $receiver)
    {
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();
        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            // save the file and return any response you need
            $this->saveFile($request, $save->getFile());
        }
        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);
    }

    /**
     * Save / Update the title and description of a video.
     *
     * @param Request $request
     * @param $videoID
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(Request $request, $videoID)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        $video = Video::findOrFail($videoID);
        if ($video->user->id == $request->user()->id) {
            $video->fill([
                'title' => $data['title'],
                'description' => $data['description'],
            ])->save();
            return $video;
        } else {
            abort(403);
        }
    }

    /**
     * Saves & transcodes the file
     *
     * @param Request $request
     * @param UploadedFile $file
     *
     * @return void
     */
    protected function saveFile(Request $request, UploadedFile $file)
    {
        $videoID = session()->get('uploading_video_id');
        $video = Video::find($videoID);
        // _tb TODO: Uncomment these lines. If they are commented, uploaded videos will never be uploded and transcoded!
        $transcoder = new VideoTranscoder($video, $file);
        $transcoder->makeItHappen();
        event(new UploadedVideo($video));
    }
}
