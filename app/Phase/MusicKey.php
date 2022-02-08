<?php namespace App\Phase;

/**
 * Represents all the possible musical keys that a track can be in
 *
 * Class MusicKey
 * @package App\Phase
 */
class MusicKey extends StaticData
{
    protected static $data = [
        'a' => 'A',
        'a+' => 'A# / B&flat;',
        'b' => 'B',
        'c' => 'C',
        'c+' => 'C# / C&flat;',
        'd' => 'D',
        'd+' => 'D# / D&flat;',
        'e+' => 'E# / E&flat;',
        'e' => 'E',
        'f' => 'F',
        'f+' => 'F# / G&flat;',
        'g' => 'G',
        'g+' => 'G# / A&flat;',
    ];
}