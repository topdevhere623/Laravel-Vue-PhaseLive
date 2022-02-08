<?php

use App\Setting;
use Snipe\BanBuilder\CensorWords;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Given a query builder and a count indicator return the full or paginated collection
 *
 * @param $query
 * @param string $count
 * @param string $key
 *
 * @return mixed
 */
function paginateOrAll($query, $count = 'all', $key = 'created_at')
{
    switch ($count) {
        case 'all':
            return $query->latest($key)->get();
            break;

        default:
            return $query->latest($key)->paginate($count);
            break;
    }
}

/**
 * Given a page, return a vue understandable route object for the page
 *
 * @param $item
 * @return \Illuminate\Support\Collection
 */
function createVueRoute($item)
{
    return collect([
        'name' => $item->name,
        'path' => $item->path,
        'component' => $item->component->name,
        'props' => true
    ]);
}

/**
 * Return all application pages as a whole vue-router object
 *
 * @return \Illuminate\Support\Collection
 */
function getRoutes()
{
    $routes = Cache::remember('routes', now()->addDay(), function () {
        $pages = App\Page::isParent()->get(['id', 'name', 'parent_id', 'path', 'component_id']);

        return collect($pages)->map(function ($item) {
            $route = createVueRoute($item);

            $route['children'] = collect($item->children)->map(function ($item) {
                return createVueRoute($item);
            });

            return $route;
        });
    });

    return $routes;
}

/**
 * Get the application's settings as key value pairs
 *
 * @param bool $publicOnly Indicates whether to only return settings which should be publicly visible
 * @return \Illuminate\Support\Collection
 */
function getSettings($publicOnly = true)
{
    $settings = Cache::remember('settings', now()->addDay(), function () use ($publicOnly) {
        $settings = collect();
        foreach (Setting::byPublicType($publicOnly)->get() as $setting) {
            $settings->push([$setting->key => $setting->value]);
        }

        return $settings;
    });

    return $settings;
}

/**
 * Given a setting's key, return its value
 *
 * @param $key
 * @return string
 */
function setting($key)
{
    $setting = Setting::byKey($key);

    if (isset($setting->value)) {
        return $setting->value;
    }

    return "Value for setting identified by '{$key}' could not be found.";
}

/**
 * Given some uncensored text, return the censored text
 *
 * @param $text
 * @return array
 */
function censor($text)
{
    $bannedWords = Setting::byKey('banned_words')->value;

    $censor = new CensorWords;
    $censor->badwords = explode(',', $bannedWords);

    return $censor->censorString($text);
}

/**
 * Given an integer representation of a balance (pennies), format as pounds
 *
 * @param $pennies
 * @return string
 */
function penniesAsPounds($pennies)
{
    return number_format((float)($pennies / 100), 2, '.', ',');
}

/**
 * Given a model's ID and type, return the associated model
 *
 * @param $type
 * @param $id
 * @return mixed
 */
function morphToModel($type, $id)
{
    return Relation::morphMap()[$type]::find($id);
}

/**
 * Return a carbon instance representing the start of the day.
 *
 * @return \Carbon\Carbon
 */
function startOfToday()
{
    return now()->hour(0)->minute(0)->second(0);
}
