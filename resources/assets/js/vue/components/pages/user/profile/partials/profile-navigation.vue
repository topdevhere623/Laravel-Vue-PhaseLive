<template>
    <nav class="sub-nav">
        <ul>
            <li><router-link :to="{ name: 'profile_all' }">All</router-link></li>
            <li><router-link :to="{ name: 'profile_music' }">Music</router-link></li>
            <li><router-link :to="{ name: 'profile_releases' }">Releases</router-link></li>
            <li v-if="$can('add events')"><router-link :to="{ name: 'profile_events' }">Events</router-link></li>
            <li><router-link :to="{ name: 'profile_videos' }">Videos</router-link></li>
            <li v-if="$can('add merch')"><router-link :to="{ name: 'profile_merch' }">Merch</router-link></li>
            <li><router-link :to="{ name: 'profile_posts' }">Posts</router-link></li>
        </ul>
    </nav>
</template>

<script>
export default {

}
</script>