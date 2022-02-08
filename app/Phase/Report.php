<?php

namespace App\Phase;

use App\{Comment, PhaseModel, Track, Release, Post, Thread};

class Report
{
    /**
     * Returns the reportable model
     *
     * @param   string  $type 
     * @param   int     $id    
     *
     * @return  PhaseModel|null
     */
    public static function getReportable($type, $id): ?PhaseModel
    {
        $reportable = null;
        switch ($type) {
            case 'comment':
                $reportable = Comment::find($id);
                break;
            case 'track':
                $reportable = Track::find($id);
                break;
            case 'release':
                $reportable = Release::find($id);
                break;
            case 'post':
                $reportable = Post::find($id);
            case 'thread':
                $reportable = Thread::find($id);
                break;
        }

        return $reportable;
    }
}
