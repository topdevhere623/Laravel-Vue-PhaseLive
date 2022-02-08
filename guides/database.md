# This file attempts to outline and describe the purpose of all database tables.

## actions
Used to store events, but not all events. This table is used primarily to generate feeds for users. Only events which
have 'ActionRegister' associated with them are saved here. See class `App\Action` and namespace
`App\Listeners\ActionRegisters`.

## assets
Used to group unique assets (_NOT_ individual files, see the `files` table for more information)

## cartables
Used to assign tracks / releases to a registered user's shopping cart. Also stores what download format the user set.

## categories
Stores categories for news articles

## category_news
Link table to assign categories to news articles

## comments
Stores all comments

## components
Stores names for components which can be assigned to routes in the admin panel. (Basically a list of components which
can be used in `router-view`'s). Components in this table must also have the alias set in the `aliases` variable in
`resources/assets/js/vue/router/routes.js`. See also the `pages` table.

## downloads
Stores what tracks users have permission to download, and how many times they have been downloaded. For example, if a
user buys a release with 10 tracks on it in WAV format, 10 records will be created, one for each track, indicating that
the user is allowed to download the track and specifying that it can be downloaded in WAV format. We track how many times each
track has been downloaded because currently there is a limit of 3 downloads per track.

## events
Stores user-defined events (like concerts / gigs etc.)

## faq_categories
Stores categories for faqs.

## faqs
Stores FAQ's

## files
Relates to `assets`. Each record in this table references a single object stored in storage. Multiple `files` can
link to one `asset`. For example, when a user uploads an avatar, it will be stored in multiple sizes, which will result
in multiple `files`, but the avatar is still considered one `asset`, as all the files are still technically the same
file even though they have been resized/cropped.

## followers
Stores which users follow other users

## genres
Musical genres which tracks / releases can be assigned to, and which users can set as their musical tastes.

## likes
Stores which users like items (tracks/releases/news articles etc)

## messages
Stores messages sent between users using the internal messaging system 

## meta
Store metadata for pages (I've never used this table lol but you might find a use for it)

## migrations
Laravel specific table

## model_has_permissions
Table created by the `spatie/laravel-permission` package. Each row assigns a specific `permission` to a specific
instance of a model, e.g. a specific `App\User`. The `morphMap` method in `AppServiceProvider` is used to map fully
qualified models to strings, e.g. the `App\User` model will be saved as just `user`.

## model_has_roles
Table created by the `spatie/laravel-permission` package. Each row assigns a specific `role` to a specific instance of a
model, e.g. a specific `App\User`. See `morphMap` info above.

## news
Stores news articles

## notification_settings
Stores boolean values for notification options selected by user to determine what notifications to send to them.

## orderables
Link table storing which orderable items have been ordered in which format and the actual price paid. Links to `orders`
table.

## orders
Stores orders. Each order represents one transaction to buy a single or group of tracks / releases.

## pages
Assigns `components` to paths. This table, in conjunction with the `components` table is single handedly used to
generate the entire Vue routes JSON object.

## password_resets
Used to store password resets. I've not actually done any work on password resetting yet, so feel free to modify this
table as you wish as it's not been integrated yet.

## permissions
Table created by the `spatie/laravel-permission` package. Used to store names of permissions which can be checked
throughout the application.

## playlist_track
Link table used to assign tracks to playlists.

## playlists
Stores user created playlists.

## posts
Stores user posts ('status updates') which can be posted on ones own 'wall' or on another users'.

## release_track_genres
Assigns tracks / releases to genres.

## releases
Stores information on musical releases.

## reports
Stores user submitted reports, which are submitted when a user thinks a certain piece of content breaks the rules.

## role_has_permissions
Table created by the `spatie/laravel-permission` package. Each row assigns a specific `permission` to a specific `role`.

## roles
Table created by the `spatie/laravel-permission` package. Used to store names of 'roles' which can be assigned to
specific model instances. When a model instance is assigned a role it has all the permissions assigned to that role.
E.g. if I have a `role` called 'moderator', I can assign it a `permission` called `delete comments`. Then if I assign
the `role` 'moderator' to model `App\User` with ID 1, then user 1 will be able to delete comments.

## settings
Global site wide settings, which can be public (sent to all clients via JSON), or private which are used only in the
backend.

## shares
Stores what shareables have been shared by who and what message they wrote when sharing

## subscription_plans
Stores information about different subscription plans which can be subscribed to by users.

## subscriptions
Assigns users to subscriptions plans.

## threads
Used by the messaging system to group users and messages into threads.

## tracks
Stores information on musical tracks.

## users
Stores information on users.

## videos
Stores videos uploaded by professional premium members