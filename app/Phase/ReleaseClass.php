<?php namespace App\Phase;

/**
 * Class ReleaseClass
 *
 * Represents all the possible classes that a release can be
 *
 * @package App\Phase
 */
class ReleaseClass extends StaticData
{
    protected static $data = [
        'ep' => 'EP/LP',
        'single' => 'Single',
        'album' => 'Album',
        'sample' =>'Sample Pack',
        'compilation' => 'Compilation',
    ];
}