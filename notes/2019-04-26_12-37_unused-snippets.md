---
tags:
  - snippets
---

$seconds = 3600;
$cached = Cache::get('all_class_charts', false);
if (!$cached || empty($cached)) {
    $cached = Cache::remember('all_class_charts', $seconds, function () {
        return [
            'albums' => $this->getForClass('album', 7),
            'singles' => $this->getForClass('single', 7),
            'eps' => $this->getForClass('ep', 7),
            'compilations' => $this->getForClass('compilation', 7),
        ];
    });
}


$seconds = 3600;
$cached = Cache::get($class . '_chart', false);
if (!$cached || empty($cached)) {
    $cached = Cache::remember($class . '_chart', $seconds, function () use ($count) {
        return $this->filter->get($count);
    });
}
return $cached;



From DiscoveryController
// Experimenting with limit to affect the weighting.
// $releases = Release::featured()->released()->statuslive()->limit($limit)->get();
// $videos = Video::published()->limit(4)->get();
// $events = Event::datenotnull()->limit(3)->get();
// $posts = Post::bodynotnull()->limit(3)->get();
// $tracks = Track::namenotnull()->limit($limit)->get();
// $playlists = Playlist::namenotnull()->limit(5)->get();
// Checked with Matt.
// There is already a call to the merch page being triggered on the frontend but
// we decided to return to this call later on.
// $merch = Merch::namenotnull()->limit(5)->get();
// Genres may already be in the frontend store.
// Checked with Matt.
// There is already a call to the merch page being triggered on the frontend but
// we decided to return to this call later on.
// $genres = Genre::namenotnull()->limit(6)->get();



class
v-bind:class="{ 'discovery_item': (item.component !== ''), 'col-12 mt-4': (item.tier.name == 'None') }"




Idea to try the genres in different colours.
.bg-garage {
background-color: #36c4fc;
h4 {
    color: #222;
}
}

.bg-edm {
background-color: #8236fc;
h4 {
    color: #222;
}
}

.bg-experimental {
background-color: #ce36fc;
h4 {
    color: #222;
}
}

.bg-ambient {
background-color: #fc36a0;
h4 {
    color: #222;
}
}

.bg-dubstep {
background-color: #fc3636;
h4 {
    color: #222;
}
}







<template>
  <div
    :class="'masonry-item ' + item.component"
    @mouseover="hovered = item.id"
    @mouseleave="hovered = null"
  >
    <!-- This needs inner links and buttons etc -->
    <!-- <router-link
      :to="getRouterObject(item)"
      :class="'masonry-item ' + item.component"
    >-->
    <transition name="fade">
      <!-- v-if="hovered === item.id" -->
      <div class="overlay" v-if="hovered === item.id">
        <ph-button color="mint" size="small" class="foot_button" :to="getRouterObject(item)">
            View
        </ph-button>
        <div class="masonry-item-footer">
          <actions :actionable="item" @like="liked" @unlike="unliked"/>
        </div>
      </div>
    </transition>
    <img :src="imgUrl" :alt="this.item.name" class="masonry-image masonry-image-release">
    <div class="masonry-inner masonry-inner-fixed">
      <h4>Release</h4>
      <h2>{{ item.name }}</h2>
      <p>{{ limitChars(item.description) }}</p>
    </div>
    <!-- </router-link> -->
  </div>
</template>