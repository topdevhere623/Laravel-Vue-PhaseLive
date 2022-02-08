<?php

namespace App\Phase;

use Illuminate\Http\UploadedFile;

use App\Asset;
use App\File;
use App\Video;

use Storage;
use AWS;
use Illuminate\Support\Str;

class VideoTranscoder
{
    protected $file; // UploadedFile
    protected $asset, $video; // Model
    protected $originalFileModel, $thumbnailFileModel; // Model

    /**
     * Create the instance.
     *
     * @param Video $video
     * @param UploadedFile $file
     */
    public function __construct(Video $video, UploadedFile $file)
    {
        $this->video = $video;
        $this->file = $file;
    }

    /**
     * Call all the other methods
     */
    public function makeItHappen()
    {
        $this->createAssetModel();
        $this->assignAssetToVideo();
        $this->storeOriginal();
        $this->transcode();
    }

    /**
     * Create a new asset model in the database
     */
    private function createAssetModel()
    {
        $this->asset = Asset::create([
            'alt' => 'Video'
        ]);
    }

    /**
     * Assign the asset model to the video
     */
    private function assignAssetToVideo()
    {
        $this->video->asset_id = $this->asset->id;
        $this->video->save();
    }

    /**
     * Store the original video to S3 so elastic transcoder can retrieve it later on to transcode it
     */
    private function storeOriginal()
    {
        $path = Storage::putFile('video/original', $this->file);
        //unlink($this->file->getPathname()); // Not needed now because the file is not saved on the local filesystem
        $this->createOriginalFileModel($path);
    }

    /**
     * Create a file model in the database to represent the original video
     *
     * @param $path string Full path to the saved original video file
     */
    private function createOriginalFileModel($path)
    {
        $this->originalFileModel = File::create([
            'asset_id' => $this->asset->id,
            'size' => 'original',
            'path' => $path,
            'mime' => $this->file->getMimeType(),
        ]);
    }

    /**
     * Create a file model in the database to represent the master playlist of the transcoded video
     *
     * @param $path string Full path to the saved playlist file
     */
    private function createPlaylistFileModel($path)
    {
        $this->originalFileModel = File::create([
            'asset_id' => $this->asset->id,
            'size' => 'hls_playlist',
            'path' => $path,
            'mime' => 'application/x-mpegURL',
        ]);
    }

    /**
     * Create a file model in the database to represent the thumbnail of the transcoded video
     *
     * @param $path string Full path to the saved thumbnail file
     */
    private function createThumbnailFileModel($path)
    {
        $this->thumbnailFileModel = File::create([
            'asset_id' => $this->asset->id,
            'size' => 'video_thumbnail',
            'path' => $path,
            'mime' => 'image/png',
        ]);
    }

    /**
     * Create a job with AWS Elastic Transcoder to convert the original video into 'large', 'medium' and 'small' formats
     */
    private function transcode()
    {
        $elasticTranscoder = AWS::createClient('ElasticTranscoder');
        $dirName = Str::random(16);

        $outputDir = 'video/transcoded/' . $dirName . '/';

        // _tb TODO: Perhaps in the future decide on a preset to use based on the size of the original video
        $elasticTranscoder->createJob([
            'PipelineId' => env('AWS_ET_VIDEO_PIPELINEID'),
            'Input' => [
                // Input File
                'Key' => $this->originalFileModel->path,
            ],
            'OutputKeyPrefix' => $outputDir,
            'Outputs' => [
                [
                    'Key' => 'high',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_HIGH_PRESETID'),
                    'ThumbnailPattern' => 'thumbnail{count}',
                ],
                [
                    'Key' => 'med',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_MID_PRESETID'),
                ],
                [
                    'Key' => 'low',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_LOW_PRESETID'),
                ]
            ],
            'Playlists' => [
                [
                    'Format' => 'HLSv3',
                    'Name' => 'master',
                    'OutputKeys' => ['high', 'med', 'low'],
                ],
            ]
        ]);
        $this->createPlaylistFileModel($outputDir . 'master.m3u8');
        $this->createThumbnailFileModel($outputDir. 'thumbnail00001.png');
    }

    /**
     * Testing function used to run test a configuration on a test video
     */
    public static function test()
    {
        $elasticTranscoder = AWS::createClient('ElasticTranscoder');

        $elasticTranscoder->createJob([
            'PipelineId' => env('AWS_ET_VIDEO_PIPELINEID'),
            'Input' => [
                // Input File
                'Key' => 'video/original/men_in_chairs.mp4',
            ],
            'OutputKeyPrefix' => 'video/transcoded/test/',
            'Outputs' => [
                [
                    'Key' => 'high',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_HIGH_PRESETID'),
                    'ThumbnailPattern' => 'thumbnail{count}',
                ],
                [
                    'Key' => 'med',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_MID_PRESETID'),
                ],
                [
                    'Key' => 'low',
                    'SegmentDuration' => '5',
                    'PresetId' => env('AWS_ET_VIDEO_LOW_PRESETID'),
                ]
            ],
            'Playlists' => [
                [
                    'Format' => 'HLSv3',
                    'Name' => 'master',
                    'OutputKeys' => ['high', 'med', 'low'],
                ],
            ]
        ]);
    }
}