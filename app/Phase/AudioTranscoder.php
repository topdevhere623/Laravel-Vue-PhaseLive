<?php namespace App\Phase;

use App\Asset;
use App\File;
use Aws\Laravel\AwsFacade as AWS;
use Illuminate\Support\Str;

/**
 * Class AudioTranscoder
 *
 * 'Preview': A 30 second preview of a track in low-res (accessible by anyone)
 * 'Streamable': A full length, low-res version a track to stream via the music player to users who've purchased a track
 *
 * _tb TODO: Streamable files should not be public but instead only accessible to users who have purchased a track (even if
 * they have reached their download limit). The permissions of files output by Elastic Transcoder is set in the pipeline
 * preferences from the AWS console, so you must either create a different pipeline for creating streamable files or
 * modify the visibility of the streamable file after it has been transcoded.
 *
 * @package App\Phase
 */
class AudioTranscoder
{
    private $track;
    private $previewAsset, $previewFile;
    private $streamableAsset, $streamableFile;
    private $previewOutputDir = 'previews/';
    private $streamaleOutputDir = 'streamables/';

    public function __construct($track = null)
    {
        if ($track) {
            $this->setTrack($track);
        }
    }

    public function setTrack($track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Create the AWS Elastic Transcoder job to create a preview
     *
     * @return $this
     */
    public function transcodePreview()
    {
        $filename = Str::random(40) . '.mp3';
        $elasticTranscoder = AWS::createClient('ElasticTranscoder');
        if (isset($this->track->asset->files['mp3'])) {
            $file = $this->track->asset->files['mp3']->path;
        } else {
            $file = $this->track->asset->files['wav']->path;
        }

        $elasticTranscoder->createJob([
            'PipelineId' => env('AWS_ET_AUDIO_PIPELINEID'),
            'Input' => [
                // Input File
                'Key' => $file,
                'TimeSpan' => [
                    'Duration' => '30',
                    'StartTime' => '0',
                ],
            ],
            'OutputKeyPrefix' => $this->previewOutputDir,
            'Outputs' => [
                [
                    'Key' => $filename,
                    'PresetId' => env('AWS_ET_AUDIO_PREVIEW_PRESETID'),
                ]
            ],
        ]);

        $this->createPreviewAssetModel();
        $this->createPreviewFileModel($filename);
        $this->associatePreviewWithTrack();

        return $this;
    }

    /**
     * Create the AWS Elastic Transcoder job to create a streamable file
     *
     * @return $this
     */
    public function transcodeStreamable()
    {
        $filename = Str::random(40) . '.mp3';
        $elasticTranscoder = AWS::createClient('ElasticTranscoder');
        if (isset($this->track->asset->files['mp3'])) {
            $file = $this->track->asset->files['mp3']->path;
        } else {
            $file = $this->track->asset->files['wav']->path;
        }

        $elasticTranscoder->createJob([
            'PipelineId' => env('AWS_ET_AUDIO_PIPELINEID'),
            'Input' => [
                // Input File
                'Key' => $file,
            ],
            'OutputKeyPrefix' => $this->streamaleOutputDir,
            'Outputs' => [
                [
                    'Key' => $filename,
                    'PresetId' => env('AWS_ET_AUDIO_STREAMABLE_PRESETID'),
                ]
            ],
        ]);

        $this->createStreamableAssetModel();
        $this->createStreamableFileModel($filename);
        $this->associateStreamableWithTrack();

        return $this;
    }

    private function createPreviewAssetModel()
    {
        $this->previewAsset = Asset::create([
            'alt' => 'Track Preview'
        ]);
    }

    private function createStreamableAssetModel()
    {
        $this->streamableAsset = Asset::create([
            'alt' => 'Streamable Track'
        ]);
    }

    private function createPreviewFileModel($filename)
    {
        $this->previewFile = File::create([
            'asset_id' => $this->previewAsset->id,
            'size' => 'preview',
            'path' => $this->previewOutputDir . $filename,
            'mime' => 'audio/mpeg',
        ]);
    }

    private function createStreamableFileModel($filename)
    {
        $this->streamableFile = File::create([
            'asset_id' => $this->streamableAsset->id,
            'size' => 'streamable',
            'path' => $this->streamaleOutputDir . $filename,
            'mime' => 'audio/mpeg',
        ]);
    }

    private function associatePreviewWithTrack()
    {
        $this->track->preview_id = $this->previewAsset->id;
        $this->track->save();
    }

    private function associateStreamableWithTrack()
    {
        $this->track->streamable_id = $this->streamableAsset->id;
        $this->track->save();
    }
}