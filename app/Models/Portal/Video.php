<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;
use Alaouy\Youtube\Facades\Youtube;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'mission_id',
        'video_key'
    ];

    /**
     * Checks whether the video belongs to the authenticated user.
     *
     * @return boolean
     */
    public function isMine()
    {
        return $this->user_id == auth()->user()->id;
    }

    /**
     * Gets the mission the video belongs to.
     *
     * @return App\Models\Missions\Mission
     */
    public function mission()
    {
        return $this->belongsTo('App\Models\Missions\Mission');
    }

    /**
     * Parses the URL and returns the video key.
     *
     * @return string
     */
    public static function parseUrl($url)
    {
        return Youtube::parseVidFromURL($url);
    }

    /**
     * Gets the YouTube video info.
     *
     * @return object
     */
    public function info()
    {
        return Youtube::getVideoInfo($this->video_key);
    }

    /**
     * Gets the full URL of the video.
     *
     * @return string
     */
    public function url()
    {
        return 'https://www.youtube.com/watch?v=' . $this->video_key;
    }
}
