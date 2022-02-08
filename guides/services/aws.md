Consult `.env.example` for a list of environment variables which should be set.

NOTE: At the time of writing, Elastic Transcoder is only supported in the EU in Ireland, so for lower costs you should
create your S3 bucket in this region.

### AWS S3 Configuration
Create a bucket which has the following directory structure:
 * avatars/ *__(stores avatars)__*
 * banners/ *__(stores profile banners for pro users)__*
 * covers/ *__(stores album art for releases)__*
 * images/ *__(stores other/misc images)__*
    * events/ *__(stores event images)__*
 * previews/  *__(stores preview clips of tracks)__*
 * streamables/  *__(stores streamable tracks for users which have purchased associated track)__*
 * tracks/ *__(stores tracks in original quality which can be downloaded by users after purchase)__*
 * videos/
    * original/ *__(stores videos in original quality)__*
    * transcoded/  *__(stores transcoded HLS video parts and playlists)__*
 
  
### AWS Elastic Transcoder Configuration
Phase needs 1 pipeline for transcoding uploaded mp3 files into low-res 30 second preview clips & full length streamable
clips, and one pipleline for transcoding videos. When configuring the pipeline make sure to add a permission for
'Transcoded Files and Playlists' which grants public Open/Download permission to the media.
 
For these jobs, I used the "System preset: Audio MP3 - 128k" preset.